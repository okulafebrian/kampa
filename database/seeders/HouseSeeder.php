<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organization = Organization::first();

        $street1 = $organization->streets()->create([
            'name' => 'Pangeran Diponegoro',
            'province_id' => 31,
            'regency_id' => 3173,
            'district_id' => 3173020,
            'village_id' => 3173020001,
            'created_by' => 1,
        ]);

        $street2 = $organization->streets()->create([
            'name' => 'Salemba Raya',
            'province_id' => 31,
            'regency_id' => 3173,
            'district_id' => 3173030,
            'village_id' => 3173030002,
            'created_by' => 1,
        ]);

        // HOUSES
        foreach (range(1, 10) as $value) {
            $house = $organization->houses()->create([
                'number' => $value,
                'name' => null,
                'unit' => null,
                'street_id' => $street1->id,
                'created_by' => 1,
            ]);

            Contact::factory()
                ->for($organization)
                ->for($house)
                ->count(rand(1, 3))
                ->state(new Sequence(
                    ['gender' => 'male'],
                    ['gender' => 'female'],
                ))
                ->create([
                    'created_by' => 1,
                ]);
        }

        foreach (range(100, 110) as $value) {
            $house = $organization->houses()->create([
                'number' => $value,
                'name' => null,
                'unit' => null,
                'street_id' => $street2->id,
                'created_by' => 1,
            ]);

            Contact::factory()
                ->for($organization)
                ->for($house)
                ->count(rand(1, 3))
                ->state(new Sequence(
                    ['gender' => 'male'],
                    ['gender' => 'female'],
                ))
                ->create([
                    'created_by' => 1,
                ]);
        }
    }
}
