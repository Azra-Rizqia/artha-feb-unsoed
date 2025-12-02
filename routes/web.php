<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MenuController;

Route::get('/menu', function () {
    return redirect()->route('menu.index');
});
Route::get('/menu', ProductController::class, 'searchProducts');
Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);
Route::resource('menu', MenuController::class);

