<?php

use App\Hr\Controllers\api\v1\UserPostController;
use Illuminate\Support\Facades\Route;

Route::prefix('user-posts')->group(function () {
    Route::post('/', [UserPostController::class, 'create'])->middleware('permission:create_post');
    Route::post('/{userPost}', [UserPostController::class, 'update'])->middleware('permission:update_post');
    Route::get('/{userPost}', [UserPostController::class, 'get'])->middleware('permission:list_post');
    Route::delete('/{userPost}', [UserPostController::class, 'delete'])->middleware('permission:delete_post');
});
