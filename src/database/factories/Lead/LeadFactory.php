<?php

namespace Database\Factories\Lead;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class LeadFactory extends Factory
{
    protected const LOST_REASONS = [
        'Не договорились',
        'Обанкротился',
        'Ушел к конкурентам',
        'Компания закрылась',
        'Передумал',
    ];
    protected const STATUSES = [
        'closed',
        'reopen',
        'need approve',
        'new',
        'process',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->company(),
            'description' => fake()->text(250),
            'lead_value' => (double) rand(10000,9000000),
            'status' => self::STATUSES[rand(0, count(self::STATUSES) - 1)],
            'lost_reason' => self::LOST_REASONS[rand(0, count(self::LOST_REASONS) - 1)],
            'closed_at' => Carbon::now()->subDays(rand(2,10)),
        ];
    }
}
