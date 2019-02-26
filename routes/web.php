<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/','HomeController@index')->name('home');

Route::get('/category/{category_name}', 'CategoryController@search')->name('category.search');

Auth::routes();

Route::resources([
    'cart' => 'CartController',
    'categories' => 'CategoryController',
    'orders' => 'OrderController',
    'products' => 'ProductController',
]);