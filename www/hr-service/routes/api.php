<?php

use App\Hr\Controllers\api\v1\AuthController;
use App\Hr\Controllers\api\v1\OnboardingController;
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
    Route::post('/auth/users/request-otp', [AuthController::class, 'requestOtp']);
    Route::post('/auth/users/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/forgot-password', [PasswordResetController::class, 'sendPasswordResetMail']);
    Route::post('/password-reset', [PasswordResetController::class, 'resetPasswordByToken']);
    Route::get('/users/body-styles', [OnboardingController::class, 'indexBodyStyle']);
    Route::get('/users/degrees', [OnboardingController::class, 'indexDegree']);
    Route::get('/users/astrological-signs', [OnboardingController::class, 'indexAstrologicalSign']);
    Route::get('/users/religions', [OnboardingController::class, 'indexReligion']);
    Route::get('/users/ethnicities', [OnboardingController::class, 'indexEthnicity']);
    Route::get('/users/marital-statuses', [OnboardingController::class, 'indexMaritalStatus']);
    Route::get('/users/consumption-types', [OnboardingController::class, 'indexConsumptionType']);
    Route::get('/users/eye-colors', [OnboardingController::class, 'indexEyeColor']);
    Route::get('/users/hair-colors', [OnboardingController::class, 'indexHairColor']);
    Route::get('/users/questions', [OnboardingController::class, 'indexQuestions']);
    Route::get('/users/flavours', [OnboardingController::class, 'indexFlavours']);
    Route::get('/users/interests', [OnboardingController::class, 'indexInterests']);
    Route::get('/users/languages', [OnboardingController::class, 'indexLanguages']);
    Route::get('/users/ideal-matches', [OnboardingController::class, 'indexIdealMatches']);
    Route::get('/users/kids-requirement', [OnboardingController::class, 'indexKidsRequirementTypes']);
    Route::get('/users/personalities', [OnboardingController::class, 'indexPersonalities']);
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::group([], __DIR__ . '/api/auth.routes.php');
    Route::group([], __DIR__ . '/api/permission.routes.php');
    Route::group([], __DIR__ . '/api/role.routes.php');
    Route::group([], __DIR__ . '/api/user-media.routes.php');
    Route::group([], __DIR__ . '/api/user-post.routes.php');
    Route::group([], __DIR__ . '/api/user.routes.php');
});
