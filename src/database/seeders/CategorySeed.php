<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Главная',
            'type' => Category::TYPE_SYSTEM,
            'slug' => 'root',
            'children' => [
                [
                    'name' => 'Товары',
                    'type' => Category::TYPE_SYSTEM,
                    'slug' => 'products',
                ],
                [
                    'name' => 'Услуги',
                    'type' => Category::TYPE_SYSTEM,
                    'slug' => 'service',
                ],
            ],
        ]);
    }
}
