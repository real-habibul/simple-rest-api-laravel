<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('/v1')->group(function () {
    Route::prefix('/orders')->group(function () {
        $controller = 'App\Http\Controllers\API\V1\Order\OrderController';
        Route::get('/get-all', $controller . '@getAll');
    });

    // stock
    Route::prefix('/stocks')->group(function () {
        $controller = 'App\Http\Controllers\API\V1\Stock\StockController';
        Route::get('/get-all', $controller . '@getAll');
    });
});