<?php

use App\Http\Controllers\frontend\KasirController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\DetailTransaksiController;
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
Route::get('/menu-barang', function () {
    return view('barang.index');
})->name('barang.index');
Route::get('/bayar', function () {
    return view('barang.bayar');
})->name('barang.bayar');

Route::Group(['prefix' => 'admin/kategori'], function(){
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

