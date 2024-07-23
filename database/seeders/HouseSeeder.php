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

        $staffers = User::whereHas('role', function ($query) {
            $query->where('code', 'staffer');
        })->get();

        // STREETS
        $street1 = $organization->streets()->create([
            'name' => 'Pangeran Diponegoro',
            'province_id' => 31,
            'regency_id' => 3173,
            'district_id' => 3173020,
            'village_id' => 3173020001,
            'created_by' => $staffers[0]->id,
        ]);

        $street2 = $organization->streets()->create([
            'name' => 'Salemba Raya',
            'province_id' => 31,
            'regency_id' => 3173,
            'district_id' => 3173030,
            'village_id' => 3173030002,
            'created_by' => $staffers[1]->id,
        ]);

        $street3 = $organization->streets()->create([
            'name' => 'Palem Sisir 6',
            'province_id' => 31,
            'regency_id' => 3174,
            'district_id' => 3174080,
            'village_id' => 3174080003,
            'created_by' => $staffers[2]->id,
        ]);

        $street4 = $organization->streets()->create([
            'name' => 'Pondok Kelapa 7',
            'province_id' => 31,
            'regency_id' => 3172,
            'district_id' => 3172070,
            'village_id' => 3172070003,
            'created_by' => $staffers[3]->id,
        ]);

        $street5 = $organization->streets()->create([
            'name' => 'Boulevard Bukit Gading Raya',
            'province_id' => 31,
            'regency_id' => 3175,
            'district_id' => 3175050,
            'village_id' => 3175050001,
            'created_by' => $staffers[4]->id,
        ]);

        // HOUSES
        $houses = $organization->houses()->createMany([
            [
                'number' => 7,
                'name' => null,
                'unit' => null,
                'street_id' => $street1->id,
                'created_by' => $street1->creator->id,
            ],
            [
                'number' => 58,
                'name' => null,
                'unit' => null,
                'street_id' => $street1->id,
                'created_by' => $street1->creator->id,
            ],
            [
                'number' => 101,
                'name' => null,
                'unit' => null,
                'street_id' => $street1->id,
                'created_by' => $street1->creator->id,
            ],
            [
                'number' => 150,
                'name' => 'Capitol Park Residence',
                'unit' => 'S1550',
                'street_id' => $street2->id,
                'created_by' => $street2->creator->id,
            ],
            [
                'number' => 'B15/3A',
                'name' => null,
                'unit' => null,
                'street_id' => $street3->id,
                'created_by' => $street3->creator->id,
            ],
            [
                'number' => 'B20/4',
                'name' => null,
                'unit' => null,
                'street_id' => $street3->id,
                'created_by' => $street3->creator->id,
            ],
            [
                'number' => '12',
                'name' => null,
                'unit' => null,
                'street_id' => $street4->id,
                'created_by' => $street4->creator->id,
            ],
            [
                'number' => '28',
                'name' => null,
                'unit' => null,
                'street_id' => $street4->id,
                'created_by' => $street4->creator->id,
            ],
            [
                'number' => '77',
                'name' => null,
                'unit' => null,
                'street_id' => $street4->id,
                'created_by' => $street4->creator->id,
            ],
            [
                'number' => '1',
                'name' => null,
                'unit' => null,
                'street_id' => $street5->id,
                'created_by' => $street5->creator->id,
            ],
            [
                'number' => '2',
                'name' => null,
                'unit' => null,
                'street_id' => $street5->id,
                'created_by' => $street5->creator->id,
            ],
            [
                'number' => '3',
                'name' => null,
                'unit' => null,
                'street_id' => $street5->id,
                'created_by' => $street5->creator->id,
            ],
            [
                'number' => '4',
                'name' => null,
                'unit' => null,
                'street_id' => $street5->id,
                'created_by' => $street5->creator->id,
            ],
            [
                'number' => '5',
                'name' => null,
                'unit' => null,
                'street_id' => $street5->id,
                'created_by' => $street5->creator->id,
            ],
        ]);

        // CONTACTS
        foreach ($houses as $house) {
            Contact::factory()
                ->for($organization)
                ->for($house)
                ->count(rand(1, 5))
                ->state(new Sequence(
                    ['gender' => 'male'],
                    ['gender' => 'female'],
                ))
                ->create([
                    'created_by' => $house->creator->id,
                ]);
        }
    }
}
