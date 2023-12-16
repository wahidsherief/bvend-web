<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminVendorController;
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
use App\Http\Controllers\StoreController;
use App\Http\Controllers\VendorProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\DashboardController;

/** test routes -- start */

Route::get('mqtt/publish', [MqttController::class, 'publishTopic']);


// Route::get('/test', [HardwareController::class, 'order']);

/** test routes -- end */


/** Auth routes -- starts */


// auth - admin
Route::group(['prefix' => 'admin'], function ($router) {
    Route::post('/register', [AdminController::class, 'register']);
    Route::post('/login', [AdminController::class, 'login']);
});

Route::group(['middleware' => ['jwt.role:admin', 'jwt.auth'], 'prefix' => 'admin'], function ($router) {

    Route::get('/', [AdminController::class, 'profile']);
    Route::post('/logout', [AdminController::class, 'logout']);

    Route::get('/dashboard', [DashboardController::class, 'getAdminDashboard']);

    Route::prefix('product')->group(function () {
        Route::apiResource('/category', ProductCategoryController::class);
        Route::apiResource('/', ProductController::class)->parameters(['' => 'product']);
    });

    Route::prefix('vendor')->group(function () {
        Route::apiResource('/', AdminVendorController::class)->parameters(['' => 'vendor'])
            ->names([
                'index' => 'admin.vendor.index',
                'store' => 'admin.vendor.store',
                'show' => 'admin.vendor.show',
                'update' => 'admin.vendor.update',
                'destroy' => 'admin.vendor.destroy',
            ]);

    });


    Route::prefix('machine')->group(function () {
        Route::apiResource('/type', MachineTypeController::class);
        // Route::apiResource('/', MachineController::class)->parameters(['' => 'machine']);

        Route::get('/', [MachineController::class, 'getMachines']);
        Route::post('/', [MachineController::class, 'createMachine']);
        Route::put('/{id}', [MachineController::class, 'updateMachine']);
        Route::delete('/{id}', [MachineController::class, 'deleteMachine']);
    });


});


// auth - vendor
Route::group(['prefix' => 'vendor'], function ($router) {
    Route::post('/login', [VendorController::class, 'login']);
    Route::post('/register', [VendorController::class, 'register']);
});

Route::group(['middleware' => ['jwt.role:vendor', 'jwt.auth'], 'prefix' => 'vendor'], function ($router) {
    Route::post('/logout', [VendorController::class, 'logout']);
    Route::get('/', [VendorController::class, 'profile']);


    Route::get('/dashboard/{vendorId}/', [DashboardController::class, 'getVendorDashboard']);
    Route::get('/{vendorId}/machines', [MachineController::class, 'getVendorMachines']);
    Route::post('/refill', [MachineController::class, 'saveMachineRefill']);
    Route::put('/price', [MachineController::class, 'setMachineProductPrice']);
});


Route::post('bkash', [PaymentController::class, 'bkashWebhook']);
Route::get('/customer/machine/{id}', [CustomerController::class, 'getMachine']);
Route::post('/customer/payment', [CustomerController::class, 'cachePaymentResponse']);
Route::post('/customer/order', [CustomerController::class, 'dispatchOrderAndSaveData']);
