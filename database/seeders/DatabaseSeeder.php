<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::unprepared(file_get_contents(base_path() . '/database/indonesia.sql'));
        DB::unprepared(file_get_contents(base_path() . '/database/polling-station.sql'));
        DB::unprepared(file_get_contents(base_path() . '/database/precinct.sql'));

        $this->call([
            RoleSeeder::class,
            OrganizationSeeder::class,
            UserSeeder::class,
            EmploymentSeeder::class,
            HouseSeeder::class,
            InteractionSeeder::class,
            VoteSeeder::class
        ]);
    }
}
