<?php

use App\Hr\Controllers\api\v1\PickSheetController;
use Illuminate\Support\Facades\Route;

Route::prefix('pick-sheets')->group(function () {
    Route::get('/', [PickSheetController::class, 'index'])
        ->middleware('permission:list_pick_sheets');

    Route::get('/statuses', [PickSheetController::class, 'getStatuses'])
        ->middleware('permission:list_pick_sheet_statuses');

    Route::get('/items/statuses', [PickSheetController::class, 'getPickSheetItemStatuses'])
        ->middleware('permission:list_pick_sheet_item_statuses');

    Route::get('/{pickSheet}', [PickSheetController::class, 'get'])
        ->middleware('permission:list_pick_sheets');

    Route::post('/', [PickSheetController::class, 'create'])
        ->middleware('permission:create_pick_sheets');

    Route::put('/{pickSheet}', [PickSheetController::class, 'update'])
        ->middleware('permission:update_pick_sheets');
});
