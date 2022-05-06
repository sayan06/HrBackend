<?php

use App\Hr\Controllers\api\v1\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/users/logout', [AuthController::class, 'logout']);

    Route::post('/tokens/refresh', [AuthController::class, 'refreshToken'])
        ->middleware('permission:create_tokens');
});
