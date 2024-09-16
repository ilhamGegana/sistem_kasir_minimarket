<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggunaModel extends Model
{
    use HasFactory;

    protected $table = 'pengguna';

    protected $primaryKey = 'pengguna_id';

    public $timestamps = false;

    protected $fillable = ['username', 'nama', 'role'];

    protected $hidden = ['password'];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
