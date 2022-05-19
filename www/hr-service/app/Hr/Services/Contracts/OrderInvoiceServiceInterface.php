<?php

namespace App\Hr\Services\Contracts;

use App\Hr\DataTransferObjects\FilterableDto;
use App\Hr\DataTransferObjects\SortableDto;
use App\Hr\Models\OrderInvoice;
use App\Hr\Models\User;

interface OrderInvoiceServiceInterface
{
    public function createInvoice(OrderInvoice $orderInvoice, array $partOrderData = []): OrderInvoice;

    public function updateInvoice(OrderInvoice $orderInvoice, array $data): OrderInvoice;

    public function deleteInvoices(OrderInvoice $orderInvoice);

    public function getOrderInvoice(OrderInvoice $orderInvoice): OrderInvoice;

    public function getMany(SortableDto $sortableDto, FilterableDto $filterableDto, int $pageLimit);
}
