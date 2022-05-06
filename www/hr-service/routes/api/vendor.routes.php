<?php

use App\Hr\Controllers\api\v1\VendorController;
use Illuminate\Support\Facades\Route;

Route::prefix('vendors')->group(function () {
    Route::get('/', [VendorController::class, 'index'])
        ->middleware('permission:list_vendors');

    Route::get('/{vendor}', [VendorController::class, 'getVendor'])
        ->middleware('permission:list_vendors');

    Route::get('/{vendor}/items', [VendorController::class, 'getVendorItems'])
        ->middleware('permission:list_vendor_items');
});
