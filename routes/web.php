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

Route::prefix('kasir')->group(function () {
    Route::get('/menu-barang', [KasirController::class, 'index'])->name('kasir.index');
    
    Route::post('/tambah-ke-keranjang', [KasirController::class, 'tambahKeKeranjang'])->name('kasir.tambahKeKeranjang');
    
    Route::post('/update-keranjang/{id}', [KasirController::class, 'updateKeranjang'])->name('update-keranjang');
    
    Route::get('/checkout', [KasirController::class, 'checkout'])->name('kasir.checkout');
    
    Route::post('/keranjang/clear', [KasirController::class, 'clearKeranjang'])->name('keranjang.clear');
    
    Route::get('/bayar', [KasirController::class, 'bayar'])->name('kasir.bayar');
    
    Route::post('/check-member', [KasirController::class, 'checkMember'])->name('check.member');
    
    Route::post('/store-payment-method', [KasirController::class, 'storePaymentMethod'])->name('kasir.storePaymentMethod');

    Route::post('/proses-transaksi', [KasirController::class, 'prosesTransaksi'])->name('kasir.prosesTransaksi');
});

// Routing untuk dashboard pengguna setelah login (kasir)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [KasirController::class, 'index'])->name('dashboard');
});

// Route untuk menampilkan form login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Route untuk memproses form login
Route::post('/login', [LoginController::class, 'login'])->name('login');

// Route untuk logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
