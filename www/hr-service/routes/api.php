<?php

use App\Hr\Controllers\api\v1\AuthController;
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
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::group([], __DIR__ . '/api/address.routes.php');
    Route::group([], __DIR__ . '/api/aisle.routes.php');
    Route::group([], __DIR__ . '/api/auth.routes.php');
    Route::group([], __DIR__ . '/api/bom.routes.php');
    Route::group([], __DIR__ . '/api/manufacture-order.routes.php');
    Route::group([], __DIR__ . '/api/output-sheet.routes.php');
    Route::group([], __DIR__ . '/api/business.routes.php');
    Route::group([], __DIR__ . '/api/cell-item.routes.php');
    Route::group([], __DIR__ . '/api/cell.routes.php');
    Route::group([], __DIR__ . '/api/collection.routes.php');
    Route::group([], __DIR__ . '/api/invoice.routes.php');
    Route::group([], __DIR__ . '/api/item.routes.php');
    Route::group([], __DIR__ . '/api/label.routes.php');
    Route::group([], __DIR__ . '/api/media.routes.php');
    Route::group([], __DIR__ . '/api/party-item.routes.php');
    Route::group([], __DIR__ . '/api/party.routes.php');
    Route::group([], __DIR__ . '/api/permission.routes.php');
    Route::group([], __DIR__ . '/api/pick-order.routes.php');
    Route::group([], __DIR__ . '/api/pick-sheet.routes.php');
    Route::group([], __DIR__ . '/api/purchase-order.routes.php');
    Route::group([], __DIR__ . '/api/role.routes.php');
    Route::group([], __DIR__ . '/api/sales-order.routes.php');
    Route::group([], __DIR__ . '/api/stock.routes.php');
    Route::group([], __DIR__ . '/api/uom.routes.php');
    Route::group([], __DIR__ . '/api/user.routes.php');
    Route::group([], __DIR__ . '/api/variant.routes.php');
    Route::group([], __DIR__ . '/api/vendor.routes.php');
    Route::group([], __DIR__ . '/api/warehouse.routes.php');

    Route::group([], __DIR__ . '/api/report.routes.php');
});
