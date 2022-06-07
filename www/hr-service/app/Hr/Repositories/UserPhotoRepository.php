<?php

namespace App\Hr\Repositories;

use App\Hr\Models\Media;
use App\Hr\Models\UserPhoto;
use App\Hr\Repositories\Contracts\UserPhotoRepositoryInterface;

final class UserPhotoRepository extends BaseRepository implements UserPhotoRepositoryInterface
{
    public function __construct()
    {
        $this->model = Media::class;
    }

    public function createPhotos(array $userPhotoDetails): bool
    {
        return UserPhoto::insert($userPhotoDetails);
    }

    public function update(UserPhoto $userPhoto, array $userPhotoDetails): UserPhoto
    {
        $userPhoto->is_default = data_get($userPhotoDetails, 'is_default') ?? $userPhoto->is_default;
        $userPhoto->is_enabled = data_get($userPhotoDetails, 'is_enabled') ?? $userPhoto->is_enabled;
        $userPhoto->name = data_get($userPhotoDetails, 'name') ?? $userPhoto->name;
        $userPhoto->path = data_get($userPhotoDetails, 'path') ?? $userPhoto->path;

        $userPhoto->update();

        return $userPhoto;
    }

    public function delete(UserPhoto $userPhoto): bool|null
    {
        return $userPhoto->delete();
    }
}
