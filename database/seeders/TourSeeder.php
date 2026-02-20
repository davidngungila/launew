<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use Illuminate\Support\Str;

class TourSeeder extends Seeder
{
    public function run(): void
    {
        $tours = [
            [
                'name' => 'Serengeti Classic Safari & Great Migration',
                'description' => 'Experience the raw beauty of the African savannah on this 5-day Serengeti Classic Safari. Witness the Great Migration, where millions of wildebeest and zebras traverse the plains.',
                'location' => 'Serengeti National Park, Tanzania',
                'duration_days' => 5,
                'base_price' => 1250.00,
                'featured' => true,
                'status' => 'active',
                'images' => json_encode(['https://images.unsplash.com/photo-1516426122078-c23e76319801', 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e']),
                'inclusions' => json_encode(['All park entrance fees', 'Expert guide', 'Custom 4x4 Land Cruiser', 'Bottled water & snacks']),
                'exclusions' => json_encode(['International airfare', 'Personal insurance', 'Gratuities', 'Laundry services']),
            ],
            [
                'name' => 'Mount Kilimanjaro Trek - Machame Route',
                'description' => 'Conquer the Roof of Africa via the beautiful Machame route. This 7-day trek offers stunning views and high success rates for reaching Uhuru Peak.',
                'location' => 'Mount Kilimanjaro, Tanzania',
                'duration_days' => 7,
                'base_price' => 1850.00,
                'featured' => true,
                'status' => 'active',
                'images' => json_encode(['https://images.unsplash.com/photo-1589182373726-e4f658ab50f0', 'https://images.unsplash.com/photo-1549366021-9f761d450615']),
                'inclusions' => json_encode(['National Park fees', 'Mountain crew (guides, porters, cooks)', 'All meals on mountain', 'Camping equipment']),
                'exclusions' => json_encode(['Hiking gear', 'Sleeping bags', 'Tips for crew', 'Emergency evacuation insurance']),
            ],
            [
                'name' => 'Ngorongoro Crater & Tarangire Wildlife Tour',
                'description' => 'Discover the "Garden of Eden" and the land of giants (elephants and baobabs) in this 3-day adventure through Tanzania\'s northern circuit.',
                'location' => 'Ngorongoro & Tarangire, Tanzania',
                'duration_days' => 3,
                'base_price' => 850.00,
                'featured' => true,
                'status' => 'active',
                'images' => json_encode(['https://images.unsplash.com/photo-1534177714502-0ee856cc4605', 'https://images.unsplash.com/photo-1523805081730-614449379e70']),
                'inclusions' => json_encode(['Crater service fees', 'Professional driver-guide', 'Private 4x4 vehicle', 'Luxury lodge accommodation']),
                'exclusions' => json_encode(['Drinks at lodges', 'Travel insurance', 'Laundry', 'Tips']),
            ],
            [
                'name' => 'Zanzibar Beach Escape & Stone Town Tour',
                'description' => 'Relax on the turquoise shores of Nungwi and explore the historic winding alleys of Stone Town on this 4-day tropical paradise getaway.',
                'location' => 'Zanzibar, Tanzania',
                'duration_days' => 4,
                'base_price' => 650.00,
                'featured' => false,
                'status' => 'active',
                'images' => json_encode(['https://images.unsplash.com/photo-1537996194471-e657df975ab4', 'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe']),
                'inclusions' => json_encode(['Airport transfers', 'Stone Town walking tour', 'Beach resort stay', 'Acommodation with breakfast']),
                'exclusions' => json_encode(['Flights to Zanzibar', 'Lunches & dinners', 'Water sports', 'Personal expenses']),
            ],
            [
                'name' => 'Lake Manyara & Cultural Heritage Walk',
                'description' => 'See the famous tree-climbing lions and experience authentic Maasai culture in Mto wa Mbu on this enriching 2-day safari.',
                'location' => 'Lake Manyara, Tanzania',
                'duration_days' => 2,
                'base_price' => 450.00,
                'featured' => false,
                'status' => 'active',
                'images' => json_encode(['https://images.unsplash.com/photo-1547471080-7cc2caa01a7e', 'https://images.unsplash.com/photo-1518113177395-8de8b7f8398e']),
                'inclusions' => json_encode(['Park entry fees', 'Maasai village visit', 'Cultural walking tour', 'Professional guide']),
                'exclusions' => json_encode(['Accommodation beyond 1 night', 'Tips', 'Alcoholic drinks', 'Personal insurance']),
            ],
        ];

        foreach ($tours as $t) {
            $t['slug'] = Str::slug($t['name']);
            Tour::create($t);
        }
    }
}
