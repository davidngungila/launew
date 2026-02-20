<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Lau Administrator',
            'email' => 'admin@lauparadise.com',
            'password' => \Hash::make('lau123'),
        ]);

        $this->call([
            TourSeeder::class,
            ItinerarySeeder::class,
        ]);
    }
}
