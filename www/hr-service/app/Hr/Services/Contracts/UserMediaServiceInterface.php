<?php

namespace App\Hr\Services\Contracts;

use App\Hr\Models\User;
use App\Hr\Models\UserMedia;
use Illuminate\Support\Collection;

interface UserMediaServiceInterface
{
    public function create(User $user, array $mediaData, $media):Collection;
    public function update(UserMedia $userMedia, array $photoDetails, $photo = null): UserMedia;
    public function delete(UserMedia $userMedia): UserMedia;
}
