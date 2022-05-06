<?php

use App\Hr\Controllers\api\v1\PurchaseOrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('purchase-orders')->group(function () {
    Route::get('/', [PurchaseOrderController::class, 'index'])
        ->middleware('permission:list_purchase_orders');

    Route::post('/', [PurchaseOrderController::class, 'create'])
        ->middleware('permission:create_purchase_orders');

    Route::get('/statuses', [PurchaseOrderController::class, 'getStatuses'])
        ->middleware('permission:list_purchase_order_statuses');

    Route::get('/{purchaseOrder}', [PurchaseOrderController::class, 'get'])
        ->middleware('permission:list_purchase_orders');

    Route::put('/{purchaseOrder}', [PurchaseOrderController::class, 'update'])
        ->middleware('permission:update_purchase_orders');

    Route::delete('/statuses/{poStatus}', [PurchaseOrderController::class, 'deletePoStatus'])
        ->middleware('permission:delete_purchase_order_statuses');
});
