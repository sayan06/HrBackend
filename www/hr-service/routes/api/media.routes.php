<?php

use App\Hr\Controllers\api\v1\MediaController;
use Illuminate\Support\Facades\Route;

Route::prefix('media')->group(function () {
    Route::delete('/{media}', [MediaController::class, 'deleteMedia'])
        ->middleware('permission:delete_media');

    Route::post('/upload', [MediaController::class, 'updateMediaItems'])
        ->middleware('permission:upload_medias');

    Route::post('/download', [MediaController::class, 'getMediaItems'])
        ->middleware('permission:download_medias');
});
