<?php

namespace Database\Seeders;

use App\Models\Employment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmploymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employment::insert([
            [
                'name' => "Belum/Tidak bekerja"
            ],
            [
                'name' => 'Aparatur/Pejabat negara'
            ],
            [
                'name' => 'Tenaga pengajar'
            ],
            [
                'name' => 'Wiraswasta'
            ],
            [
                'name' => 'Pertanian/Perternakan/Perkebunan'
            ],
            [
                'name' => 'Nelayan/Perikanan'
            ],
            [
                'name' => 'Agama dan kepercayaan'
            ],
            [
                'name' => 'Pelajar/Mahasiswa'
            ],
            [
                'name' => 'Tenaga kesehatan'
            ],
            [
                'name' => 'Pensiunan',
            ],
            [
                'name' => 'Buruh Harian Lepas',
            ],
            [
                'name' => "Lainnya",
            ]
        ]);
    }
}
