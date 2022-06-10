<?php

namespace App\Hr\Services\Contracts;

use App\Hr\Models\User;
use App\Hr\Models\UserPost;

interface UserPostServiceInterface
{
    public function create(User $user, array $postData, $media = null): UserPost;
    public function update(UserPost $userPost, array $postData, $media = null): UserPost;
    public function delete(UserPost $userPost): UserPost;
}
