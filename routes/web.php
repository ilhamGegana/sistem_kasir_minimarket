<?php

use App\Http\Controllers\KasirController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/menu-barang', [KasirController::class, 'index'])->name('barang.index');

Route::post('/tambah-ke-keranjang', [KasirController::class, 'tambahKeKeranjang'])->name('barang.tambahKeKeranjang');

Route::post('/update-keranjang/{id}', [KasirController::class, 'updateKeranjang'])->name('update-keranjang');

Route::get('/checkout', [KasirController::class, 'checkout'])->name('barang.checkout');

Route::post('/keranjang/clear', [KasirController::class, 'clearKeranjang'])->name('keranjang.clear');

// Route untuk menampilkan form login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Route untuk memproses form login
Route::post('/login', [LoginController::class, 'login'])->name('login');

// Route untuk logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/bayar', function () {
    return view('barang.bayar');
})->name('barang.bayar');

Route::get('/admin_kat', function () {
    return view('admin.kategori');
})->name('admin.kategori');

Route::post('/check-member', [KasirController::class, 'checkMember'])->name('check.member');

// Routing untuk dashboard pengguna setelah login (kasir)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [KasirController::class, 'index'])->name('dashboard');
});
