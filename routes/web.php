<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SawController;

use App\Http\Controllers\Pelanggan\BerandaController;
use App\Http\Controllers\Pelanggan\MenuController;
use App\Http\Controllers\Pelanggan\KeranjangController;
use App\Http\Controllers\Pelanggan\CheckoutController;
use App\Http\Controllers\Pelanggan\PesananController;
use App\Http\Controllers\Pelanggan\ProfilController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\TransaksiController as AdminTransaksi;

use App\Http\Controllers\Owner\DashboardController as OwnerDashboard;
use App\Http\Controllers\Owner\AdminController;
use App\Http\Controllers\Owner\LaporanController;
use App\Http\Controllers\Owner\StokController;

/* ===================================================
   PUBLIC — Landing & Auth Pelanggan
   =================================================== */

// Auth Pelanggan
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginFormPelanggan'])->name('login');
    Route::post('/login', [LoginController::class, 'loginPelanggan']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});


// Auth Admin/Owner (route terpisah)
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [LoginController::class, 'showLoginFormAdmin'])->name('admin.login');
    Route::post('/admin/login', [LoginController::class, 'loginAdmin']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/* ===================================================
   ROUTE SETELAH LOGIN
   =================================================== */

Route::middleware('auth')->group(function () {

    Route::get('/', [BerandaController::class, 'index'])->name('beranda');

    Route::get('/menu', [MenuController::class, 'index'])->name('pelanggan.menu');

});

/* ===================================================
   PELANGGAN (butuh login & role pelanggan)
   =================================================== */

Route::middleware(['auth', 'role:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');

    // Keranjang
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
    Route::post('/keranjang', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::put('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');

    // Checkout
// Sesuaikan prefix atau group jika rute pelanggan Anda menggunakan middleware tertentu
Route::post('/checkout/batal', [CheckoutController::class, 'batal'])
    ->name('keranjang.kosongkan');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'proses'])->name('checkout.proses');

    // Pesanan
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan');
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
    Route::post('/pesanan/{id}/batalkan', [PesananController::class, 'batalkan'])->name('pesanan.batalkan');

    // Profil
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');
});

/* ===================================================
   ADMIN (butuh login & role admin)
   =================================================== */

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Produk
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    // Transaksi
    Route::get('/transaksi', [AdminTransaksi::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{transaksi}', [AdminTransaksi::class, 'show'])->name('transaksi.show');
    Route::put('/transaksi/{transaksi}/status', [AdminTransaksi::class, 'updateStatus'])->name('transaksi.update-status');
});

/* ===================================================
   OWNER (butuh login & role owner)
   =================================================== */

Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerDashboard::class, 'index'])->name('dashboard');

    // 1. Mengelola Data Admin
    Route::resource('admins', AdminController::class);

    // 2. Mengelola Laporan
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');

    // 3. Melihat Stok Produk
    Route::get('stok', [StokController::class, 'index'])->name('stok.index');
    
});

Route::middleware(['auth'])->prefix('owner')->group(function () {
    // ... route dashboard lainnya ...
    Route::get('/saw', [SawController::class, 'index'])->name('owner.saw');
});