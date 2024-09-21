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
Route::get('/bayar', function () {
    return view('barang.bayar');
})->name('barang.bayar');

Route::Group(['prefix' => 'admin/kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']); //menampilkan halaman awal user
    Route::post('/list', [KategoriController::class, 'list']);  //menampilkan data user dalam bentuk json untuk datables
    Route::get('/create', [KategoriController::class, 'create']); //menampilkan hallaman form tambah user
    Route::post('/', [KategoriController::class, 'store']); //menyimpan data user baru
    Route::get('/{id}', [KategoriController::class, 'show']); //menampilkan detail user
    Route::get('/{id}/edit', [KategoriController::class, 'edit']); //menampilkan halaman form edit
    Route::put('/{id}', [KategoriController::class, 'update']); //menyimpan perubahan data user
    Route::delete('/{id}', [KategoriController::class, 'destroy']); //menghapus data user
});


Route::Group(['prefix' => 'admin/member'], function(){
    Route::get('/', [MembersController::class, 'index']); //menampilkan halaman awal user
    Route::post('/list', [MembersController::class, 'list']);  //menampilkan data user dalam bentuk json untuk datables
    Route::get('/create', [MembersController::class, 'create']); //menampilkan hallaman form tambah user
    Route::post('/', [MembersController::class, 'store']); //menyimpan data user baru
    Route::get('/{id}', [MembersController::class, 'show']); //menampilkan detail user
    Route::get('/{id}/edit', [MembersController::class, 'edit']); //menampilkan halaman form edit
    Route::put('/{id}', [MembersController::class, 'update']); //menyimpan perubahan data user
    Route::delete('/{id}', [MembersController::class, 'destroy']); //menghapus data user
});

Route::get('admin/detailTransaksi', [DetailTransaksiController::class, 'index'])->name('admin.detailTransaksi.index');
Route::post('admin/detailTransaksi', [DetailTransaksiController::class, 'getData'])->name('admin.detailTransaksi.data');
Route::get('admin/detailTransaksi/pdf', [DetailTransaksiController::class, 'exportPDF'])->name('admin.detailTransaksi.pdf');


Route::Group(['prefix' => 'admin/barang'], function () {
    Route::get('/', [BarangController::class, 'index']); //menampilkan halaman awal user
    Route::post('/list', [BarangController::class, 'list']);  //menampilkan data user dalam bentuk json untuk datables
    Route::get('/create', [BarangController::class, 'create']); //menampilkan hallaman form tambah user
    Route::post('/', [BarangController::class, 'store']); //menyimpan data user baru
    Route::get('/{id}', [BarangController::class, 'show']); //menampilkan detail user
    Route::get('/{id}/edit', [BarangController::class, 'edit']); //menampilkan halaman form edit
    Route::put('/{id}', [BarangController::class, 'update']); //menyimpan perubahan data user
    Route::delete('/{id}', [BarangController::class, 'destroy']); //menghapus data user
});

Route::Group(['prefix' => 'admin/pengguna'], function () {
    Route::get('/', [PenggunaController::class, 'index']); //menampilkan halaman awal user
    Route::post('/list', [PenggunaController::class, 'list']);  //menampilkan data user dalam bentuk json untuk datables
    Route::get('/create', [PenggunaController::class, 'create']); //menampilkan hallaman form tambah user
    Route::post('/', [PenggunaController::class, 'store']); //menyimpan data user baru
    Route::get('/{id}', [PenggunaController::class, 'show']); //menampilkan detail user
    Route::get('/{id}/edit', [PenggunaController::class, 'edit']); //menampilkan halaman form edit
    Route::put('/{id}', [PenggunaController::class, 'update']); //menyimpan perubahan data user
    Route::delete('/{id}', [PenggunaController::class, 'destroy']); //menghapus data user
});

