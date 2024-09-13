<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ModelPengguna extends Model
{
    use HasFactory;

    protected $table = 'pengguna';
    protected $primaryKey = 'pengguna_id';
    protected $fillable = ['username', 'password', 'role'];

    protected $hidden = ['password'];

    // Relasi ke tabel 'transaksi'
    public function transaksi()
    {
        return $this->hasMany(ModelTransaksi::class, 'pengguna_id');
    }
}