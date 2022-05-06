<?php

use App\Hr\Controllers\api\v1\PickOrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('pick-orders')->group(function () {
    Route::get('/', [PickOrderController::class, 'index'])
        ->middleware('permission:list_pick_orders');

    Route::get('/statuses', [PickOrderController::class, 'getStatuses'])
        ->middleware('permission:list_pick_order_statuses');

    Route::get('/{pickOrder}', [PickOrderController::class, 'get'])
        ->middleware('permission:list_pick_orders');

    Route::post('/', [PickOrderController::class, 'create'])
        ->middleware('permission:create_pick_orders');

    Route::put('/{pickOrder}', [PickOrderController::class, 'update'])
        ->middleware('permission:update_pick_orders');

    Route::delete('/{pickOrder}', [PickOrderController::class, 'delete'])
        ->middleware('permission:delete_pick_orders');
});
