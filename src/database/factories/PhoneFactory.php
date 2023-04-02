<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Phone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Phone>
 */
class PhoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone' => rand(79000000000, 79999999999),
            'type' => Phone::AVAILABLE_PHONE_TYPES[rand(0,1)],
        ];
    }
}
