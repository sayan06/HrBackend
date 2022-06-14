<?php

namespace App\Hr\Repositories\Contracts;

use App\Hr\Models\User;

interface IdealMatchRepositoryInterface
{
    public function createMany(User $user, array $matchData): bool;

}
