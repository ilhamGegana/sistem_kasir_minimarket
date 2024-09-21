<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelBarang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'barang_id';
    protected $fillable = ['kode_barang', 'nama_barang', 'kategori_id', 'harga', 'stok'];

    // Relasi ke tabel 'kategori_barang'
    public function kategori()
    {
        return $this->belongsTo(ModelKategori::class, 'kategori_id');
    }

    // Relasi ke tabel 'detail_transaksi'
    public function detailTransaksi()
    {
        return $this->hasMany(ModelDetailTransaksi::class, 'barang_id');
    }
}