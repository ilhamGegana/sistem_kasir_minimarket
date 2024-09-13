<?php

use App\Http\Controllers\frontend\KasirController;
use App\Http\Controllers\PilihBarangController;
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
Route::get('/menu-barang', [PilihBarangController::class, 'index'])->name('barang.index');

Route::post('/tambah-ke-keranjang', [PilihBarangController::class, 'tambahKeKeranjang'])->name('barang.tambahKeKeranjang');

Route::post('/update-keranjang/{id}', [PilihBarangController::class, 'updateKeranjang'])->name('update-keranjang');

Route::get('/bayar', function () {
    return view('barang.bayar');
})->name('barang.bayar');

Route::get('/admin_kat', function () {
    return view('admin.kategori');
})->name('admin.kategori');
