<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\Itinerary;

class ItinerarySeeder extends Seeder
{
    public function run(): void
    {
        // 8 Days Great Migration
        $migration = Tour::where('name', 'like', '%Migration%')->first();
        if ($migration) {
            $migration->itineraries()->createMany([
                ['day_number' => 1, 'title' => 'Arrival & Briefing', 'description' => 'Airport pickup and transfer to Arusha for safari briefing.', 'accommodation' => 'Gran Melia Arusha', 'meals' => 'D'],
                ['day_number' => 2, 'title' => 'Arusha to Tarangire', 'description' => 'Drive to Tarangire National Park for game viewing. Famous for giant baobabs and elephant herds.', 'accommodation' => 'Angata Tarangire Camp', 'meals' => 'B, L, D'],
                ['day_number' => 3, 'title' => 'Tarangire to Central Serengeti', 'description' => 'Across the Ngorongoro highlands to the endless plains of Serengeti.', 'accommodation' => 'Serengeti Tented Lodge', 'meals' => 'B, L, D'],
                ['day_number' => 4, 'title' => 'Central to North Serengeti', 'description' => 'Following the migration paths towards the Mara River.', 'accommodation' => 'Mara River Camp', 'meals' => 'B, L, D'],
                ['day_number' => 5, 'title' => 'Mara River Crossing Search', 'description' => 'Full day tracking the wildebeest crossing at the Mara River.', 'accommodation' => 'Mara River Camp', 'meals' => 'B, L, D'],
                ['day_number' => 6, 'title' => 'North Serengeti to Ngorongoro', 'description' => 'Early morning game drive and drive towards the Ngorongoro Conservation Area.', 'accommodation' => 'Ngorongoro Neptune Lodge', 'meals' => 'B, L, D'],
                ['day_number' => 7, 'title' => 'Ngorongoro Crater Floor', 'description' => 'Descent into the crater floor for a 6-hour game drive. Spot the rare Black Rhino.', 'accommodation' => 'Karatu Lodge', 'meals' => 'B, L, D'],
                ['day_number' => 8, 'title' => 'Lake Manyara to Arusha', 'description' => 'Final game drive in Lake Manyara and drive back to Arusha for departure.', 'accommodation' => 'Departure', 'meals' => 'B, L'],
            ]);
        }

        // Lemosho Route
        $lemosho = Tour::where('name', 'like', '%Lemosho%')->first();
        if ($lemosho) {
            $lemosho->itineraries()->createMany([
                ['day_number' => 1, 'title' => 'Londorossi Gate to Mti Mkubwa', 'description' => 'Start the trek through the lush rainforest.', 'accommodation' => 'Mti Mkubwa Camp', 'meals' => 'L, D'],
                ['day_number' => 2, 'title' => 'Mti Mkubwa to Shira 1 Camp', 'description' => 'Steep climb out of the forest onto the Shira Plateau.', 'accommodation' => 'Shira 1 Camp', 'meals' => 'B, L, D'],
                ['day_number' => 3, 'title' => 'Shira 1 to Shira 2 Camp', 'description' => 'Gentle walk across the plateau for acclimatization.', 'accommodation' => 'Shira 2 Camp', 'meals' => 'B, L, D'],
                ['day_number' => 4, 'title' => 'Shira 2 to Barranco Camp', 'description' => 'Trek past the Lava Tower (4600m). Climb high, sleep low.', 'accommodation' => 'Barranco Camp', 'meals' => 'B, L, D'],
                ['day_number' => 5, 'title' => 'Barranco to Karanga Camp', 'description' => 'Conquer the famous Barranco Wall.', 'accommodation' => 'Karanga Camp', 'meals' => 'B, L, D'],
                ['day_number' => 6, 'title' => 'Karanga to Barafu Camp', 'description' => 'Final ascent to base camp before the summit attempt.', 'accommodation' => 'Barafu Camp', 'meals' => 'B, L, D'],
                ['day_number' => 7, 'title' => 'Summit Day: Uhuru Peak', 'description' => 'Midnight start to reach the summit at sunrise. Descent to Mweka Gate.', 'accommodation' => 'Arusha Hotel', 'meals' => 'B, L'],
            ]);
        }
    }
}
