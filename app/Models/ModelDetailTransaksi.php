<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelDetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi';
    protected $primaryKey = 'detail_id';
    protected $fillable = ['transaksi_id', 'barang_id', 'jumlah', 'subtotal'];

    // Relasi ke tabel 'transaksi'
    public function transaksi()
    {
        return $this->belongsTo(ModelTransaksi::class, 'transaksi_id');
    }

    // Relasi ke tabel 'barang'
    public function barang()
    {
        return $this->belongsTo(ModelBarang::class, 'barang_id');
    }
}