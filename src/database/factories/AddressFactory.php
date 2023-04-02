<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Phone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Phone>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_address' => fake()->address(),
            'postal_code' => rand(100000, 999999),
            'country' => fake()->country(),
            'region' => rand(1,99),
            'city' => fake()->city(),
            'street' => fake()->streetName,
            'house' => rand(1, 999),
        ];
    }
}
