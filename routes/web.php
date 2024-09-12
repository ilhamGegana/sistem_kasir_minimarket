<?php

use App\Http\Controllers\frontend\KasirController;
use App\Http\Controllers\KategoriController;
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