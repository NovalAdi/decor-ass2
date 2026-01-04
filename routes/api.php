<?php

use App\Http\Controllers\api\AuthApiController;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ReviewApiController;
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

    Route::post('/checkout', [CartApiController::class, 'checkout']);

    Route::get('/review', [ReviewApiController::class, 'index']);
    Route::get('/review/{id}', [ReviewApiController::class, 'show']);
    Route::post('/review', [ReviewApiController::class, 'store']);
    Route::put('/review/{id}', [ReviewApiController::class, 'update']);
    Route::delete('/review/{id}', [ReviewApiController::class, 'destroy']);
});


Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/review', [ReviewApiController::class, 'index']);
    Route::get('/review/{id}', [ReviewApiController::class, 'show']);
    Route::post('/review', [ReviewApiController::class, 'store']);
    Route::put('/review/{id}', [ReviewApiController::class, 'update']);
    Route::delete('/review/{id}', [ReviewApiController::class, 'destroy']);
});
