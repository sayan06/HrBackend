<?php

use App\Hr\Controllers\api\v1\UserPhotoController;
use Illuminate\Support\Facades\Route;

Route::prefix('user-photo')->group(function () {
    Route::post('/upload', [UserPhotoController::class, 'create'])
    ->middleware('permission:upload_media');

    Route::get('/{userPhoto}', [UserPhotoController::class, 'get'])
        ->middleware('permission:delete_media');

    Route::post('/{userPhoto}', [UserPhotoController::class, 'update'])
        ->middleware('permission:delete_media');

    Route::delete('/{userPhoto}', [UserPhotoController::class, 'delete'])
        ->middleware('permission:delete_media');
});
