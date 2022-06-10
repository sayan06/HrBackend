<?php

namespace App\Hr\Repositories\Contracts;

use App\Hr\Models\UserMedia;

interface UserMediaRepositoryInterface
{
    public function createMany(array $userMediaDetails): bool;
    public function create(array $userMediaDetails): UserMedia;
    public function update(UserMedia $userMedia, array $userMediaDetails): UserMedia;
    public function delete(UserMedia $userMedia): bool|null;
}
