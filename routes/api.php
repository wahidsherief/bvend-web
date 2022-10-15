<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\ProductCategoryController;

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



Route::prefix('product')->group(function () {
    Route::apiResource('/', ProductController::class);
    Route::apiResource('category', ProductCategoryController::class);
});



// Route::put('product/{id}', [ProductController::class, 'update']);
// Route::delete('product/{id}', [ProductController::class, 'destroy']);
