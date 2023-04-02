<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => Appointment::BASE_APPOINTMENTS[rand(0,2)],
        ];
    }
}
