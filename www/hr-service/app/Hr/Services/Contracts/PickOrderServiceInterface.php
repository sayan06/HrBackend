<?php

namespace App\Hr\Services\Contracts;

use App\Hr\DataTransferObjects\FilterableDto;
use App\Hr\DataTransferObjects\SortableDto;
use App\Hr\Models\ManufactureOrder;
use App\Hr\Models\PickOrder;
use App\Hr\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface PickOrderServiceInterface
{
    public function getMany(SortableDto $sortableDto, FilterableDto $filterableDto, int $pageLimit = 15): LengthAwarePaginator;

    public function getOne(PickOrder $pickOrder): PickOrder;

    public function create(User $user, array $pickOrderData): PickOrder;

    public function update(PickOrder $pickOrder, User $user, array $pickOrderData): PickOrder;

    public function delete(PickOrder $pickOrder);

    public function validateStatus(PickOrder $pickOrder, int $status): void;

    public function createProductionPickOrder(ManufactureOrder $manufactureOrder, array $pickOrderData, User $user): PickOrder;
}
