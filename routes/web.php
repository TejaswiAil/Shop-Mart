<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('products', [\App\Http\Controllers\ProductController::class, 'index']);
    Route::get('products/{product}', [\App\Http\Controllers\ProductController::class, 'show']);
});

Route::post('filter-products', [\App\Http\Controllers\ProductController::class, 'filter'])->name('products.filter');
Route::post('/basket/add/{product}', [\App\Http\Controllers\BasketController::class, 'add'])->name('basket.add');
