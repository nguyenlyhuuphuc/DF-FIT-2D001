<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;

Route::prefix('admin/product_category')
->name('admin.product_category.')
->controller(ProductCategoryController::class)
->middleware('check.user.admin')
->group(function(){
    Route::get('create', 'create')->name('create');
    Route::post('store',  'store')->name('store');
    Route::get('/', 'index')->name('index');
    Route::post('slug',  'makeSlug')->name('slug');
    Route::post('destroy/{productCategory}', 'destroy')->name('destroy');
    Route::post('restore/{id}',  'restore')->name('restore');
    Route::get('detail/{productCategory}', 'detail')->name('detail');
    Route::post('update/{productCategory}','update')->name('update');
});

Route::name('admin')->resource('admin/product', ProductController::class);

Route::get('product/pepsi', function (){
    echo '<h1>pepsi</h1>';
})->middleware('check.user.login');

Route::get('product/hennessy', function (){
    echo '<h1>hennessy</h1>';
})->middleware('check.user.login.and.adult');

Route::get('product/lavie', function (){
    echo '<h1>lavie</h1>';
});
?>