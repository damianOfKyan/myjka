<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Contractor;
use App\Models\Certificate;
use App\Models\WashingProcedure;
use App\Models\WashingRange;
use App\Models\Detergent;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'owner' => true,
        ]);

        // $washingProcedures = WashingProcedure::factory(100)->create();
        // $washingRanges = WashingRange::factory(100)->create();
        // $detergents = Detergent::factory(100)->create();
        // $contacts = Contact::factory(100)->create();

        // $contractors = Contractor::factory(100)
        //     ->create([
        //         'contact_id' => $contacts->random()->id
        //     ])
        //     ->each(function ($contractors) {
        //         $contractors->update(['contact_id' => $contractors->id]);
        //     });

        // $certificates = Certificate::factory(100)
        //     ->create([
        //         'contractor_id' => $contractors->random()->id,
        //         'driver_id' => $contacts->random()->id
        //     ])
        //     ->each(function ($certificates) use (
        //         $contractors,
        //         $contacts,
        //         $washingProcedures,
        //         $washingRanges,
        //         $detergents
        //     ) {
        //         $certificates->update(['contractor_id' => $contractors->random()->id]);
        //         $certificates->update(['driver_id' => $contacts->random()->id]);
        //         $certificates->washingRange()->sync([$washingRanges->random()->id, $washingRanges->random()->id]);
        //         $certificates->washingProcedure()->sync([$washingProcedures->random()->id, $washingProcedures->random()->id]);
        //         $certificates->detergent()->sync([$detergents->random()->id, $detergents->random()->id]);
        //     });
    }
}
