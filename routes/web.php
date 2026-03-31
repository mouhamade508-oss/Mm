<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\VisitorProductController::class, 'index'])->name('home');

Route::get('/products', [App\Http\Controllers\VisitorProductController::class, 'index'])->name('products.index');
Route::get('/digital-products', [App\Http\Controllers\VisitorProductController::class, 'digitalProducts'])->name('products.digital');
Route::get('/games-and-apps', [App\Http\Controllers\VisitorProductController::class, 'gamesAndApps'])->name('games.apps');
Route::get('/games/{game}', [App\Http\Controllers\VisitorProductController::class, 'showGame'])->name('games.show');

// Sections routes
Route::get('/section/{section:slug}', [App\Http\Controllers\VisitorProductController::class, 'showSection'])->name('section.show');
Route::get('/section/{section:slug}/category/{category:slug}', [App\Http\Controllers\VisitorProductController::class, 'showSectionCategory'])->name('section.category.show');

// Auth routes
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Admin routes - protected
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', function() {
        return view('admin.dashboard');
    })->name('dashboard');

    // Sections routes
    Route::resource('sections', App\Http\Controllers\SectionController::class);

    // Categories routes
    Route::resource('categories', App\Http\Controllers\CategoryController::class);

    // Products routes
    Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');

    // Product Variants routes
    Route::get('/products/{product}/variants', [App\Http\Controllers\ProductController::class, 'variants'])->name('products.variants');
    Route::get('/products/{product}/variants/create', [App\Http\Controllers\ProductController::class, 'createVariant'])->name('products.variants.create');
    Route::post('/products/{product}/variants', [App\Http\Controllers\ProductController::class, 'storeVariant'])->name('products.variants.store');
    Route::get('/products/{product}/variants/{variant}/edit', [App\Http\Controllers\ProductController::class, 'editVariant'])->name('products.variants.edit');
    Route::put('/products/{product}/variants/{variant}', [App\Http\Controllers\ProductController::class, 'updateVariant'])->name('products.variants.update');
    Route::delete('/products/{product}/variants/{variant}', [App\Http\Controllers\ProductController::class, 'destroyVariant'])->name('products.variants.destroy');

    // Discounts routes
    Route::get('/discounts', [App\Http\Controllers\DiscountController::class, 'index'])->name('discounts.index');
    Route::get('/discounts/create', [App\Http\Controllers\DiscountController::class, 'create'])->name('discounts.create');
    Route::post('/discounts', [App\Http\Controllers\DiscountController::class, 'store'])->name('discounts.store');
    Route::get('/discounts/{discount}/edit', [App\Http\Controllers\DiscountController::class, 'edit'])->name('discounts.edit');
    Route::put('/discounts/{discount}', [App\Http\Controllers\DiscountController::class, 'update'])->name('discounts.update');
    Route::delete('/discounts/{discount}', [App\Http\Controllers\DiscountController::class, 'destroy'])->name('discounts.destroy');

    // Game Recharge Requests routes
    Route::get('/game-recharge-requests', [App\Http\Controllers\GameRechargeController::class, 'index'])->name('game-recharge.index');
    Route::get('/game-recharge-requests/{gameRequest}', [App\Http\Controllers\GameRechargeController::class, 'show'])->name('game-recharge.show');
    Route::put('/game-recharge-requests/{gameRequest}/status', [App\Http\Controllers\GameRechargeController::class, 'updateStatus'])->name('game-recharge.update-status');

    // Games routes
    Route::resource('games', App\Http\Controllers\Admin\GameController::class);

    // Game Categories routes
    Route::resource('game-categories', App\Http\Controllers\Admin\GameCategoryController::class);
});

// Public route for validating discount codes
Route::post('/api/game-recharge-requests', [App\Http\Controllers\GameRechargeController::class, 'store'])->name('api.game-recharge.store');
Route::post('/game-recharge', [App\Http\Controllers\GameRechargeController::class, 'store'])->name('game-recharge.store');
Route::post('/api/validate-discount', [App\Http\Controllers\DiscountController::class, 'validate'])->name('validate-discount');

// Public product details
Route::get('/product/{product}', [App\Http\Controllers\VisitorProductController::class, 'show'])->name('product.show');

// Sitemap
Route::get('/sitemap-dynamic.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

