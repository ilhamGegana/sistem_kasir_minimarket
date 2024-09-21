<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DataBarangController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KategoriController;

use App\Http\Controllers\MembersController;
use App\Http\Controllers\DetailTransaksiController;

use App\Http\Controllers\PenggunaController;

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
// Rute untuk login dan logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Middleware 'auth' memastikan pengguna sudah login
Route::middleware(['auth'])->group(function () {

    // Route untuk dashboard kasir (dengan role 'kasir')
    Route::middleware('role:kasir')->group(function () {
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
            Route::get('/kasir/cetak-nota/{transaksi_id}', [KasirController::class, 'cetakNota'])->name('kasir.cetakNota');
        });
    });

    // Route untuk dashboard admin (dengan role 'admin')
    Route::middleware('admin')->group(function () {
        Route::prefix('admin/kategori')->name('admin.kategori.')->group(function () {
            Route::get('/', [KategoriController::class, 'index'])->name('index');
            Route::post('/list', [KategoriController::class, 'list'])->name('list'); 
            Route::get('/create', [KategoriController::class, 'create'])->name('create');
            Route::post('/', [KategoriController::class, 'store'])->name('store'); 
            Route::get('/{id}', [KategoriController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('edit');
            Route::put('/{id}', [KategoriController::class, 'update'])->name('update');
            Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('admin/member')->group(function () {
            Route::get('/', [MembersController::class, 'index']);
            Route::post('/list', [MembersController::class, 'list']);
            Route::get('/create', [MembersController::class, 'create']);
            Route::post('/', [MembersController::class, 'store']);
            Route::get('/{id}', [MembersController::class, 'show']);
            Route::get('/{id}/edit', [MembersController::class, 'edit']);
            Route::put('/{id}', [MembersController::class, 'update']);
            Route::delete('/{id}', [MembersController::class, 'destroy']);
        });

        Route::get('admin/detailTransaksi', [DetailTransaksiController::class, 'index'])->name('admin.detailTransaksi.index');
        Route::post('admin/detailTransaksi', [DetailTransaksiController::class, 'getData'])->name('admin.detailTransaksi.data');
        Route::get('admin/detailTransaksi/pdf', [DetailTransaksiController::class, 'exportPDF'])->name('admin.detailTransaksi.pdf');

        Route::prefix('admin/barang')->group(function () {
            Route::get('/', [BarangController::class, 'index']);
            Route::post('/list', [BarangController::class, 'list']);
            Route::get('/create', [BarangController::class, 'create']);
            Route::post('/', [BarangController::class, 'store']);
            Route::get('/{id}', [BarangController::class, 'show']);
            Route::get('/{id}/edit', [BarangController::class, 'edit']);
            Route::put('/{id}', [BarangController::class, 'update']);
            Route::delete('/{id}', [BarangController::class, 'destroy']);
        });

        Route::prefix('admin/pengguna')->group(function () {
            Route::get('/', [PenggunaController::class, 'index']);
            Route::post('/list', [PenggunaController::class, 'list']);
            Route::get('/create', [PenggunaController::class, 'create']);
            Route::post('/', [PenggunaController::class, 'store']);
            Route::get('/{id}', [PenggunaController::class, 'show']);
            Route::get('/{id}/edit', [PenggunaController::class, 'edit']);
            Route::put('/{id}', [PenggunaController::class, 'update']);
            Route::delete('/{id}', [PenggunaController::class, 'destroy']);
        });
    });
});
