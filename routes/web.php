<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlamatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StatusPesananController;
use App\Http\Controllers\TagController;
use App\Models\Pengembalian;
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
    // audri
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'store'])->name('cart.add');
    Route::get('/cart/update/{type}/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.delete');

    Route::post('/checkout', [CartController::class, 'showCheckout'])->name('checkout.show');
    Route::post('/checkout/process', [CartController::class, 'checkout'])->name('checkout.process');

    Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])->name('pembayaran.show');
    Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('pembayaran.store');


    // alul
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/alamat', [AlamatController::class, 'index'])->name('alamat.index');
    Route::get('/alamat/create', [AlamatController::class, 'create'])->name('alamat.create');
    Route::post('/alamat', [AlamatController::class, 'store'])->name('alamat.store');

    Route::get('/alamat/{id}/edit', [AlamatController::class, 'edit'])->name('alamat.edit');
    Route::put('/alamat/{id}', [AlamatController::class, 'update'])->name('alamat.update');

    Route::delete('/alamat/{id}', [AlamatController::class, 'destroy'])->name('alamat.destroy');

    Route::get('/pesanan', [StatusPesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}/konfirmasi', [StatusPesananController::class, 'konfirmasiPembayaran'])->name('pesanan.konfirmasi');

    //me
    Route::get('/review/{id}', [ReviewController::class, 'show'])->name('review.show');
    Route::post('/review/{id}', [ReviewController::class, 'store'])->name('review.store');

    Route::get('/pengembalian/{id}', [PengembalianController::class, 'show'])->name('pengembalian.show');
    Route::post('/pengembalian', [PengembalianController::class, 'store'])->name('pengembalian.store');
});

Route::middleware(['auth:admin'])->group(function () {

    // A. Kelola Produk (CRUD)
    Route::get('/admin/produk', [AdminController::class, 'produkIndex'])->name('admin.produk.index');
    Route::get('/admin/produk/create', [AdminController::class, 'produkCreate'])->name('admin.produk.create');
    Route::post('/admin/produk', [AdminController::class, 'produkStore'])->name('admin.produk.store');

    // BARIS UNTUK EDIT DAN UPDATE PRODUK
    Route::get('/admin/produk/{produk}/edit', [AdminController::class, 'produkEdit'])->name('admin.produk.edit');
    Route::put('/admin/produk/{produk}', [AdminController::class, 'produkUpdate'])->name('admin.produk.update');

    Route::delete('/admin/produk/{produk}', [AdminController::class, 'produkDestroy'])->name('admin.produk.destroy');

    // B. Kelola Tag/Kategori (CRUD)
    Route::get('/admin/tag', [TagController::class, 'indexAdmin'])->name('admin.tag.index');         // [READ] Daftar Tag
    Route::get('/admin/tag/create', [TagController::class, 'createAdmin'])->name('admin.tag.create'); // <--- [CREATE] Form Tambah Tag (GET)
    Route::post('/admin/tag', [TagController::class, 'storeAdmin'])->name('admin.tag.store');        // <--- [STORE] Simpan Tag Baru (POST)
    Route::get('/admin/tag/{tag}/edit', [TagController::class, 'editAdmin'])->name('admin.tag.edit'); // [EDIT] Form Edit (GET)
    Route::put('/admin/tag/{tag}', [TagController::class, 'updateAdmin'])->name('admin.tag.update');  // [UPDATE] Simpan Perubahan (PUT)
    Route::delete('/admin/tag/{tag}', [TagController::class, 'destroyAdmin'])->name('admin.tag.destroy'); // [DELETE] Hapus Tag

    // C. Kelola Pesanan
    Route::get('/admin/pesanan', [AdminController::class, 'pesananIndex'])->name('admin.pesanan.index');
    Route::post('/admin/pesanan/update-status/{id}', [AdminController::class, 'updateStatusPesanan'])->name('admin.pesanan.updateStatus');
});
