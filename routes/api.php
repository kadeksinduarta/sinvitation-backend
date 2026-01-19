<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::post('/login', [AuthController::class, 'login']);

// Order Submission (Public)
Route::post('/orders/wedding', [OrderController::class, 'storeWedding']);
Route::post('/orders/birthday', [OrderController::class, 'storeBirthday']);
Route::post('/orders/metatah', [OrderController::class, 'storeMetatah']);

// Products (Public)
Route::get('/products', [ProductController::class, 'indexPublic']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Admin Orders
    Route::get('/admin/orders', [OrderController::class, 'index']);
    Route::patch('/admin/orders/{type}/{id}', [OrderController::class, 'updateStatus']);

    // Admin Products
    Route::get('/admin/products', [ProductController::class, 'index']);
    Route::post('/admin/products', [ProductController::class, 'store']);
    Route::put('/admin/products/{id}', [ProductController::class, 'update']);
    Route::delete('/admin/products/{id}', [ProductController::class, 'destroy']);
});
