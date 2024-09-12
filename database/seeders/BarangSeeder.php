<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('barang')->insert([
            // Barang Kategori Snack
            [
                'kode_barang' => 'BRG001',
                'nama_barang' => 'Astor',
                'kategori_id' => 1,  // Kategori Snack
                'harga' => 10000,
                'stok' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'BRG002',
                'nama_barang' => 'Beng Beng',
                'kategori_id' => 1,  // Kategori Snack
                'harga' => 8000,
                'stok' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'BRG003',
                'nama_barang' => 'Chiki Balls',
                'kategori_id' => 1,  // Kategori Snack
                'harga' => 10000,
                'stok' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'BRG004',
                'nama_barang' => 'Chitato',
                'kategori_id' => 1,  // Kategori Snack
                'harga' => 15000,
                'stok' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Barang Kategori Minuman
            [
                'kode_barang' => 'BRG005',
                'nama_barang' => 'Aqua',
                'kategori_id' => 2,  // Kategori Minuman
                'harga' => 3000,
                'stok' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'BRG006',
                'nama_barang' => 'Teh Botol Sosro',
                'kategori_id' => 2,  // Kategori Minuman
                'harga' => 5000,
                'stok' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'BRG007',
                'nama_barang' => 'Coca Cola',
                'kategori_id' => 2,  // Kategori Minuman
                'harga' => 8000,
                'stok' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'BRG008',
                'nama_barang' => 'Fanta',
                'kategori_id' => 2,  // Kategori Minuman
                'harga' => 8000,
                'stok' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}