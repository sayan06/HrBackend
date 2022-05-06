<?php

use App\Hr\Controllers\api\v1\LabelController;
use Illuminate\Support\Facades\Route;

Route::prefix('labels')->group(function () {
    Route::get('/', [LabelController::class, 'index'])
    ->middleware('permission:list_labels');

    Route::post('/scan', [LabelController::class, 'readLabel'])
    ->middleware('permission:scan_label');

    Route::post('/output', [LabelController::class, 'outputLabel'])
    ->middleware('permission:print_label');

    Route::post('/{label}', [LabelController::class, 'assignLabelToEntity'])
    ->middleware('permission:assign_label');

    Route::post('/', [LabelController::class, 'createLabel'])
    ->middleware('permission:generate_label');

    Route::delete('/{label}', [LabelController::class, 'deleteLabel'])
    ->middleware('permission:delete_label');
});
