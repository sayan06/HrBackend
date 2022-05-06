<?php

use App\Hr\Controllers\api\v1\BomController;
use App\Hr\Controllers\api\v1\BomItemsController;
use Illuminate\Support\Facades\Route;

Route::prefix('bill-of-materials')->group(function () {
    Route::get('/', [BomController::class, 'index'])
        ->middleware('permission:list_boms');

    Route::get('/{bom}', [BomController::class, 'show'])
        ->middleware('permission:list_boms');

    Route::post('/', [BomController::class, 'create'])
        ->middleware('permission:create_boms');

    Route::put('/{bom}', [BomController::class, 'update'])
        ->middleware('permission:update_boms');

    Route::delete('/{bom}', [BomController::class, 'delete'])
        ->middleware('permission:delete_boms');

    Route::get('/{bom}/items', [BomItemsController::class, 'index'])
        ->middleware('permission:list_bom_items');

    Route::post('/{bom}/items', [BomItemsController::class, 'create'])
        ->middleware('permission:create_bom_items');

    Route::put('/items/{bomItem}', [BomItemsController::class, 'update'])
        ->middleware('permission:update_bom_items');

    Route::delete('/items/{bomItem}', [BomItemsController::class, 'delete'])
        ->middleware('permission:delete_bom_items');
});
