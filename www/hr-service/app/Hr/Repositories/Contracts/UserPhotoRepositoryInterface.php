<?php

namespace App\Hr\Repositories\Contracts;

use App\Hr\Models\UserPhoto;

interface UserPhotoRepositoryInterface
{
    public function createPhotos(array $userPhotoDetails): bool;
    public function update(UserPhoto $userPhoto, array $userPhotoDetails): UserPhoto;
    public function delete(UserPhoto $userPhoto): bool|null;
}
