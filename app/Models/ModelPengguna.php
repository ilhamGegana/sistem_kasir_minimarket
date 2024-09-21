<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ModelPengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'pengguna_id';

    protected $fillable = ['username', 'name','password', 'role'];

    protected $hidden = ['password'];

    public $timestamps = false;


    // Relasi ke tabel 'transaksi'
    public function transaksi()
    {
        return $this->hasMany(ModelTransaksi::class, 'pengguna_id');
    }
}