<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public Routes (No Auth Required)
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/categories', [ProductController::class, 'categories']);
Route::get('/categories/{id}', [ProductController::class, 'categoryShow']);

// Cart Routes (Session-based for guests)
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/add', [CartController::class, 'add']);
Route::put('/cart/update', [CartController::class, 'update']);
Route::delete('/cart/remove', [CartController::class, 'remove']);
Route::delete('/cart/clear', [CartController::class, 'clear']);

// Orders Routes (Guest checkout)
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::get('/orders/track', [OrderController::class, 'track']);

// Admin Authentication Routes
Route::post('/admin/login', [AdminAuthController::class, 'login']);

// Admin Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/admin/logout', [AdminAuthController::class, 'logout']);
    Route::get('/admin/me', [AdminAuthController::class, 'me']);
    
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    
    // Admin Orders
    Route::get('/admin/orders', [AdminController::class, 'orders']);
    Route::get('/admin/orders/{id}', [AdminController::class, 'orderShow']);
    Route::put('/admin/orders/{id}/status', [AdminController::class, 'orderUpdateStatus']);
    
    // Admin Products
    Route::get('/admin/products', [AdminController::class, 'products']);
    Route::post('/admin/products', [AdminController::class, 'productStore']);
    Route::put('/admin/products/{id}', [AdminController::class, 'productUpdate']);
    Route::delete('/admin/products/{id}', [AdminController::class, 'productDestroy']);
    
    // Admin Categories
    Route::get('/admin/categories', [AdminController::class, 'categories']);
    Route::post('/admin/categories', [AdminController::class, 'categoryStore']);
    Route::put('/admin/categories/{id}', [AdminController::class, 'categoryUpdate']);
    Route::delete('/admin/categories/{id}', [AdminController::class, 'categoryDestroy']);
});
