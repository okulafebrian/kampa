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
        $organization = Organization::first();

        $role = Role::where('code', 'owner')->first();
        $owner = User::create([
            'first_name' => 'Dian',
            'last_name' => 'Permata',
            'phone' => '6281398765432',
            'email' => 'dianpermata@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('abc123'),
            'status' => 'active',
            'role_id' => $role->id,
            'invited_by' => null,
            'joined_at' => Carbon::now(),
            'organization_id' => $organization->id
        ]);

        $role = Role::where('code', 'admin')->first();
        $admin1 = User::create([
            'first_name' => 'Rizky',
            'last_name' => 'Santoso',
            'phone' => '6281398765432',
            'email' => 'rizkysantoso@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('abc123'),
            'status' => 'active',
            'role_id' => $role->id,
            'invited_by' => $owner->id,
            'joined_at' => Carbon::now(),
            'organization_id' => $organization->id
        ]);

        $admin2 = User::create([
            'first_name' => 'Andi',
            'last_name' => 'Pratama',
            'phone' => '6281523456789',
            'email' => 'andipratama@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('abc123'),
            'status' => 'active',
            'role_id' => $role->id,
            'invited_by' => $owner->id,
            'joined_at' => Carbon::now(),
            'organization_id' => $organization->id
        ]);


        $role = Role::where('code', 'staffer')->first();
        $staffers = User::factory()
            ->count(5)
            ->for($organization)
            ->for($role)
            ->create([
                'invited_by' => $admin1->id
            ]);

        $role = Role::where('code', 'coordinator')->first();
        $coordinators = User::factory()
            ->count(3)
            ->for($organization)
            ->for($role)
            ->create([
                'invited_by' => $admin1->id
            ]);

        $role = Role::where('code', 'volunteer')->first();
        $volunteers = User::factory()
            ->count(3)
            ->for($organization)
            ->for($role)
            ->create([
                'invited_by' => $admin2->id
            ]);

        $role = Role::where('code', 'witness')->first();
        $witnesses = User::factory()
            ->count(3)
            ->for($organization)
            ->for($role)
            ->create([
                'invited_by' => $admin2->id
            ]);
    }
}
