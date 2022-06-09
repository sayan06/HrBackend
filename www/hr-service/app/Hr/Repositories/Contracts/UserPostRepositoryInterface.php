<?php

namespace App\Hr\Repositories\Contracts;

use App\Hr\Models\UserPost;

interface UserPostRepositoryInterface
{
    public function create(array $userPostDetails): UserPost;
    public function update(UserPost $userPost, array $userPostDetails): UserPost;
}
