<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = fake()->randomFloat(2,2000,1000000);
        $serviceIds = Service::pluck('id')->toArray();
        return [
            'name' => 'Offer'. rand(1,10),
            'description' => 'Description for Offer',
            'price' => $price,
            'bonus_points' => $price/100,
            'duration_in_hours' => 24*rand(1,30),
            'service_id' => fake()->randomElement($serviceIds),
            'offer_number' => rand(1,10)
        ];
    }
}
