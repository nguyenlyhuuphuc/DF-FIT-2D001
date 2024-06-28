<?php

use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\GoogleController;
use App\Http\Controllers\Client\HomeController;
use App\Mail\OrderEmailCustomer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('home', [HomeController::class, 'index'])->name('home');

Route::get('product-list', function () {
    return view('client.pages.product_list');
});

Route::get('product-detail', function () {
    return view('client.pages.product_detail');
});

Route::get('cart', [CartController::class, 'index'])->name('cart.index');

Route::get('checkout', [CartController::class, 'checkout'])->name('checkout.index')->middleware('auth');
Route::post('checkout/place-order', [CartController::class, 'placeOrder'])->name('checkout.place-order')->middleware('auth');

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

Route::get('test-send-mail', function(){
    $title = 'My Title';

    Mail::to('nguyenlyhuuphucwork@gmail.com')->send(new OrderEmailCustomer($title));
});

Route::get('vnpay-callback', [CartController::class, 'vnpayCallBack'])->name('vnpay.callback');

Route::get('google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
 
Route::get('google/callback', [GoogleController::class, 'callback'])->name('google.callback');

?>