<?php

use App\Hr\Controllers\api\v1\AuthController;
use App\Hr\Controllers\api\v1\OnboardingController;
use App\Hr\Controllers\api\v1\PasswordResetController;
use App\Hr\Controllers\api\v1\UserInformationController;
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
    Route::post('/auth/users/request-otp', [AuthController::class, 'requestOtp']);
    Route::post('/auth/users/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/forgot-password', [PasswordResetController::class, 'sendPasswordResetMail']);
    Route::post('/password-reset', [PasswordResetController::class, 'resetPasswordByToken']);
    Route::post('/users/on-board', [UserInformationController::class, 'onBoardUserDetails']);
    Route::get('/users/body-style', [OnboardingController::class, 'indexBodyStyle']);
    Route::post('/users/degree', [OnboardingController::class, 'indexDegree']);
    Route::post('/users/astrological-sign', [OnboardingController::class, 'indexAstrologicalSign']);
    Route::post('/users/religion', [OnboardingController::class, 'indexReligion']);
    Route::post('/users/ethnicity', [OnboardingController::class, 'indexEthnicity']);
    Route::post('/users/marital-status', [OnboardingController::class, 'indexMaritalStatus']);
    Route::post('/users/consumption-type', [OnboardingController::class, 'indexConsumptionType']);
    Route::post('/users/eye-color', [OnboardingController::class, 'indexEyeColor']);
    Route::post('/users/hair-color', [OnboardingController::class, 'indexHairColor']);
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::group([], __DIR__ . '/api/auth.routes.php');
    Route::group([], __DIR__ . '/api/permission.routes.php');
    Route::group([], __DIR__ . '/api/role.routes.php');
    Route::group([], __DIR__ . '/api/user-media.routes.php');
    Route::group([], __DIR__ . '/api/user.routes.php');
});
