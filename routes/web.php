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
Route::post('/cart/update_many/','CartController@update_many')->name('cart.update_many');
Route::get('/cart/checkout/','CartController@checkout')->name('cart.checkout');

Route::get('/category/{category_name}', 'CategoryController@search')->name('category.search');

Route::get('/admin/product', 'ProductController@admin')->name('products.admin')->middleware('admin');

Route::get('/admin/order', 'OrderController@admin')->name('orders.admin')->middleware('admin');

Route::get('/checkout','CheckOutController@index')->name('checkout');

Auth::routes();

Route::resources([
    'cart' => 'CartController',
    'categories' => 'CategoryController',
    'orders' => 'OrderController',
    'products' => 'ProductController',
]);