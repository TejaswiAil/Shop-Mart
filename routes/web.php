<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('products', [\App\Http\Controllers\ProductsController::class, 'index'])->name('products.index');;
    Route::get('products/{product}', [\App\Http\Controllers\ProductsController::class, 'show'])->name('products.show');
    Route::post('basket', [\App\Http\Controllers\BasketsController::class, 'store']);
    Route::get('checkout', \App\Http\Controllers\CheckoutController::class);
    Route::post('orders', [\App\Http\Controllers\OrderController::class, 'store'])->name('order.store');
});

