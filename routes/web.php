<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/home');
});
Route::get('/home', function () {
    return view('page.home');
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');

Route::post('/cart/add/{id}', [CartController::class, 'store'])->name('cart.add');

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'store'])->name('cart.add');
    Route::get('/cart/update/{type}/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.delete');

    Route::post('/checkout', [CartController::class, 'showCheckout'])->name('checkout.show');
    Route::post('/checkout/process', [CartController::class, 'checkout'])->name('checkout.process');

    Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])->name('pembayaran.show');
    Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('pembayaran.store');
});

// Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
// Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
// Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

// Route::get('/alamat', [AlamatController::class, 'index'])->name('alamat.index');
// Route::get('/alamat/create', [AlamatController::class, 'create'])->name('alamat.create');
// Route::post('/alamat', [AlamatController::class, 'store'])->name('alamat.store');

// Route::get('/alamat/{id}/edit', [AlamatController::class, 'edit'])->name('alamat.edit');
// Route::put('/alamat/{id}', [AlamatController::class, 'update'])->name('alamat.update');

// Route::delete('/alamat/{id}', [AlamatController::class, 'destroy'])->name('alamat.destroy');

// Route::get('/pesanan', [StatusPesananController::class, 'index'])->name('pesanan.index');
// Route::get('/pesanan/{id}/konfirmasi', [StatusPesananController::class, 'konfirmasiPembayaran'])->name('pesanan.konfirmasi');
