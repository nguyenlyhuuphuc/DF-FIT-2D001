<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductCategoryController;


Route::get('admin/product_category/create', [ProductCategoryController::class, 'create']);
Route::post('admin/product_category/store', [ProductCategoryController::class, 'store']);

?>