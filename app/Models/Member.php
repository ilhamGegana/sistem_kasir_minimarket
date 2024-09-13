<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $primaryKey = 'member_id';

    protected $keyType = 'string';

    public $incrementing = true; // Karena member_id tidak auto increment
    public $timestamps = true; // created_at dan updated_at akan otomatis dikelola oleh Laravel

    protected $fillable = [
        'member_id',
        'nomor_member',
        'nama_member',
        'no_telepon',
        'tanggal_daftar',
        'tanggal_expired',
        'status'
    ];

    // Format tanggal yang akan digunakan
    protected $dates = ['tanggal_daftar', 'tanggal_expired'];

    // Jika kamu ingin mengubah format penyimpanan atau menampilkan tanggal
    protected $casts = [
        'tanggal_daftar' => 'datetime:Y-m-d',
        'tanggal_expired' => 'datetime:Y-m-d',
    ];
}
