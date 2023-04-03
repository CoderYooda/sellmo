<?php

namespace Database\Factories\Lead;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class LeadSourceFactory extends Factory
{
    protected const SOURCES = [
        'Интернет',
        'Холодный звонок',
        'Реклама',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => self::SOURCES[rand(0, count(self::SOURCES) - 1)],
        ];
    }
}
