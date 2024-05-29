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

Route::get('test', function (){
    echo 'Test';
});

Route::get('test/a/b/c/d', function (){
    echo '<h1>d</h1>';
});

//product/detail/39/category/17
Route::get('product/detail/{id}/category/{categoryId?}', function ($id, $categoryId = 17){
    echo "Product Id : $id Category Id: $categoryId";
});

Route::get('name/{name}/yearBorn/{year?}', function ($name, $year = 0){
    $year = date('Y');
    return "Name : $name - YearBorn : $year";
});

Route::get('product/create', function () {
    return view('product.create');
});

Route::get('product/index', function (){
    return view('product.index');
});

Route::get('product/index/blade', function (){
    return view('product.scores');
});

Route::get('layout/index', function (){
    return view('layout.index');
});

Route::get('php', function (){
    return view('pages.php');
});

Route::get('js', function (){
    return view('pages.js');
});