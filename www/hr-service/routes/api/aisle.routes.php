<?php

use App\Hr\Controllers\api\v1\AisleController;
use Illuminate\Support\Facades\Route;

Route::prefix('aisles')->group(function () {
    Route::get('/', [AisleController::class, 'index'])
        ->middleware('permission:list_aisles');

    Route::get('/{aisle}', [AisleController::class, 'getAisle'])
        ->middleware('permission:list_aisles');

    Route::post('/', [AisleController::class, 'createAisle'])
        ->middleware('permission:create_aisles');

    Route::delete('/{aisle}', [AisleController::class, 'deleteAisle'])
        ->middleware('permission:delete_aisles');

    Route::put('/{aisle}', [AisleController::class, 'updateAisle'])
        ->middleware('permission:update_aisles');
});
