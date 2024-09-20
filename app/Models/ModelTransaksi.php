<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelTransaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'transaksi_id';
    protected $fillable = ['pengguna_id', 'member_id', 'tanggal', 'total_harga', 'metode_pembayaran'];

    // Relasi ke tabel 'pengguna'
    public function pengguna()
    {
        return $this->belongsTo(ModelPengguna::class, 'pengguna_id');
    }

    // Relasi ke tabel 'members'
    public function member()
    {
        return $this->belongsTo(ModelMember::class, 'member_id');
    }

    // Relasi ke tabel 'detail_transaksi'
    public function detailTransaksi()
    {
        return $this->hasMany(ModelDetailTransaksi::class, 'transaksi_id');
    }
}