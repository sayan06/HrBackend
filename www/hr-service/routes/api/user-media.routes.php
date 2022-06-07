<?php

use App\Hr\Controllers\api\v1\UserMediaController;
use Illuminate\Support\Facades\Route;

Route::prefix('user-media')->group(function () {
    Route::post('/upload', [UserMediaController::class, 'create'])
    ->middleware('permission:upload_media');

    Route::get('/{userMedia}', [UserMediaController::class, 'get'])
        ->middleware('permission:delete_media');

    Route::post('/{userMedia}', [UserMediaController::class, 'update'])
        ->middleware('permission:delete_media');

    Route::delete('/{userMedia}', [UserMediaController::class, 'delete'])
        ->middleware('permission:delete_media');
});
