<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Organization::create([
            'name' => 'Koalisi Perubahan Jakarta',
            'election_type' => 'governor',
            'region_id' => 31 // JAKARTA
        ]);
    }
}
