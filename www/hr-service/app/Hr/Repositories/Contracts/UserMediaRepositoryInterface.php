<?php

namespace App\Hr\Repositories\Contracts;

use App\Hr\Models\UserMedia;

interface UserMediaRepositoryInterface
{
    public function createMedia(array $userMediaDetails): bool;
    public function update(UserMedia $userMedia, array $userMediaDetails): UserMedia;
    public function delete(UserMedia $userMedia): bool|null;
}
