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

Route::get('/order', 'App\Http\Controllers\API\V1\Order\OrderController@index')->name('orders.index');
Route::get('/stock', 'App\Http\Controllers\API\V1\Stock\StockController@index')->name('stocks.index');