<?php

use App\Hr\Controllers\api\v1\ManufactureOutputController;
use Illuminate\Support\Facades\Route;

Route::prefix('output-sheets')->group(function () {
    Route::get('/statuses', [ManufactureOutputController::class, 'getStatuses'])
        ->middleware('permission:list_output_sheet_statuses');

    Route::get('/', [ManufactureOutputController::class, 'index'])
        ->middleware('permission:list_output_sheets');

    Route::post('/', [ManufactureOutputController::class, 'createOne'])
        ->middleware('permission:create_output_sheet');

    Route::get('/{manufacturingOutputSheet}', [ManufactureOutputController::class, 'show'])
        ->middleware('permission:list_output_sheets');

    Route::put('/{manufacturingOutputSheet}', [ManufactureOutputController::class, 'updateOne'])
        ->middleware('permission:update_output_sheet');

    Route::delete('/{manufacturingOutputSheet}', [ManufactureOutputController::class, 'deleteOutputSheet'])
        ->middleware('permission:delete_output_sheet');

    Route::delete('/{outputSheet}/manufacture-orders/{manufactureOrder}', [ManufactureOutputController::class, 'deleteManufactureOrderParts'])
        ->middleware('permission:delete_manufacture_order_parts');
});
