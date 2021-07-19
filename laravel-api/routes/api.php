<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('users', UserController::class)->only(['index']);
    Route::apiResource('/category', CategoryController::class);
    Route::apiResource('/product', ProductController::class);
});

Route::get('/category', [CategoryController::class, 'index']);
Route::get('/product', [ProductController::class, 'index']);
