<?php

namespace App\Hr\Repositories\Contracts;

use App\Hr\Models\User;
use Carbon\Carbon;

interface PasswordResetRepositoryInterface
{
    public function createOrUpdateResetToken(User $user);

    public function createExtendedResetToken(User $user, Carbon $expireTime);
}
