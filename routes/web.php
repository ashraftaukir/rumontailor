<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportsController;

Route::get('/', function () {
    return view('welcome');
});

// Redirect login route to admin.login (for auth middleware compatibility)
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Login routes (accessible without authentication)
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login');
    
    // Protected admin routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        
        // Customer routes
        Route::resource('customers', CustomerController::class);
        Route::get('/customers/{customer}/measurements', [CustomerController::class, 'getMeasurements'])->name('customers.measurements');
        
        // Order routes
        Route::resource('orders', OrderController::class);
        
        // Reports routes
        Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    });
});
