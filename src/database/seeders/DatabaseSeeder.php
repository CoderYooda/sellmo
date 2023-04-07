<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategorySeed::class,
            CompanySeed::class,
        ]);

         \App\Models\User::factory()->create([
             'name' => 'Administrator',
             'email' => 'admin@admin.com',
             'password' => bcrypt('admin'),
         ]);
    }
}
