<?php

use App\Http\Controllers\Api\AlamatApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\PesananApiController;
use App\Http\Controllers\Api\ProdukController;
use App\Http\Controllers\Api\ProfileApiController;
use App\Http\Controllers\Api\ReviewApiController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/home', [HomeController::class, 'index']);
Route::get('/home/{id}', [HomeController::class, 'detail']);

Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/cart', [CartApiController::class, 'index']);
    Route::post('/cart/{id}', [CartApiController::class, 'store']);
    Route::put('/cart/{id}', [CartApiController::class, 'update']);
    Route::delete('/cart/{id}', [CartApiController::class, 'destroy']);

    Route::post('/show/checkout', [CheckoutController::class, 'showCheckout']);
    Route::post('/checkout/process', [CheckoutController::class, 'checkout']);
    Route::post('/payment', [CheckoutController::class, 'store']);

    Route::get('/review', [ReviewApiController::class, 'index']);
    Route::get('/review/{id}', [ReviewApiController::class, 'show']);
    Route::post('/review', [ReviewApiController::class, 'store']);
    Route::put('/review/{id}', [ReviewApiController::class, 'update']);
    Route::delete('/review/{id}', [ReviewApiController::class, 'destroy']);

    Route::get('/alamats', [AlamatApiController::class, 'index']);
    Route::post('/alamats', [AlamatApiController::class, 'store']);
    Route::get('/alamats/{id}', [AlamatApiController::class, 'show']);
    Route::put('/alamats/{id}', [AlamatApiController::class, 'update']);
    Route::delete('/alamats/{id}', [AlamatApiController::class, 'destroy']);

    Route::get('/profile', [ProfileApiController::class, 'index']);
    Route::put('/profile', [ProfileApiController::class, 'update']);

    Route::get('/pesanans', [PesananApiController::class, 'index']);
    Route::put('/pesanans/{id}', [PesananApiController::class, 'update']);
});


Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    // Baris ini mencakup semua fungsi CRUD untuk produk
    Route::apiResource('produks', ProdukController::class);
    Route::apiResource('tags', TagController::class);

    //untuk endpoint
    Route::post('/produk', [ProdukController::class, 'store']);
});
