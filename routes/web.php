<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('master', function (){
    return view('client.layout.master');
});

Route::get('home', function () {
    return view('client.pages.home');
});

Route::get('product-list', function () {
    return view('client.pages.product_list');
});

Route::get('product-detail', function () {
    return view('client.pages.product_detail');
});

Route::get('cart', function () {
    return view('client.pages.cart');
});

Route::get('checkout', function () {
    return view('client.pages.checkout');
});

Route::get('contact', function () {
    return view('client.pages.contact');
});

Route::get('master-admin', function (){
    return view('admin.layout.master');
});

Route::get('admin/product', function (){
    return view('admin.pages.product');
});

Route::get('admin/product-category', function (){
    return view('admin.pages.product_category');
});

Route::get('admin/product-create', function (){
    return view('admin.pages.product_create');
});


