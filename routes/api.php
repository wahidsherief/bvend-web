<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\ProductCategoryController;
use App\Http\Controllers\api\VendorController;
use App\Http\Controllers\api\MachineController;
use App\Http\Controllers\api\TransactionController;
use App\Http\Controllers\api\VendorMachineController;
use App\Http\Controllers\api\PaymentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('vendor/machines/{id}', [VendorMachineController::class, 'index']);
Route::get('vendor/machine/refill/{id}', [VendorMachineController::class, 'getRefills']);
Route::post('vendor/machine/refill/', [VendorMachineController::class, 'storeRefill']);

Route::post('bkash', [PaymentController::class, 'bkashWebhook']);

Route::prefix('product')->group(function () {
    Route::apiResource('category', ProductCategoryController::class);
    // this route should put at the bottom of other routes
    Route::apiResource('/', ProductController::class)->parameters(['' => 'product']);
});

Route::prefix('vendor')->group(function () {
    // this route should put at the bottom of other routes
    Route::apiResource('/', VendorController::class)->parameters(['' => 'vendor']);
});


Route::prefix('machine')->group(function () {
    // this route should put at the bottom of other routes
    Route::apiResource('/', MachineController::class)->parameters(['' => 'machine']);
    // Route::post('/assign', [MachineController::class, 'assign']);
});

Route::apiResource('transaction/', TransactionController::class);
