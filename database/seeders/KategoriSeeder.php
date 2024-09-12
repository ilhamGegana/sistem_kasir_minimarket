<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('kategori_barang')->insert([
            ['kode_kategori' => 'SNK', 'nama_kategori' => 'Snack', 'created_at' => now(), 'updated_at' => now()],
            ['kode_kategori' => 'MNM', 'nama_kategori' => 'Minuman', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}