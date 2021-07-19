<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', [\App\Http\Controllers\Api\UserController::class, 'index'])->middleware('auth:sanctum');


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('/category', CategoryController::class);
    Route::apiResource('/product', ProductController::class);
});
