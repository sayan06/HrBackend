<?php

use App\Hr\Controllers\api\v1\StockingController;
use Illuminate\Support\Facades\Route;

Route::prefix('stocks')->group(function () {
    Route::post('/', [StockingController::class, 'create'])
        ->middleware('permission:create_stocks');

    Route::get('/items', [StockingController::class, 'getStockableItems'])
        ->middleware('permission:list_stocks');
});
