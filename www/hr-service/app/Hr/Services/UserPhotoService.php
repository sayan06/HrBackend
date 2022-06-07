<?php

namespace App\Hr\Services;

use App\Hr\Models\User;
use App\Hr\Models\UserPhoto;
use App\Hr\Repositories\Contracts\UserPhotoRepositoryInterface;
use App\Hr\Services\Contracts\UserPhotoServiceInterface;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

final class UserPhotoService implements UserPhotoServiceInterface
{
    private $userPhotoRepo;

    public function __construct(UserPhotoRepositoryInterface $userPhotoRepo)
    {
        $this->userPhotoRepo = $userPhotoRepo;
    }

    public function create(User $user, $photos): Collection
    {
        try {
            DB::beginTransaction();

            $userPhotoDetails = [];

            foreach ($photos as $photo) {
                $extension = $photo->getClientOriginalExtension();
                $randomNumber = mt_rand();
                $customName = "user-{$user->id}-profile-{$randomNumber}.{$extension}";
                $path = $photo->storeAs('public/photos', $customName);

                $userPhotoDetails[] = [
                    'is_default' => false,
                    'is_enabled' => true,
                    'name' => $customName,
                    'path' => $path,
                    'type' => 'profile',
                    'user_id' => $user->id,
                ];
            }

            UserPhoto::where([
                'user_id' => $user->id,
                'type' => 'profile',
            ])->delete();

            $this->userPhotoRepo->createPhotos($userPhotoDetails);

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();

            throw $ex;
        }

        return UserPhoto::where('user_id', $user->id)->with('user')->get();
    }

    public function update(UserPhoto $userPhoto, array $photoDetails, $photo = null): UserPhoto
    {
        try {
            DB::beginTransaction();

            $isDefault = data_get($photoDetails, 'is_default');
            $isEnabled = $isDefault == true ? true : data_get($photoDetails, 'is_enabled');

            if ($isDefault) {
                UserPhoto::where('user_id', $userPhoto->user_id)->update(['is_default' => false]);
            }

            $path = null;
            $name = null;

            if (!empty($photo)) {
                $extension = $photo->getClientOriginalExtension();
                $randomNumber = mt_rand();
                $name = "user-{$userPhoto->user_id}-profile-{$randomNumber}.{$extension}";
                $path = $photo->storeAs('public/photos', $name);

                Storage::delete($userPhoto->path);
            }

            $userPhotoDetails = [
                'is_default' => $isDefault,
                'is_enabled' => $isEnabled,
                'name' => $name,
                'path' => $path,
            ];

            $userPhoto = $this->userPhotoRepo->update($userPhoto, $userPhotoDetails);

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            throw $ex;
        }

        return $userPhoto->load('user');
    }

    public function delete(UserPhoto $userPhoto): UserPhoto
    {
        try {
            DB::beginTransaction();
            $this->userPhotoRepo->delete($userPhoto);

            if ($userPhoto->is_default) {
                UserPhoto::where([
                    'user_id' => $userPhoto->user_id,
                    'is_enabled' => true,
                ])->first()?->update(['is_default' => true]);
            }

            Storage::delete($userPhoto->path);

            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return $userPhoto->load('user');
    }
}
