<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\PhoneNumberBackup;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for($i =1; $i<=5; $i++){
         \App\Models\Offer::factory()->create([
            'name' => 'Offer'. $i,
            'service_id' => 1,
            'offer_number' => $i
         ]);
         \App\Models\Offer::factory()->create([
            'name' => 'Offer'. $i,
            'service_id' => 2,
            'offer_number' => $i
         ]);
         \App\Models\Offer::factory()->create([
            'name' => 'Offer'. $i,
            'service_id' => 3,
            'offer_number' => $i
         ]);
         \App\Models\Offer::factory()->create([
            'name' => 'Offer'. $i,
            'service_id' => 4,
            'offer_number' => $i
         ]);
         \App\Models\Offer::factory()->create([
            'name' => 'Offer'. $i,
            'service_id' => 5,
            'offer_number' => $i
         ]);
        }

        PhoneNumberBackup::factory(100)->create();

    }
}
