<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $owner = User::create([
            'first_name' => 'Dian',
            'last_name' => 'Permata',
            'phone' => '6281398765432',
            'email' => 'dian.permata@gmail.com',
            'email_verified_at' => $now->subDays(6)->toDateTimeString(),
            'password' => Hash::make('abc123'),
            'status' => 'active',
            'role_id' => 1,
            'invited_by' => null,
            'joined_at' => $now->subDays(6)->toDateTimeString(),
            'organization_id' => 1,
            'created_at' => $now->subDays(6)->toDateTimeString()
        ]);

        $admin = User::create([
            'first_name' => 'Rizky',
            'last_name' => 'Santoso',
            'phone' => '6282234567890',
            'email' => 'rizky.santoso@gmail.com',
            'email_verified_at' => $now->subDays(5)->toDateTimeString(),
            'password' => Hash::make('abc123'),
            'status' => 'active',
            'role_id' => 2,
            'invited_by' => $owner->id,
            'joined_at' => $now->subDays(5)->toDateTimeString(),
            'organization_id' => 1,
            'created_at' => $now->subDays(6)->toDateTimeString()
        ]);

        $staffer = User::create([
            'first_name' => 'Gilang',
            'last_name' => 'Ari',
            'phone' => '6281134567890',
            'email' => 'gilang.ari@gmail.com',
            'email_verified_at' => $now->subDays(4)->toDateTimeString(),
            'password' => Hash::make('abc123'),
            'status' => 'active',
            'role_id' => 3,
            'invited_by' => $admin->id,
            'joined_at' => $now->subDays(4)->toDateTimeString(),
            'organization_id' => 1,
            'created_at' => $now->subDays(5)->toDateTimeString()
        ]);

        $coordinator = User::create([
            'first_name' => 'Agus',
            'last_name' => 'Prasetyo',
            'phone' => '6281123456789',
            'email' => 'agus.prasetyo@gmail.com',
            'email_verified_at' => $now->subDays(4)->toDateTimeString(),
            'password' => Hash::make('abc123'),
            'status' => 'active',
            'role_id' => 4,
            'invited_by' => $admin->id,
            'joined_at' => $now->subDays(4)->toDateTimeString(),
            'organization_id' => 1,
            'created_at' => $now->subDays(5)->toDateTimeString()
        ]);

        $volunteer = User::create([
            'first_name' => 'Maya',
            'last_name' => 'Putri',
            'phone' => '6282123456789',
            'email' => 'maya.putri@gmail.com',
            'email_verified_at' => $now->subDays(2)->toDateTimeString(),
            'password' => Hash::make('abc123'),
            'status' => 'active',
            'role_id' => 5,
            'invited_by' => $coordinator->id,
            'joined_at' => $now->subDays(2)->toDateTimeString(),
            'organization_id' => 1,
            'created_at' => $now->subDays(4)->toDateTimeString()
        ]);

        $witness = User::create([
            'first_name' => 'Sari',
            'last_name' => 'Dewi',
            'phone' => '6281323456789',
            'email' => 'sari.dewi@gmail.com',
            'email_verified_at' => $now->subDays(2)->toDateTimeString(),
            'password' => Hash::make('abc123'),
            'status' => 'active',
            'role_id' => 6,
            'invited_by' => $coordinator->id,
            'joined_at' => $now->subDays(2)->toDateTimeString(),
            'organization_id' => 1,
            'created_at' => $now->subDays(4)->toDateTimeString()
        ]);
    }
}
