<?php

use App\Hr\Controllers\api\v1\CollectionController;
use Illuminate\Support\Facades\Route;

Route::prefix('collections')->group(function () {
    Route::get('/', [CollectionController::class, 'index'])
        ->middleware('permission:list_collections');

    Route::post('/', [CollectionController::class, 'createCollection'])
        ->middleware('permission:create_collections');

    Route::get('/{collection}', [CollectionController::class, 'getCollection'])
        ->middleware('permission:list_collections');

    Route::delete('/{collection}', [CollectionController::class, 'deleteCollection'])
        ->middleware('permission:delete_collections');

    Route::put('/{collection}/items', [CollectionController::class, 'updateCollectionItems'])
        ->middleware('permission:update_collection_items');

    Route::delete('/{collection}/items', [CollectionController::class, 'deleteCollectionItems'])
        ->middleware('permission:create_collection_items');
});
