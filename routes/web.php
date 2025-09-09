<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;

Route::get('/', function () {
    return redirect()->route('home');
})->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/partial/{page}', [HomeController::class, 'loadPartial']);
    Route::get('/filter-products', [HomeController::class, 'filterProducts']);
    Route::post('/products/search-by-barcode', [ProductController::class, 'searchByBarcode'])->name('products.searchByBarcode');
    Route::get('/products/get/{id}', [ProductController::class, 'getProduct']);
    Route::get('/search-customer', [CustomerController::class, 'search'])->name('customers.search');
    Route::post('/transactions/save', [HomeController::class, 'saveTransaction'])->name('transactions.save');
});
