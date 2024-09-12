<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('members')->insert([
            [
                'nomor_member' => 'MBR001',
                'nama_member' => 'Ilham Gegana',
                'no_telepon' => '08123456789',
                'tanggal_daftar' => now(),
                'tanggal_expired' => now()->addYear(),
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_member' => 'MBR002',
                'nama_member' => 'Benedictus Felix',
                'no_telepon' => '08198765432',
                'tanggal_daftar' => now(),
                'tanggal_expired' => now()->addYear(),
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_member' => 'MBR003',
                'nama_member' => 'Risal Maulana',
                'no_telepon' => '08198765123',
                'tanggal_daftar' => now(),
                'tanggal_expired' => now()->addYear(),
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}