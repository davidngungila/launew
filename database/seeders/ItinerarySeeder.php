<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\Itinerary;

class ItinerarySeeder extends Seeder
{
    public function run(): void
    {
        $serengeti = Tour::where('name', 'like', '%Serengeti%')->first();
        if ($serengeti) {
            $serengeti->itineraries()->createMany([
                ['day_number' => 1, 'title' => 'Arusha to Central Serengeti', 'description' => 'Pickup from Arusha and drive to Serengeti. Afternoon game drive.', 'accommodation' => 'Luxury Tents', 'meals' => 'L, D'],
                ['day_number' => 2, 'title' => 'Full Day Serengeti Plains', 'description' => 'Explore the vast plains tracking the big cats.', 'accommodation' => 'Luxury Tents', 'meals' => 'B, L, D'],
                ['day_number' => 5, 'title' => 'Serengeti to Arusha', 'description' => 'Morning game drive and drive back to Arusha.', 'accommodation' => 'Departure', 'meals' => 'B, L'],
            ]);
        }

        $kili = Tour::where('name', 'like', '%Kilimanjaro%')->first();
        if ($kili) {
            $kili->itineraries()->createMany([
                ['day_number' => 1, 'title' => 'Machame Gate to Machame Camp', 'description' => 'Trek through the rainforest.', 'accommodation' => 'Machame Camp', 'meals' => 'B, L, D'],
                ['day_number' => 7, 'title' => 'Summit Day: Mweka Gate', 'description' => 'Summit Uhuru Peak and descend to Mweka.', 'accommodation' => 'Arusha Hotel', 'meals' => 'B, L'],
            ]);
        }
    }
}
