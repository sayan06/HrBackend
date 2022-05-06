<?php

use App\Hr\Controllers\api\v1\AddressController;
use Illuminate\Support\Facades\Route;

Route::prefix('addresses')->group(function () {
    Route::get('/', [AddressController::class, 'index'])
        ->middleware('permission:list_addresses');

    Route::get('/{address}', [AddressController::class, 'getAddressDetails'])
        ->middleware('permission:list_addresses');

    Route::post('/', [AddressController::class, 'createAddress'])
        ->middleware('permission:create_addresses');

    Route::delete('/{address}', [AddressController::class, 'deleteExistingAddress'])
        ->middleware('permission:delete_addresses');

    Route::put('/{address}', [AddressController::class, 'updateAddressDetails'])
        ->middleware('permission:update_addresses');
});
