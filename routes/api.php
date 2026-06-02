<?php

use App\Http\Controllers\ProductCategoriesController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/products', ProductController::class);
Route::apiResource('/product-categories', ProductCategoriesController::class);
