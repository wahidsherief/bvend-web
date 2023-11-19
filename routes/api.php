<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\MachineTypeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VendorMachineController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MqttController;

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

/** test routes -- start */

Route::get('mqtt/publish', [MqttController::class, 'publishTopic']);

/** test routes -- end */

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


/** Auth routes -- starts */

// auth - user
Route::group(['prefix' => 'user'], function ($router) {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
});

Route::group(['middleware' => ['jwt.role:user', 'jwt.auth'], 'prefix' => 'user'], function ($router) {
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/', [UserController::class, 'profile']);
});

// Route::prefix('product')->group(function () {
//     Route::apiResource('/category', ProductCategoryController::class);
//     Route::apiResource('/', ProductController::class)->parameters(['' => 'product']);
// });


// auth - admin
Route::group(['prefix' => 'admin'], function ($router) {
    Route::post('/register', [AdminController::class, 'register']);
    Route::post('/login', [AdminController::class, 'login']);
});

Route::group(['middleware' => ['jwt.role:admin', 'jwt.auth'], 'prefix' => 'admin'], function ($router) {
    Route::get('/', [AdminController::class, 'profile']);
    Route::post('/logout', [AdminController::class, 'logout']);

    Route::prefix('product')->group(function () {
        Route::apiResource('/category', ProductCategoryController::class);
        Route::apiResource('/', ProductController::class)->parameters(['' => 'product']);
    });

    Route::prefix('vendor')->group(function () {
        Route::apiResource('/', VendorController::class)->parameters(['' => 'vendor']);
    });


    Route::prefix('machine')->group(function () {
        Route::apiResource('/type', MachineTypeController::class);
        Route::apiResource('/', MachineController::class)->parameters(['' => 'machine']);
    });

    Route::apiResource('transaction/', TransactionController::class);

});

// auth - staff
// Route::group(['prefix' => 'staff'], function ($router) {
//     Route::post('/login', [StaffController::class, 'login']);
//     Route::post('/register', [StaffController::class, 'register']);
// });

// Route::group(['middleware' => ['jwt.role:staff', 'jwt.auth'], 'prefix' => 'staff'], function ($router) {
//     Route::post('/logout', [StaffController::class, 'logout']);
//     Route::get('/', [StaffController::class, 'profile']);

// });

// auth - vendor
Route::group(['prefix' => 'vendor'], function ($router) {
    Route::post('/login', [VendorController::class, 'login']);
    Route::post('/register', [VendorController::class, 'register']);
});

Route::group(['middleware' => ['jwt.role:vendor', 'jwt.auth'], 'prefix' => 'vendor'], function ($router) {
    Route::post('/logout', [VendorController::class, 'logout']);
    Route::get('/', [VendorController::class, 'profile']);

});

/** Auth routes -- ends */

Route::get('vendor/machines/{id}', [VendorMachineController::class, 'index']);
Route::get('vendor/machine/refill/{id}', [VendorMachineController::class, 'getRefills']);
Route::post('vendor/machine/refill/', [VendorMachineController::class, 'storeRefill']);

Route::post('bkash', [PaymentController::class, 'bkashWebhook']);
