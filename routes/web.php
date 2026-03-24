<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
