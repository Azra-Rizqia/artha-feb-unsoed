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
// 1. Halaman Pilih Menu
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');

// 2. Halaman Detail Pesanan (POST karena kirim data keranjang)
// Route::match agar mendukung GET (untuk refresh/back) dan POST
Route::match(['get', 'post'], '/orders/detail', [OrderController::class, 'detail'])->name('orders.detail');

// 3. Proses Simpan
Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');

Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

// 4. Halaman Riwayat
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
