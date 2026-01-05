<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ReportController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    // Customers
    Route::apiResource('customers', CustomerController::class);
    Route::get('/customers/search', [CustomerController::class, 'search']);
    
    // Orders
    Route::apiResource('orders', OrderController::class);
    Route::get('/orders/search', [OrderController::class, 'search']);
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus']);
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index']);
    Route::get('/reports/statistics', [ReportController::class, 'statistics']);
});

