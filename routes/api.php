<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| PRODUCT ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/products', [ProductController::class, 'getAll']);      // list semua produk
Route::post('/products', [ProductController::class, 'createProduct']);     // tambah produk
Route::get('/products/search', [ProductController::class, 'searchProducts']);
Route::get('/products/{id}', [ProductController::class, 'showProduct']);  // detail produk
Route::post('/products/{id}/update', [ProductController::class, 'updateProduct']); // update produk
Route::delete('/products/{id}', [ProductController::class, 'deleteProduct']); // hapus produk


/*
|--------------------------------------------------------------------------
| ORDER ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/orders', [OrderController::class, 'getAll']);      // list semua pesanan
Route::get('/orders/new_orders', [OrderController::class, 'getNewOrderCode']); // generate kode pesanan baru
Route::post('/orders', [OrderController::class, 'addOrders']);     // buat pesanan baru
Route::get('/orders/{id}', [OrderController::class, 'getByIdOrders']);  // detail pesanan (order + items)
Route::put('/orders/{id}', [OrderController::class, 'updateOrders']); // update pesanan
Route::delete('/orders/{id}', [OrderController::class, 'batalOrders']); // hapus pesanan

// cancel pesanan (custom route)
Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel']);


