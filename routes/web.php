<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Pembelian Restoran Laravel PHP Native
|--------------------------------------------------------------------------
*/

// --- Public & Customer Facing Routes ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/order/track/{code}', [OrderController::class, 'track'])->name('orders.track');
Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

// --- Manual Authentication Routes (No 1-Click bypass) ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Customer Order & Checkout Routes (Auth required) ---
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');
});

// --- Kasir / POS Routes (Role: kasir, admin) ---
Route::middleware(['auth', 'role:kasir,admin'])->group(function () {
    Route::get('/orders/live-feed', [PosController::class, 'liveOrderFeed'])->name('orders.live_feed');
});

Route::middleware(['auth', 'role:kasir,admin'])->prefix('pos')->name('pos.')->group(function () {
    Route::get('/', [PosController::class, 'index'])->name('index');
    Route::post('/orders', [PosController::class, 'store'])->name('store');
    Route::post('/sync', [PosController::class, 'sync'])->name('sync');
    Route::patch('/orders/{id}/status', [PosController::class, 'updateOrderStatus'])->name('orders.status');
});

// --- Admin Backoffice Routes (Role: admin) ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::patch('/products/{id}/toggle', [AdminController::class, 'toggleProductStatus'])->name('products.toggle');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::patch('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.status');
    Route::get('/tables', [AdminController::class, 'tables'])->name('tables');
    Route::patch('/tables/{id}/status', [AdminController::class, 'updateTableStatus'])->name('tables.status');
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::patch('/bookings/{id}/status', [AdminController::class, 'updateBookingStatus'])->name('bookings.status');
    Route::get('/promos', [AdminController::class, 'promos'])->name('promos');
    Route::post('/promos', [AdminController::class, 'storePromo'])->name('promos.store');
});
