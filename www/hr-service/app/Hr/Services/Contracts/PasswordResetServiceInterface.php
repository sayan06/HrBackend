<?php

namespace App\Hr\Services\Contracts;

use App\Hr\Models\PasswordReset;
use App\Hr\Models\User;

interface PasswordResetServiceInterface
{
    public function findUser(string $find): User;

    public function sendResetEmail(User $user): PasswordReset;

    public function resetPasswordByToken(string $token, string $password): User;
}
