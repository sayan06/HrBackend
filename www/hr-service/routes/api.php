<?php

use App\Hr\Controllers\api\v1\BucketFillingController;
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
    Route::get('/balls', [BucketFillingController::class, 'indexBalls']);
    Route::get('/buckets', [BucketFillingController::class, 'indexBuckets']);
    Route::post('/fill-buckets', [BucketFillingController::class, 'bucketSelection']);
});
