<?php

namespace App\Hr\Services;

use App\Hr\Models\User;
use App\Hr\Models\UserMedia;
use App\Hr\Repositories\Contracts\UserMediaRepositoryInterface;
use App\Hr\Services\Contracts\UserMediaServiceInterface;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

final class UserMediaService implements UserMediaServiceInterface
{
    private $userMediaRepo;

    public function __construct(UserMediaRepositoryInterface $userMediaRepo)
    {
        $this->userMediaRepo = $userMediaRepo;
    }

    public function create(User $user, array $mediaData, $media): Collection
    {
        try {
            DB::beginTransaction();

            $userMediaDetails = [];

            foreach ($media as $data) {
                $extension = $data->getClientOriginalExtension();
                $randomNumber = mt_rand();
                $customName = "user-{$user->id}-profile-{$randomNumber}.{$extension}";
                $path = $data->storeAs('public/media', $customName);

                $userMediaDetails[] = [
                    'is_default' => false,
                    'is_enabled' => true,
                    'name' => $customName,
                    'path' => $path,
                    'type' => data_get($mediaData, 'type'),
                    'user_id' => $user->id,
                ];
            }

            $this->userMediaRepo->createMedia($userMediaDetails);

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();

            throw $ex;
        }

        return UserMedia::where('user_id', $user->id)->with('user')->get();
    }

    public function update(UserMedia $userMedia, array $mediaDetails, $media = null): UserMedia
    {
        try {
            DB::beginTransaction();

            $isDefault = data_get($mediaDetails, 'is_default');
            $isEnabled = $isDefault == true ? true : data_get($mediaDetails, 'is_enabled');

            if ($isDefault) {
                UserMedia::where('user_id', $userMedia->user_id)->update(['is_default' => false]);
            }

            $path = null;
            $name = null;

            if (!empty($media)) {
                $extension = $media->getClientOriginalExtension();
                $randomNumber = mt_rand();
                $name = "user-{$userMedia->user_id}-profile-{$randomNumber}.{$extension}";
                $path = $media->storeAs('public/media', $name);

                Storage::delete($userMedia->path);
            }

            $userMediaDetails = [
                'is_default' => $isDefault,
                'is_enabled' => $isEnabled,
                'name' => $name,
                'path' => $path,
            ];

            $userMedia = $this->userMediaRepo->update($userMedia, $userMediaDetails);

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            throw $ex;
        }

        return $userMedia->load('user');
    }

    public function delete(UserMedia $userMedia): UserMedia
    {
        try {
            DB::beginTransaction();
            $this->userMediaRepo->delete($userMedia);

            if ($userMedia->is_default) {
                UserMedia::where([
                    'user_id' => $userMedia->user_id,
                    'is_enabled' => true,
                ])->first()?->update(['is_default' => true]);
            }

            Storage::delete($userMedia->path);

            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return $userMedia->load('user');
    }
}
