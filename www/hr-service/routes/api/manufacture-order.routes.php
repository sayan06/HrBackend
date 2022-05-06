<?php

use App\Hr\Controllers\api\v1\ManufactureOrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('manufacture-orders')->group(function () {
    Route::get('/', [ManufactureOrderController::class, 'index'])
        ->middleware('permission:list_manufacture_orders');

    Route::post('/', [ManufactureOrderController::class, 'createMo'])
        ->middleware('permission:create_manufacture_order');

    Route::post('/{manufactureOrder}/pick-orders', [ManufactureOrderController::class, 'createPickOrder'])
        ->middleware('permission:create_manufacture_order');

    Route::get('/statuses', [ManufactureOrderController::class, 'getAllStatuses'])
        ->middleware('permission:list_manufacture_order_statuses');

    Route::get('/{manufactureOrder}', [ManufactureOrderController::class, 'getMo'])
        ->middleware('permission:list_manufacture_orders');

    Route::put('/{manufactureOrder}', [ManufactureOrderController::class, 'updateMo'])
        ->middleware('permission:update_manufacture_order');

    Route::delete('/{manufactureOrder}', [ManufactureOrderController::class, 'deleteMo'])
        ->middleware('permission:delete_manufacture_order');
});
