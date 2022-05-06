<?php

use App\Hr\Controllers\api\v1\CellController;
use Illuminate\Support\Facades\Route;

Route::prefix('cells')->group(function () {
    Route::get('/', [CellController::class, 'index'])
        ->middleware('permission:list_cells');

    Route::post('/', [CellController::class, 'createCell'])
        ->middleware('permission:create_cells');

    Route::get('/{cell}', [CellController::class, 'getCellDetails'])
        ->middleware('permission:list_cells');

    Route::put('/{cell}', [CellController::class, 'updateCell'])
        ->middleware('permission:update_cells');

    Route::delete('/{cell}', [CellController::class, 'deleteExistingCell'])
        ->middleware('permission:delete_cells');
});
