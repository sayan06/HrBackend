<?php

use App\Hr\Controllers\api\v1\ItemVariantController;
use Illuminate\Support\Facades\Route;

Route::prefix('variants')->group(function () {
    Route::get('/', [ItemVariantController::class, 'index'])
        ->middleware('permission:list_variants');

    Route::post('/', [ItemVariantController::class, 'createItemVariant'])
        ->middleware('permission:create_variants');

    Route::put('/{itemVariant}', [ItemVariantController::class, 'updateVariant'])
        ->middleware('permission:update_variants');

    Route::delete('/{itemVariant}', [ItemVariantController::class, 'deleteVariant'])
        ->middleware('permission:delete_variants');

    Route::get('/{itemVariant}', [ItemVariantController::class, 'getItemVariantDetails'])
        ->middleware('permission:list_variants');
});
