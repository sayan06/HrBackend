<?php

use App\Hr\Controllers\api\v1\PartyItemController;
use Illuminate\Support\Facades\Route;

Route::prefix('party-items')->group(function () {
    Route::put('/{partyItem}', [PartyItemController::class, 'updatePartyItem'])
        ->middleware('permission:update_party_items');
});

