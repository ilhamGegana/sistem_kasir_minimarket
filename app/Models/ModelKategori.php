<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelKategori extends Model
{
    use HasFactory;
    protected $table = 'kategori_barang';
    protected $primaryKey = 'kategori_id';
    protected $fillable = ['kode_kategori', 'nama_kategori'];

    // Relasi ke tabel 'barang'
    public function barang()
    {
        return $this->hasMany(ModelBarang::class, 'kategori_id');
    }
}