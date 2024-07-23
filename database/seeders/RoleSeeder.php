<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            [
                'code' => 'owner',
                'name' => 'Pemilik',
                'description' => 'Mempunyai akses ke semua fitur'
            ],
            [
                'code' => 'admin',
                'name' => 'Admin',
                'description' => 'Mempunyai akses ke semua fitur'
            ],
            [
                'code' => 'staffer',
                'name' => 'Staff',
                'description' => 'Mempunyai akses ke fitur manajemen data pemilih (kecuali interaksi), arsip suara, manajemen jadwal kegiatan dan dashboard'
            ],
            [
                'code' => 'coordinator',
                'name' => 'Koordinator',
                'description' => 'Mempunyai akses ke fitur manajemen data pemilih, arsip suara dan menerima jadwal kegiatan dan statisktik (terbatas)'
            ],
            [
                'code' => 'volunteer',
                'name' => 'Relawan',
                'description' => 'Terbatas untuk mengakses fitur Interaksi dan sebagian data pemilih yang telah ditentukan'
            ],
            [
                'code' => 'witness',
                'name' => 'Saksi',
                'description' => 'Terbatas untuk melakukan arsip suara'
            ]
        ]);
    }
}
