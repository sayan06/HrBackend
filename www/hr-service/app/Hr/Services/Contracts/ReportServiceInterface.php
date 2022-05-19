<?php

namespace App\Hr\Services\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ReportServiceInterface
{
    public function getAgedInventoryList(array $details = []) : LengthAwarePaginator;

    public function getRepeatOrderRate(array $details = []);

    public function getLowStockList(array $details = []) : LengthAwarePaginator;

    public function getProductPerformanceList(array $attributes = []) : LengthAwarePaginator;

    public function getRepeatCustomers(array $attributes = []): LengthAwarePaginator;

    public function getVariantTurnOverList(array $details = []): LengthAwarePaginator;

    public function getInventoryDetails(array $attributes = []): LengthAwarePaginator;

    public function getInventoryOnHandDetails(array $attributes = []): LengthAwarePaginator;
}
