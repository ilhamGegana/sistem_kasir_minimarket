<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelMember extends Model
{
    use HasFactory;
    protected $table = 'members';
    protected $primaryKey = 'member_id';
    protected $fillable = ['nomor_member', 'nama_member', 'no_telepon', 'tanggal_daftar', 'tanggal_expired', 'status'];

    // Relasi ke tabel 'transaksi'
    public function transaksi()
    {
        return $this->hasMany(ModelTransaksi::class, 'member_id');
    }
}