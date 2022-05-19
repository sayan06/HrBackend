<?php

namespace App\Hr\Services\Contracts;

use App\Hr\Models\Warehouse;

interface WarehouseServiceInterface
{
    public function delete(Warehouse $warehouse): Warehouse;

    public function addWarehouseUsers(Warehouse $warehouse, array $userIds): Warehouse;

    public function deleteWarehouseUsers(Warehouse $warehouse, array $userIds): Warehouse;
}
