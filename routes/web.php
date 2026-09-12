<?php

use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ShippingController;
use Illuminate\Support\Facades\Route;

// Redirect awal
Route::get('/', fn () => redirect()->route('books.index'));

// ==== AUTH ====
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

// ==== USER (butuh login) ====
Route::middleware('auth')->group(function () {
    // Buku: lihat + cari (bisa juga tanpa login, tapi di sini kita wajibkan login sesuai skenario toko)
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

    // Keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{book}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/{book}', [CartController::class, 'remove'])->name('cart.remove');

    // Order / checkout / struk / dashboard user
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::get('/orders', [OrderController::class, 'history'])->name('orders.history');
    Route::get('/orders/{order}/receipt', [OrderController::class, 'receipt'])->name('orders.receipt');

    // Pembayaran (upload bukti transfer)
    Route::get('/orders/{order}/payment', [PaymentController::class, 'show'])->name('orders.payment.show');
    Route::post('/orders/{order}/payment', [PaymentController::class, 'store'])->name('orders.payment.store');

    // Alamat & catatan pengiriman (diisi setelah bayar)
    Route::get('/orders/{order}/shipping', [ShippingController::class, 'show'])->name('orders.shipping.show');
    Route::post('/orders/{order}/shipping', [ShippingController::class, 'store'])->name('orders.shipping.store');
});

// ==== ADMIN ====
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('books', AdminBookController::class)->except(['show']);

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/verify-payment', [AdminOrderController::class, 'verifyPayment'])->name('orders.verifyPayment');
    Route::post('/orders/{order}/update-shipment', [AdminOrderController::class, 'updateShipment'])->name('orders.updateShipment');
});
