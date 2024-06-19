<?php

use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('home', [HomeController::class, 'index'])->name('home');

Route::get('product-list', function () {
    return view('client.pages.product_list');
});

Route::get('product-detail', function () {
    return view('client.pages.product_detail');
});

Route::get('cart', [CartController::class, 'index'])->name('cart.index');

Route::get('checkout', function () {
    return view('client.pages.checkout');
});

Route::get('contact', function () {
    return view('client.pages.contact');
});

Route::post('cart/add-product', [CartController::class, 'add'])->name('cart.add.product');

Route::get('cart/delete-cart', [CartController::class, 'destroy'])->name('cart.destroy');
?>