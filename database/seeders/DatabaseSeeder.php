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

        User::query()->updateOrCreate(
            ['email' => 'admin@lauparadise.com'],
            [
                'name' => 'Lau Administrator',
                'password' => \Hash::make('lau123'),
            ]
        );

        $this->call([
            RolesPermissionsSeeder::class,
            TourSeeder::class,
            ItinerarySeeder::class,
        ]);
    }
}
