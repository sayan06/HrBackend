<?php

use App\Hr\Controllers\api\v1\SalesOrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('sales-orders')->group(function () {
    Route::get('/', [SalesOrderController::class, 'index'])
        ->middleware('permission:list_sales_orders');

    Route::get('/statuses', [SalesOrderController::class, 'getStatuses'])
        ->middleware('permission:list_so_statuses');

    Route::get('/{salesOrder}', [SalesOrderController::class, 'get'])
        ->middleware('permission:list_sales_orders');

    Route::post('/', [SalesOrderController::class, 'create'])
        ->middleware('permission:create_sales_orders');

    Route::put('/{salesOrder}', [SalesOrderController::class, 'update'])
        ->middleware('permission:update_sales_orders');

    Route::delete('/{salesOrder}', [SalesOrderController::class, 'delete'])
        ->middleware('permission:delete_sales_orders');
});
