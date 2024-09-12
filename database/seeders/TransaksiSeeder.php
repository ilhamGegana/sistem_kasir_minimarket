<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Transaksi tanpa member
        $transaksi1 = DB::table('transaksi')->insertGetId([
            'pengguna_id' => 2,  // Kasir dengan ID 2
            'member_id' => null,  // Non-member
            'tanggal' => now(),
            'total_harga' => 25000,
            'metode_pembayaran' => 'cash',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Detail transaksi 1 (non-member)
        DB::table('detail_transaksi')->insert([
            [
                'transaksi_id' => $transaksi1,
                'barang_id' => 1,  // Barang Astor
                'jumlah' => 1,
                'subtotal' => 10000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaksi_id' => $transaksi1,
                'barang_id' => 2,  // Barang Beng Beng
                'jumlah' => 1,
                'subtotal' => 8000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaksi_id' => $transaksi1,
                'barang_id' => 5,  // Barang Cheetos
                'jumlah' => 1,
                'subtotal' => 12000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Transaksi dengan member
        $transaksi2 = DB::table('transaksi')->insertGetId([
            'pengguna_id' => 2,  // Kasir dengan ID 2
            'member_id' => 1,  // Member dengan ID 1
            'tanggal' => now(),
            'total_harga' => 28000,
            'metode_pembayaran' => 'card',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Detail transaksi 2 (member)
        DB::table('detail_transaksi')->insert([
            [
                'transaksi_id' => $transaksi2,
                'barang_id' => 3,  // Barang Chiki Balls
                'jumlah' => 2,
                'subtotal' => 20000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaksi_id' => $transaksi2,
                'barang_id' => 4,  // Barang Chitato
                'jumlah' => 1,
                'subtotal' => 15000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}