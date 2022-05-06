<?php

use App\Hr\Controllers\api\v1\PartyController;
use Illuminate\Support\Facades\Route;

Route::prefix('parties')->group(function () {
    Route::get('/', [PartyController::class, 'getAllParties'])
        ->middleware('permission:list_parties');

    Route::post('/', [PartyController::class, 'createParty'])
        ->middleware('permission:create_parties');

    Route::get('/{party}', [PartyController::class, 'getParty'])
        ->middleware('permission:list_parties');

    Route::put('/{party}', [PartyController::class, 'updateParty'])
        ->middleware('permission:update_parties');

    Route::delete('/{party}', [PartyController::class, 'deleteParty'])
        ->middleware('permission:delete_parties');

    Route::get('/{party}/items', [PartyController::class, 'getPartyItems'])
        ->middleware('permission:get_party_items');

    Route::post('/{party}/items', [PartyController::class, 'addPartyItems'])
        ->middleware('permission:add_party_items');

    Route::delete('/{party}/items', [PartyController::class, 'deletePartyItems'])
        ->middleware('permission:delete_party_items');

    Route::get('/businesses/{businessNature}', [PartyController::class, 'getByBusiness'])
        ->middleware('permission:list_parties_by_business');
});
