<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductCategoryController;


Route::get('admin/product_category/createa', [ProductCategoryController::class, 'create'])
->name('admin.product_category.create');

Route::post('admin/product_category/store', [ProductCategoryController::class, 'store'])
->name('admin.product_category.store');

Route::get('admin/product_category', [ProductCategoryController::class, 'index'])
->name('admin.product_category.index');

?>