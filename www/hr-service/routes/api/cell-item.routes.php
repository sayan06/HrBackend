<?php

use App\Hr\Controllers\api\v1\CellItemController;
use Illuminate\Support\Facades\Route;

Route::prefix('cell-items')->group(function () {
    Route::get('/', [CellItemController::class, 'index'])
        ->middleware('permission:list_cell_items');

    Route::post('/', [CellItemController::class, 'createCellItem'])
        ->middleware('permission:create_cell_items');

    Route::get('/{cellItem}', [CellItemController::class, 'getCellItemDetails'])
        ->middleware('permission:list_cell_items');

    Route::put('/{cellItem}', [CellItemController::class, 'updateCellItemDetails'])
        ->middleware('permission:update_cell_items');

    Route::delete('/{cellItem}', [CellItemController::class, 'deleteExistingCellItem'])
        ->middleware('permission:delete_cell_items');
});
