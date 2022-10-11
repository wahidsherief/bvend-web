<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductCategoryController;

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



Route::get('/product/categories', [ProductCategoryController::class, 'index']);
Route::post('/product/category/create', [ProductCategoryController::class, 'store']);
Route::put('/product/category/update/{id}', [ProductCategoryController::class, 'update']);
Route::delete('/product/category/delete/{id}', [ProductCategoryController::class, 'delete']);
