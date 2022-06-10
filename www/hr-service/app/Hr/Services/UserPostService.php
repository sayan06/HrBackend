<?php

namespace App\Hr\Services;

use App\Hr\Models\User;
use App\Hr\Models\UserPost;
use App\Hr\Models\UserPostMedia;
use App\Hr\Repositories\Contracts\UserMediaRepositoryInterface;
use App\Hr\Repositories\Contracts\UserPostRepositoryInterface;
use App\Hr\Services\Contracts\UserPostServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

final class UserPostService implements UserPostServiceInterface
{
    private UserMediaRepositoryInterface $userMediaRepo;
    private UserPostRepositoryInterface $userPostRepo;

    public function __construct(
        UserMediaRepositoryInterface $userMediaRepo,
        UserPostRepositoryInterface $userPostRepo,
    ) {
        $this->userMediaRepo = $userMediaRepo;
        $this->userPostRepo = $userPostRepo;
    }

    public function create(User $user, array $postData, $media = null): UserPost
    {
        try {
            DB::beginTransaction();

            $userPost = $this->userPostRepo->create([
                'description' => data_get($postData, 'description'),
                'hashtags' => data_get($postData, 'hashtags'),
                'title' => data_get($postData, 'title'),
                'user_id' => $user->id,
                'post_visibility_id' => data_get($postData, 'post_visibility_id'),
            ]);

            $postMedia = [];

            foreach ($media as $data) {
                $extension = $data->getClientOriginalExtension();
                $randomNumber = mt_rand();
                $customName = "user-{$user->id}-profile-{$randomNumber}.{$extension}";
                $path = $data->storeAs('public/media', $customName);

                $userMedia = $this->userMediaRepo->create([
                    'is_default' => false,
                    'is_enabled' => true,
                    'name' => $customName,
                    'path' => $path,
                    'type' => data_get($postData, 'media_type'),
                    'user_id' => $user->id,
                ]);

                $postMedia[] = [
                    'media_id' => $userMedia->id,
                    'post_id' => $userPost->id
                ];
            }

            UserPostMedia::insert($postMedia);

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            throw $ex;
        }

        return $userPost->load('media', 'user', 'visibility');
    }

    public function update(UserPost $userPost, array $postData, $media = null): UserPost
    {
        try {
            DB::beginTransaction();

            $this->userPostRepo->update(
                $userPost,
                [
                    'description' => data_get($postData, 'description'),
                    'hashtags' => data_get($postData, 'hashtags'),
                    'post_visibility_id' => data_get($postData, 'post_visibility_id'),
                    'title' => data_get($postData, 'title'),
                ]
            );

            if (!empty($media)) {
                $postMedia = [];

                $userId = $userPost->user_id;
                $this->deletePostData($userPost);

                foreach ($media as $data) {
                    $extension = $data->getClientOriginalExtension();
                    $randomNumber = mt_rand();
                    $customName = "user-{$userId}-profile-{$randomNumber}.{$extension}";
                    $path = $data->storeAs('public/media', $customName);


                    $userMedia = $this->userMediaRepo->create([
                        'is_default' => false,
                        'is_enabled' => true,
                        'name' => $customName,
                        'path' => $path,
                        'type' => data_get($postData, 'media_type'),
                        'user_id' => $userId,
                    ]);

                    $postMedia[] = [
                        'media_id' => $userMedia->id,
                        'post_id' => $userPost->id
                    ];
                }

                UserPostMedia::insert($postMedia);
            }

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            throw $ex;
        }

        return $userPost->load('media', 'user', 'visibility');
    }

    public function delete(UserPost $userPost): UserPost
    {
        try {
            DB::beginTransaction();

            $this->deletePostData($userPost);
            $userPost->delete();

            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return $userPost;
    }

    private function deletePostData(UserPost $userPost): void
    {
        $postMedia = $userPost->media;

        foreach ($postMedia as $media) {
            Storage::delete($media->path);
        }

        $userPost->media()->delete();
        UserPostMedia::where('post_id', $userPost->id)->delete();
    }
}
