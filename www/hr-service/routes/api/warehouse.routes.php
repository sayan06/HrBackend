<?php

use App\Hr\Controllers\api\v1\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::prefix('warehouses')->group(function () {
    Route::get('/', [WarehouseController::class, 'index'])
        ->middleware('permission:list_warehouses');

    Route::post('/', [WarehouseController::class, 'create'])
        ->middleware('permission:create_warehouses');

    Route::get('/{warehouse}', [WarehouseController::class, 'get'])
        ->middleware('permission:list_warehouses');

    Route::put('/{warehouse}', [WarehouseController::class, 'update'])
        ->middleware('permission:update_warehouses');

    Route::delete('/{warehouse}', [WarehouseController::class, 'delete'])
        ->middleware('permission:delete_warehouses');

    Route::get('/{warehouse}/users', [WarehouseController::class, 'getWarehouseUsers'])
        ->middleware('permission:list_warehouse_users');

    Route::post('/{warehouse}/users', [WarehouseController::class, 'addWarehouseUsers'])
        ->middleware('permission:add_warehouse_users');

    Route::delete('/{warehouse}/users', [WarehouseController::class, 'deleteWarehouseUsers'])
        ->middleware('permission:delete_warehouse_users');
});
