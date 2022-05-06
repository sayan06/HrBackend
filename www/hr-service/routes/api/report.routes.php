<?php

use App\Hr\Controllers\api\v1\ReportController;
use Illuminate\Support\Facades\Route;

Route::prefix('reports')->group(function () {
    Route::get('/repeat-customer', [ReportController::class, 'getRepeatCustomerReport'])
        ->middleware('permission:repeat_customer');

    Route::get('/repeat-order-rate', [ReportController::class, 'repeatOrderRateReport'])
        ->middleware('permission:repeat_order_rate');

    Route::get('/aged-inventory', [ReportController::class, 'agedInventoryReport'])
        ->middleware('permission:aged_Inventory');

    Route::get('/low-stock', [ReportController::class, 'lowStockReport'])
        ->middleware('permission:low_stock');

    Route::get('/product-performance', [ReportController::class, 'productPerformanceReport'])
        ->middleware('permission:product_performance');

    Route::get('/stock-details', [ReportController::class, 'variantDetailedReport'])
        ->middleware('permission:aged_Inventory');

    Route::get('/turnover', [ReportController::class, 'turnOverReport'])
        ->middleware('permission:turnover_report');
});
