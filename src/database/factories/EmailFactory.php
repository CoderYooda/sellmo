<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Email;
use App\Models\Phone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Phone>
 */
class EmailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->email(),
            'type' => Email::AVAILABLE_EMAIL_TYPES[rand(0,1)],
        ];
    }
}
