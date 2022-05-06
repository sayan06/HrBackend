<?php

use App\Hr\Controllers\api\v1\OrderInvoiceController;
use Illuminate\Support\Facades\Route;

Route::prefix('invoices')->group(function () {
    Route::get('/', [OrderInvoiceController::class, 'index'])
        ->middleware('permission:list_invoices');

    Route::post('/', [OrderInvoiceController::class, 'createOrderInvoice'])
        ->middleware('permission:create_invoices');

    Route::get('/statuses', [OrderInvoiceController::class, 'getAllInvoiceStatuses'])
        ->middleware('permission:list_invoice_statuses');

    Route::get('/{orderInvoice}', [OrderInvoiceController::class, 'getOrderInvoice'])
        ->middleware('permission:list_invoices');

    Route::delete('/{orderInvoice}', [OrderInvoiceController::class, 'deleteOrderInvoice'])
        ->middleware('permission:delete_invoices');

    Route::delete('/{orderInvoice}/purchase-orders/{purchaseOrder}', [OrderInvoiceController::class, 'deletePurchaseOrderItems'])
        ->middleware('permission:delete_purchase_order_items');

    Route::put('/{orderInvoice}', [OrderInvoiceController::class, 'updateOrderInvoice'])
        ->middleware('permission:update_invoices');
});
