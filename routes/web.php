<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\VisitorProductController::class, 'index'])->name('home');

Route::get('/products', [App\Http\Controllers\VisitorProductController::class, 'index'])->name('products.index');

// Auth routes
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Admin routes only
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
    Route::delete('/products/{product}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');
});
