<?php

namespace App\Hr\Services\Contracts;

use App\Hr\Models\User;

interface StockingServiceInterface
{
    public function getStockableItems(string $orderType = null): array;

    public function create(User $user, array $stockableData);
}
