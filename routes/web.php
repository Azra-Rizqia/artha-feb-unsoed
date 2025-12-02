<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\QnaController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ReportController;
// use App\Http\Controllers\MenuController; <-- Baris ini dihapus karena filenya sudah tidak ada

// 1. Redirect halaman utama ('/') langsung ke daftar menu
Route::get('/', function () {
    return redirect()->route('menu.index');
});
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
Route::get('/qna', [QnaController::class, 'index'])->name('qna.index');
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
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