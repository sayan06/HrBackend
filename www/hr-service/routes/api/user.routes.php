<?php

use App\Hr\Controllers\api\v1\UserController;
use App\Hr\Controllers\api\v1\UserInformationController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'getUsers'])
        ->middleware('permission:list_users');

    Route::get('/{user}', [UserController::class, 'getUser'])
        ->middleware('permission:list_users');

    Route::put('/{user}/change-password', [UserController::class, 'changePassword'])
        ->middleware('permission:change_user_password');

    Route::put('/{user}', [UserController::class, 'updateUser'])
        ->middleware('permission:update_user');

    Route::post('/likability', [UserInformationController::class, 'likeOrDisLikeUser']);
});
