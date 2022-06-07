<?php

namespace App\Hr\Services\Contracts;

use App\Hr\Models\User;
use App\Hr\Models\UserPhoto;
use Illuminate\Support\Collection;

interface UserPhotoServiceInterface
{
    public function create(User $user, $photos):Collection;
    public function update(UserPhoto $userPhoto, array $photoDetails, $photo = null): UserPhoto;
    public function delete(UserPhoto $userPhoto): UserPhoto;
}
