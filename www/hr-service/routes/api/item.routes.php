<?php

use App\Hr\Controllers\api\v1\ItemController;
use Illuminate\Support\Facades\Route;

Route::prefix('items')->group(function () {
    Route::get('/', [ItemController::class, 'index'])
        ->middleware('permission:list_items');

    Route::post('/', [ItemController::class, 'create'])
        ->middleware('permission:create_items');

    Route::get('/item-types', [ItemController::class, 'getTypes'])
        ->middleware('permission:list_item_types');

    Route::get('/{item}', [ItemController::class, 'get'])
        ->middleware('permission:list_items');

    Route::put('/{item}', [ItemController::class, 'update'])
        ->middleware('permission:update_items');

    Route::delete('/{item}', [ItemController::class, 'delete'])
        ->middleware('permission:delete_items');
});
