<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ExchangeRateController;

Route::get('purchases/report', [PurchaseController::class,'report']);

Route::apiResource('suppliers', SupplierController::class);
Route::apiResource('currencies', CurrencyController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('exchange-rates', ExchangeRateController::class);
Route::apiResource('purchases', PurchaseController::class);

