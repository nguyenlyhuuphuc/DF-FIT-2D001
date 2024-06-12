<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductCategoryController;


Route::get('admin/product_category/create', [ProductCategoryController::class, 'create'])
->name('admin.product_category.create');

Route::post('admin/product_category/store', [ProductCategoryController::class, 'store'])
->name('admin.product_category.store');

Route::get('admin/product_category', [ProductCategoryController::class, 'index'])
->name('admin.product_category.index');

Route::post('admin/product_category/slug', [ProductCategoryController::class, 'makeSlug'])
->name('admin.product_category.slug');

Route::post('admin/product_category/destroy/{productCategory}', [ProductCategoryController::class, 'destroy'])
->name('admin.product_category.destroy');

Route::post('admin/product_category/restore/{id}', [ProductCategoryController::class, 'restore'])
->name('admin.product_category.restore');

Route::get('admin/product_category/detail/{productCategory}', [ProductCategoryController::class, 'detail'])
->name('admin.product_category.detail');

Route::post('admin/product_category/update/{productCategory}', [ProductCategoryController::class, 'update'])
->name('admin.product_category.update');
?>