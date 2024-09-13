<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriModel extends Model
{
    // Nama tabel yang sesuai dengan nama tabel di database
    protected $table = 'kategori_barang';
    
    // Kolom yang bisa diisi massal
    protected $fillable = ['kode_kategori', 'nama_kategori']; // Ganti dengan kolom yang sesuai

    // Jika tabel tidak memiliki kolom timestamp
    public $timestamps = true;

     // Menyebutkan kolom primary key
     protected $primaryKey = 'kategori_id'; // Ganti dengan nama kolom primary key yang sesuai


    // Tipe primary key (misalnya, string jika menggunakan UUID)
    protected $keyType = 'string'; 

    // Relasi dengan UserModel
   
}
