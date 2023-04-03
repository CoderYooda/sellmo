<?php

namespace Database\Factories\Lead;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class LeadTypeFactory extends Factory
{
    protected const TYPES = [
        'Новый клиент',
        'Повторный клиент',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => self::TYPES[rand(0, count(self::TYPES) - 1)],
        ];
    }
}
