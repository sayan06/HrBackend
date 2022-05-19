<?php

namespace App\Hr\Services\Contracts;

use App\Hr\Models\SalesOrder;
use App\Hr\Models\User;

interface SalesOrderServiceInterface
{
    public function create(User $user, array $soData): SalesOrder;
    public function update(SalesOrder $salesOrder, User $user, array $soData): SalesOrder;
    public function delete(SalesOrder $salesOrder);
    public function validateBusinessRules(SalesOrder $salesOrder, array $soData): void;
}
