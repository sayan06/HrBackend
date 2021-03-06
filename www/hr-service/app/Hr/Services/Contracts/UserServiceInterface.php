<?php

namespace App\Hr\Services\Contracts;

use App\Hr\Models\Role;
use App\Hr\Models\User;
use App\Hr\Models\UserInformation;

interface UserServiceInterface
{
    public function createUser(array $attributes): User;

    public function assignRole(User $user, Role $role): User;

    public function createAuthToken(User $user): string;

    public function refreshAuthToken(User $user): string;

    public function createUserDetails(User $user, array $attributes = []);

    public function getLikability(User $user, array $attributes = []);

    public function updateUserDetails(UserInformation $userInfo, array $attributes = []);
}
