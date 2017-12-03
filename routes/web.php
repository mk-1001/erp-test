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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::resource('orders', 'OrdersController', ['only' => ['index', 'edit']]);
Route::resource('items', 'ItemsController', ['except' => ['show', 'destroy']]);
Route::resource('products', 'ProductsController', ['except' => ['show', 'destroy']]);
Route::delete('orders/{order}/items/{item}', [
    'uses' => 'OrdersController@removeItem',
    'as'   => 'orders.items.remove'
]);