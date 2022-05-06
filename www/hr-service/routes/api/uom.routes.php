<?php

use App\Hr\Controllers\api\v1\UomController;
use Illuminate\Support\Facades\Route;

Route::prefix('measurement-units')->group(function () {
    Route::get('/', [UomController::class, 'index'])
        ->middleware('permission:list_uom');

    Route::get('/{uom}', [UomController::class, 'show'])
        ->middleware('permission:list_uom');

    Route::post('/', [UomController::class, 'create'])
        ->middleware('permission:create_uom');

    Route::put('/{uom}', [UomController::class, 'update'])
        ->middleware('permission:update_uom');

    Route::delete('/{uom}', [UomController::class, 'delete'])
        ->middleware('permission:delete_uom');
});
