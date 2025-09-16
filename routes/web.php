<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CurrencyController as AdminCurrencyController;
use App\Http\Controllers\Admin\ExchangeRateController as AdminExchangeRateController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\PurchaseController as AdminPurchaseController;
use App\Http\Controllers\Admin\SupplierController as AdminSupplierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    // halaman tiap resource
    Route::get('/suppliers', [AdminSupplierController::class, 'index'])->name('admin.suppliers.index');
    Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/currencies', [AdminCurrencyController::class, 'index'])->name('admin.currencies.index');
    Route::get('/exchange-rates', [AdminExchangeRateController::class, 'index'])->name('admin.exchange_rates.index');
    Route::get('/purchases', [AdminPurchaseController::class, 'index'])->name('admin.purchases.index');
});

Route::get('purchases/report', [PurchaseController::class, 'report']);

require __DIR__ . '/auth.php';
