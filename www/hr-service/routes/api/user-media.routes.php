<?php

use App\Hr\Controllers\api\v1\UserMediaController;
use Illuminate\Support\Facades\Route;

Route::prefix('user-media')->group(function () {
    Route::post('/', [UserMediaController::class, 'create'])
    ->middleware('permission:create_media');

    Route::get('/{userMedia}', [UserMediaController::class, 'get'])
        ->middleware('permission:list_media');

    Route::post('/{userMedia}', [UserMediaController::class, 'update'])
        ->middleware('permission:update_media');

    Route::delete('/{userMedia}', [UserMediaController::class, 'delete'])
        ->middleware('permission:delete_media');
});
