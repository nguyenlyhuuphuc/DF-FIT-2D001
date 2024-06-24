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

Route::prefix('cart')
->controller(CartController::class)
->name('cart.')
->middleware('auth')
->group(function(){
    Route::post('add-product','add')->name('add.product');

    Route::get('delete-cart', 'destroy')->name('destroy');

    Route::get('delete-item-cart/{productId}', 'deleteItem')->name('delete.item');

    Route::get('add-product-to-cart/{productId}/{qty?}', 'addProductItem')->name('add.product.item');
});
?>