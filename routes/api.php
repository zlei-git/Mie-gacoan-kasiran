<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Models\Promo;
use App\Models\RestaurantTable;

/*
|--------------------------------------------------------------------------
| API Routes for Kedai Mie Anti-Ribet System
|--------------------------------------------------------------------------
*/

Route::get('/branches', [BranchController::class, 'index']);
Route::get('/branches/{id}', [BranchController::class, 'show']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{code}', [OrderController::class, 'show']);
Route::patch('/orders/{code}/status', [OrderController::class, 'updateStatus']);

Route::get('/promos', function () {
    return response()->json([
        'success' => true,
        'data' => Promo::where('is_active', true)->get(),
    ]);
});

Route::get('/tables', function () {
    return response()->json([
        'success' => true,
        'data' => RestaurantTable::all(),
    ]);
});
