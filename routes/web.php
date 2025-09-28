<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockLogController;
use App\Http\Controllers\AdminDashboardController;

Route::get('/', function () {
    return view('welcome');
});

// User dashboard (default Laravel Breeze/Jetstream style)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Admin dashboard
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('admin.dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Resource routes
Route::middleware(['auth'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class)
        ->middleware('role:owner');
    Route::resource('products', ProductController::class);
    Route::resource('sales', SaleController::class);

    // Stock logs resource routes (URLs use hyphens, names use underscores)
    Route::resource('stock-logs', StockLogController::class)
        ->only(['index', 'create', 'store', 'destroy'])
        ->names([
            'index' => 'stock_logs.index',
            'create' => 'stock_logs.create',
            'store' => 'stock_logs.store',
            'destroy' => 'stock_logs.destroy',
        ]);

    // Stock logs export
    Route::get('stock-logs/export', [StockLogController::class, 'export'])
        ->name('stock_logs.export');

    // Add stock to product
    Route::post('/products/{product}/add-stock', [ProductController::class, 'addStock'])
        ->name('products.addStock');
        
    // Logout route (post)
    Route::post('/logout', function () {
        Auth::logout();  // Logs out the user
        return redirect('/');  // Redirect to homepage or login page
    })->name('logout');
});

require __DIR__ . '/auth.php';
