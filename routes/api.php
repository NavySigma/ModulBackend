<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductCategoriesController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::apiResource('/products', ProductController::class);
    Route::apiResource('/product-categories', ProductCategoriesController::class);
    Route::delete('/auth/logout', [AuthController::class, 'logout']);
});

