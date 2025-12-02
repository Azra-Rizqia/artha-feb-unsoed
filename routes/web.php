<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
// use App\Http\Controllers\MenuController; <-- Baris ini dihapus karena filenya sudah tidak ada

// 1. Redirect halaman utama ('/') langsung ke daftar menu
Route::get('/', function () {
    return redirect()->route('menu.index');
});

// 2. Resource Controller untuk Menu (menggunakan ProductController)
// Ini otomatis membuat semua route: index, create, store, edit, update, destroy
// URL: http://127.0.0.1:8000/menu
Route::resource('menu', ProductController::class);

// 3. Routes Manual untuk Orders (Pemesanan)
// URL: http://127.0.0.1:8000/orders
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
// Tambahkan baris ini di bawah route orders lainnya
Route::post('/orders/confirmation', [OrderController::class, 'confirmation'])->name('orders.confirmation');

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
