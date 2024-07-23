<?php

namespace Database\Seeders;

use App\Models\Province;
use App\Models\Role;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $province = Province::where('id', 31)->first();

        $regencies = $province->regencies;

        $districts = $regencies[2]->districts;

        $villages = $districts[5]->villages;

        $users = User::where('role_id', Role::where('code', 'witness')->value('id'))->get();

        foreach ($villages[3]->pollingStations as $pollingStation) {
            Vote::create([
                'polling_station_id' => $pollingStation->id,
                'vote_count' => fake()->numberBetween(1000, 100000),
                'attachment' => $pollingStation->village->id . '_' . $pollingStation->name . '.jpeg',
                'witness_id' => $users[0]->id,
                'organization_id' => 1,
                'created_by' => 1
            ]);
        }
    }
}
