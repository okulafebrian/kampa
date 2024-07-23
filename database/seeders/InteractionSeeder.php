<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Interaction;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InteractionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = Contact::all();

        $today = Carbon::now();

        foreach ($contacts as $contact) {
            $status = fake()->randomElement(['answered', 'call back', 'not interested', 'not home', 'inaccessible']);

            $today = $today->subDay();

            Interaction::create([
                'status' => $status,
                'support_level' => $status == 'answered' ? fake()->numberBetween(1, 5) : null,
                'contact_id' => $contact->id,
                'user_id' => 1,
                'organization_id' => 1,
                'created_at' => $today
            ]);
        }

        $today = Carbon::now();

        foreach ($contacts as $contact) {
            $status = fake()->randomElement(['answered', 'call back', 'not interested', 'not home', 'inaccessible']);

            $today = $today->subDay();

            Interaction::create([
                'status' => $status,
                'support_level' => $status == 'answered' ? fake()->numberBetween(1, 5) : null,
                'contact_id' => $contact->id,
                'user_id' => 1,
                'organization_id' => 1,
                'created_at' => $today
            ]);
        }
    }
}
