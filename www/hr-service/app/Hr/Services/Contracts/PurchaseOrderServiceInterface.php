<?php

namespace App\Hr\Services\Contracts;

use App\Hr\DataTransferObjects\FilterableDto;
use App\Hr\DataTransferObjects\SortableDto;
use App\Hr\Models\PurchaseOrder;

interface PurchaseOrderServiceInterface
{
    public function getMany(SortableDto $sortableDto, FilterableDto $filterableDto, int $pageLimit);

    public function getPurchaseOrder(PurchaseOrder $purchaseOrder);

    public function create(array $poData): PurchaseOrder;

    public function update(PurchaseOrder $purchaseOrder, array $poData = []): PurchaseOrder;
}
