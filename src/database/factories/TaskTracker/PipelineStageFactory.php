<?php

namespace Database\Factories\TaskTracker;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class PipelineStageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->city();
        $slug = translit($name);
        return [
            'name' => $name,
            'slug' => $slug,
            'order' => rand(0,10),
        ];
    }
}
