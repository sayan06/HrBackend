<?php

use App\Hr\Controllers\api\v1\AuthController;
use App\Hr\Controllers\api\v1\PasswordResetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::post('/auth/users/login', [AuthController::class, 'login']);
    Route::post('/auth/users/register', [AuthController::class, 'register']);
    Route::post('/forgot-password', [PasswordResetController::class, 'sendPasswordResetMail']);
    Route::post('/password-reset', [PasswordResetController::class, 'resetPasswordByToken']);
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::group([], __DIR__ . '/api/auth.routes.php');
    Route::group([], __DIR__ . '/api/media.routes.php');
    Route::group([], __DIR__ . '/api/permission.routes.php');
    Route::group([], __DIR__ . '/api/role.routes.php');
    Route::group([], __DIR__ . '/api/user.routes.php');
});
