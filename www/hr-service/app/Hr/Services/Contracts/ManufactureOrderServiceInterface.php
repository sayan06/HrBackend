<?php

namespace App\Hr\Services\Contracts;

use App\Hr\Models\ManufactureOrder;
use App\Hr\Models\User;

interface ManufactureOrderServiceInterface
{
    public function createMo(ManufactureOrder $manufactureOrder, User $user, array $partOutputData = []): ManufactureOrder;

    public function update(ManufactureOrder $manufactureOrder, User $user, array $partOutputData = []): ManufactureOrder;

    public function validateStatus(ManufactureOrder $manufactureOrder, int $status): void;

    public function deleteMo(ManufactureOrder $manufactureOrder);
}
