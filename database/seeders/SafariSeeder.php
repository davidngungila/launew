<?php

namespace Database\Seeders;

use App\Models\Tour;
use App\Models\Itinerary;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SafariSeeder extends Seeder
{
    public function run(): void
    {
        $tour1 = Tour::create([
            'name' => 'Serengeti Classic Safari',
            'slug' => 'serengeti-classic-safari',
            'description' => 'A comprehensive 5-day safari through the heart of the Serengeti.',
            'location' => 'Serengeti National Park',
            'duration_days' => 5,
            'base_price' => 1250.00,
            'featured' => true,
            'status' => 'active',
        ]);

        Itinerary::create([
            'tour_id' => $tour1->id,
            'day_number' => 1,
            'title' => 'Arusha to Central Serengeti',
            'description' => 'Morning drive from Arusha to Serengeti. Afternoon game drive in Seronera.',
        ]);

        $tour2 = Tour::create([
            'name' => 'Mount Kilimanjaro Trek',
            'slug' => 'mount-kilimanjaro-trek',
            'description' => 'Conquer the highest peak in Africa via the Machame route.',
            'location' => 'Mount Kilimanjaro',
            'duration_days' => 7,
            'base_price' => 1850.00,
            'featured' => true,
            'status' => 'active',
        ]);

        $tour3 = Tour::create([
            'name' => 'Ngorongoro Crater Tour',
            'slug' => 'ngorongoro-crater-tour',
            'description' => 'A short but intense tour of the Ngorongoro Conservation Area.',
            'location' => 'Ngorongoro Crater',
            'duration_days' => 3,
            'base_price' => 850.00,
            'featured' => true,
            'status' => 'active',
        ]);
    }
}
