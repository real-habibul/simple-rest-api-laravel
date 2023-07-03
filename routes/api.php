<?php

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

    // Master Data
    Route::prefix('/master-data')->group(function () {

        // Produk
        Route::prefix('/produk')->group(function () {
            Route::apiResource('/', 'App\Http\Controllers\API\V1\MasterData\ProdukController')
                ->only(['index', 'store', 'show', 'update'])
                ->parameters(['' => 'produk']);
        });

        // Produk Stok
        Route::prefix('/produk-stok')->group(function () {
            Route::apiResource('/', 'App\Http\Controllers\API\V1\MasterData\ProdukStokController')
                ->only(['index', 'store', 'show', 'update'])
                ->parameters(['' => 'produk_stok']);

            Route::post('/add-stok', 'App\Http\Controllers\API\V1\MasterData\ProdukStokController@addStok');
        });

        // User
        Route::prefix('/user')->group(function () {
            Route::apiResource('/', 'App\Http\Controllers\API\V1\MasterData\UserController')
                ->only(['index', 'store', 'show', 'update'])
                ->parameters(['' => 'user']);
        });
    });
});
