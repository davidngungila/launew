<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class TourSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Tour::truncate();
        Schema::enableForeignKeyConstraints();
        
        $tours = [
            [
                'name' => '8 Days Great Wildebeest Migration Safari',
                'description' => 'Witness the world\'s most spectacular natural event. This 8-day expedition takes you deep into the heart of the Serengeti during the Great Migration. Witness river crossings and the raw power of nature.',
                'location' => 'Serengeti & Mara River, Tanzania',
                'duration_days' => 8,
                'base_price' => 2450.00,
                'featured' => true,
                'status' => 'active',
                'images' => json_encode([
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766042771/8-Days-Tanzania-holiday-Wildebeest-migration-1536x1018_gyndkw.jpg',
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046204/Mara-River-3-1536x1024_qflu8o.webp',
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046143/9-Days-Safari-vacation-Tanzania-Wildebeest-migration-1536x962_m0drtg.webp'
                ]),
                'inclusions' => json_encode(['Luxury Tented Camps', 'Private 4x4 Safari Vehicle', 'Unlimited Game Drives', 'All Park & Crater Fees', 'Airport Transfers']),
                'exclusions' => json_encode(['International Flights', 'Tanzania Entry Visa', 'Tips for Guides', 'Travel Insurance']),
            ],
            [
                'name' => '7 Days Mount Kilimanjaro - Lemosho Route',
                'description' => 'The Lemosho route is widely considered to be the most scenic path up Mount Kilimanjaro. It offers panoramic views on various sides of the mountain and carries a high success rate due to its excellent acclimatization profile.',
                'location' => 'Mount Kilimanjaro, Tanzania',
                'duration_days' => 7,
                'base_price' => 1950.00,
                'featured' => true,
                'status' => 'active',
                'images' => json_encode([
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766324377/7-Days-Mount-Kilimanjaro-Climb-Lemosho-Route-2.webp.bv.webp',
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046350/kilimanjaro-climbing_bvcs7p.jpg',
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766324492/lemosho-route-packages-2-1-600x275.jpg.bv_vbxuaq.webp'
                ]),
                'inclusions' => json_encode(['All Mountain Fees', 'Certified Lead Guides', 'Nutritious Mountain Meals', 'Tents & Sleeping Mats', 'Oxygen Cylinders for Safety']),
                'exclusions' => json_encode(['Mountain Trekking Gear', 'Sleeping Bags', 'Tips for Porters & Guides', 'Extra Hotel Nights']),
            ],
            [
                'name' => '7 Days Classic Tanzania Big Five Safari',
                'description' => 'A comprehensive journey through Tanzania\'s most famous parks: Tarangire, Ngorongoro, and the legendary Serengeti. Encounter the Big Five and experience diverse landscapes from baobab forests to crater floors.',
                'location' => 'Northern Circuit, Tanzania',
                'duration_days' => 7,
                'base_price' => 1750.00,
                'featured' => true,
                'status' => 'active',
                'images' => json_encode([
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766042771/7-DAYS-SAFARI-TANZANIA--1536x1024_d9kzfh.webp',
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046154/Angata-Tarangire-2-1-1536x863_amthnm.jpg',
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046228/tower-giraffes-gathered-around-bushes-open-woodlan_fsgqe3.jpg'
                ]),
                'inclusions' => json_encode(['Mid-Range Lodges & Camps', 'Customized 4x4 Land Cruiser', 'Expert Naturalist Guide', 'All Meals & Drinking Water', 'Entry Fees']),
                'exclusions' => json_encode(['Alcoholic Beverages', 'Laundry Services', 'International Airfare', 'Gratuities']),
            ],
            [
                'name' => 'Hadzabe Tribe Cultural Expedition',
                'description' => 'Go back in time and walk with the Hadzabe, one of the last true hunter-gatherer tribes in the world. Learn their ancient survival skills, bow hunting, and unique click language in the Lake Eyasi region.',
                'location' => 'Lake Eyasi, Tanzania',
                'duration_days' => 2,
                'base_price' => 550.00,
                'featured' => false,
                'status' => 'active',
                'images' => json_encode([
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046195/hadzabe_qgukhh.jpg',
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766324498/man-with-dreads-representing-rastafari-movement_jmcqny.jpg'
                ]),
                'inclusions' => json_encode(['Local Guide & Translator', 'Tribal Interaction Fees', 'Camping / Guesthouse', 'All Cultural Activities']),
                'exclusions' => json_encode(['Personal Gifts for Tribe', 'Sleeping Bag Rental', 'Alcohol', 'Tips']),
            ],
            [
                'name' => 'Royal Bengal Tiger Adventure (Global)',
                'description' => 'Step outside Tanzania for a specialized journey into the tiger reserves of India. Track the majestic Bengal Tiger and explore the dense bamboo forests of Rajasthan and Sundarbans.',
                'location' => 'Rajasthan & Sundarbans, India',
                'duration_days' => 6,
                'base_price' => 2200.00,
                'featured' => false,
                'status' => 'active',
                'images' => json_encode([
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766262364/amazing-bengal-tigers-nature.jpg',
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046222/tiger-nature-habitat-tiger-male-walking-head-composition-wildlife-scene-with-danger-animal-hot-summer-rajasthan-india-dry-trees-with-beautiful-indian-tiger-panthera-tigris_wy5cas.jpg',
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766262369/beautiful-axis-deer-from-sundarbans-tiger-reserve-india.jpg'
                ]),
                'inclusions' => json_encode(['Jeep Safari Permits', 'Wildlife Biologist Guide', 'Eco-Lodge Accommodation', 'Local Surface Transfers']),
                'exclusions' => json_encode(['India Visa Fees', 'International Flights', 'Personal Laundry', 'Tips']),
            ],
            [
                'name' => '7 Days Mount Kilimanjaro - Umbwe Route',
                'description' => 'Known as the shortest and steepest route up the mountain, the Umbwe route is for experienced hikers looking for a challenging ascent with spectacular scenery.',
                'location' => 'Mount Kilimanjaro, Tanzania',
                'duration_days' => 7,
                'base_price' => 1800.00,
                'featured' => false,
                'status' => 'active',
                'images' => json_encode([
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766324379/7-days-umbwe-route-600x300.webp.bv.webp',
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766324498/long-range-shot-elephants-walking-grassy-field-near-trees_inlucz.jpg'
                ]),
                'inclusions' => json_encode(['Climbing Permits', 'Porter Support', 'Full Board on Mountain', 'Group Safety Gear']),
                'exclusions' => json_encode(['Travel Insurance', 'Gear Rental', 'Tips', 'Personal Expenses']),
            ],
            [
                'name' => 'Zanzibar Shores & Tropical Paradise',
                'description' => 'Unwind on the pristine white sands of Zanzibar. This 5-day escape offers the perfect blend of relaxation and spice island exploration.',
                'location' => 'Zanzibar, Tanzania',
                'duration_days' => 5,
                'base_price' => 950.00,
                'featured' => true,
                'status' => 'active',
                'images' => json_encode([
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046173/beautiful-tropical-beach-sea-ocean-with-coconut-palm-tree-umbrella-chair-blue-sky_ezrdjs.jpg',
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046169/closeup-shot-beautiful-bird-sitting-pick-up_enaih2.jpg'
                ]),
                'inclusions' => json_encode(['Luxury Beach Resort', 'Spice Farm Tour', 'Airport Transfers', 'Sunset Dhow Cruise']),
                'exclusions' => json_encode(['Flights to Zanzibar', 'Personal Expenses', 'Tips']),
            ],
            [
                'name' => 'Gombe Stream Chimp Expedition',
                'description' => 'Trek through the lush forests of Gombe, following the footsteps of Jane Goodall. Encounter chimpanzees in their natural habitat and witness incredible biodiversity.',
                'location' => 'Gombe Stream, Tanzania',
                'duration_days' => 4,
                'base_price' => 1550.00,
                'featured' => false,
                'status' => 'active',
                'images' => json_encode([
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766262424/biologist-forest.jpg',
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766324498/beautiful-waterfall-streaming-into-river-surrounded-by-greens_dgyhld.jpg'
                ]),
                'inclusions' => json_encode(['Park Permits', 'Chimp Tracking Guide', 'Boat Transfers', 'Full Board Accommodation']),
                'exclusions' => json_encode(['Alcoholic Drinks', 'Tips', 'Flights to Kigoma']),
            ],
            [
                'name' => 'Sunset Elephant & Zebra Safari',
                'description' => 'A magical 3-day journey through the golden plains of Serengeti, focusing on the majestic elephants and zebra herds under the African sunset.',
                'location' => 'Serengeti, Tanzania',
                'duration_days' => 3,
                'base_price' => 880.00,
                'featured' => false,
                'status' => 'active',
                'images' => json_encode([
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766324502/closeup-shot-elephants-standing-near-lake-sunset_set5ic.jpg',
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766262419/beautiful-zebra-wild.jpg'
                ]),
                'inclusions' => json_encode(['Game Drives', 'Expert Safari Guide', 'Camping Equipment', 'All Meals']),
                'exclusions' => json_encode(['Tips', 'Personal Gear', 'Soda/Alcohol']),
            ],
            [
                'name' => 'Birdwatching & Condor Sanctuary',
                'description' => 'A specialized tour for bird enthusiasts, exploring the rich avian life of the Rift Valley, including rare condors and tropical species.',
                'location' => 'Rift Valley, Tanzania',
                'duration_days' => 4,
                'base_price' => 750.00,
                'featured' => false,
                'status' => 'active',
                'images' => json_encode([
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046169/closeup-shot-beautiful-bird-sitting-pick-up_enaih2.jpg',
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046171/closeup-shot-condors-gathered-heap_p0iu2e.jpg'
                ]),
                'inclusions' => json_encode(['Ornithology Guide', 'High-end Binoculars', 'Nature Walks', 'Comfortable Lodging']),
                'exclusions' => json_encode(['Hard Drinks', 'Personal Items']),
            ],
            [
                'name' => 'Selous Wild Waterway Adventure',
                'description' => 'Navigate the rivers of Selous, the largest game reserve in Africa. Witness hippos, crocodiles, and elephants from a unique boat perspective.',
                'location' => 'Selous, Tanzania',
                'duration_days' => 5,
                'base_price' => 1200.00,
                'featured' => false,
                'status' => 'active',
                'images' => json_encode([
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766324498/beautiful-waterfall-streaming-into-river-surrounded-by-greens_dgyhld.jpg',
                    'https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766324502/closeup-shot-elephants-standing-near-lake-sunset_set5ic.jpg'
                ]),
                'inclusions' => json_encode(['Boat Safaris', 'Walking Safari', 'Luxury Fly Camping', 'Gourmet Meals']),
                'exclusions' => json_encode(['Airfare', 'Tips', 'Laundry']),
            ],
            [
                'name' => 'Arusha National Park Day Trip',
                'description' => 'A perfect introduction to African wildlife. See colobus monkeys, giraffes, and the Momella Lakes.',
                'location' => 'Arusha, Tanzania',
                'duration_days' => 1,
                'base_price' => 250.00,
                'featured' => false,
                'status' => 'active',
                'images' => json_encode(['https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046169/closeup-shot-beautiful-bird-sitting-pick-up_enaih2.jpg']),
                'inclusions' => json_encode(['Park Fees', 'Lunch Box', 'Transport']),
                'exclusions' => json_encode(['Tips', 'Drinks']),
            ],
            [
                'name' => 'Ruaha Wilderness Expedition',
                'description' => 'Experience the rawest form of nature in Ruaha National Park, known for its huge elephant and lion populations.',
                'location' => 'Ruaha, Tanzania',
                'duration_days' => 6,
                'base_price' => 1850.00,
                'featured' => false,
                'status' => 'active',
                'images' => json_encode(['https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766324502/closeup-shot-elephants-standing-near-lake-sunset_set5ic.jpg']),
                'inclusions' => json_encode(['Flights to Park', 'Luxury Camping', 'All Game Drives']),
                'exclusions' => json_encode(['Tips', 'Personal Travel Insurance']),
            ],
            [
                'name' => 'Katavi Secret Safari',
                'description' => 'The ultimate remote safari. Katavi is for the true connoisseur looking for isolated wilderness.',
                'location' => 'Katavi, Tanzania',
                'duration_days' => 7,
                'base_price' => 2800.00,
                'featured' => false,
                'status' => 'active',
                'images' => json_encode(['https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766262419/beautiful-zebra-wild.jpg']),
                'inclusions' => json_encode(['Private Pilot', 'Unlimited Mileage', 'Champagne Dinners']),
                'exclusions' => json_encode(['None']),
            ],
            [
                'name' => 'Mahale Mountains Primates',
                'description' => 'Meet the chimpanzees of Mahale Mountains where the forest meets the crystal clear waters of Lake Tanganyika.',
                'location' => 'Mahale, Tanzania',
                'duration_days' => 5,
                'base_price' => 3100.00,
                'featured' => false,
                'status' => 'active',
                'images' => json_encode(['https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766262424/biologist-forest.jpg']),
                'inclusions' => json_encode(['Chiz Safari', 'Boat Transfers', 'Forest Permits']),
                'exclusions' => json_encode(['Flights', 'Tips']),
            ],
            [
                'name' => 'Lake Natron & Flamingos',
                'description' => 'A starkly beautiful landscape home to millions of flamingos and the holy volcano Oldoinyo Lengai.',
                'location' => 'Lake Natron, Tanzania',
                'duration_days' => 3,
                'base_price' => 680.00,
                'featured' => false,
                'status' => 'active',
                'images' => json_encode(['https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046171/closeup-shot-condors-gathered-heap_p0iu2e.jpg']),
                'inclusions' => json_encode(['Maasai Guide', 'Camping', 'Nature Walks']),
                'exclusions' => json_encode(['Tips', 'Gear']),
            ],
            [
                'name' => 'Bagamoyo Cultural Heritage',
                'description' => 'Explore the historical town of Bagamoyo, once a critical port and now a center for arts and history.',
                'location' => 'Bagamoyo, Tanzania',
                'duration_days' => 2,
                'base_price' => 420.00,
                'featured' => false,
                'status' => 'active',
                'images' => json_encode(['https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046169/cd3gf8qbgq0srceecj6lodl55oelb7b5_umwwuo.webp']),
                'inclusions' => json_encode(['Museum Fees', 'Local Lunch', 'Transport']),
                'exclusions' => json_encode(['Hotel Stay', 'Tips']),
            ],
            [
                'name' => 'Mafia Island Whale Shark Diving',
                'description' => 'Swim with the gentle giants of the ocean. Mafia Island offers some of the best diving in East Africa.',
                'location' => 'Mafia Island, Tanzania',
                'duration_days' => 4,
                'base_price' => 1100.00,
                'featured' => false,
                'status' => 'active',
                'images' => json_encode(['https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046173/beautiful-tropical-beach-sea-ocean-with-coconut-palm-tree-umbrella-chair-blue-sky_ezrdjs.jpg']),
                'inclusions' => json_encode(['Diving Gear', 'Marine Park Fees', 'Resort Stay']),
                'exclusions' => json_encode(['Flight to Mafia', 'Tips']),
            ],
            [
                'name' => 'Saadani: Where the Bush Meets the Beach',
                'description' => 'The only park in East Africa where you can see elephants on the beach.',
                'location' => 'Saadani, Tanzania',
                'duration_days' => 3,
                'base_price' => 790.00,
                'featured' => false,
                'status' => 'active',
                'images' => json_encode(['https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766324502/closeup-shot-elephants-standing-near-lake-sunset_set5ic.jpg']),
                'inclusions' => json_encode(['Game Drive', 'Beach Bonfire', 'Tented Camp']),
                'exclusions' => json_encode(['Alcohol', 'Tips']),
            ],
            [
                'name' => 'Mkomazi Rhino Sanctuary',
                'description' => 'Dedicated to the conservation of the Black Rhino and African Wild Dog.',
                'location' => 'Mkomazi, Tanzania',
                'duration_days' => 2,
                'base_price' => 580.00,
                'featured' => false,
                'status' => 'active',
                'images' => json_encode(['https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766262419/beautiful-zebra-wild.jpg']),
                'inclusions' => json_encode(['Sanctuary Tour', 'Ranger Guide', 'Meals']),
                'exclusions' => json_encode(['Camping Gear', 'Tips']),
            ],
            [
                'name' => 'Ngorongoro Highland Trek',
                'description' => 'Walk through the lush highlands of the crater rim with armed rangers and Maasai guides.',
                'location' => 'Ngorongoro, Tanzania',
                'duration_days' => 3,
                'base_price' => 850.00,
                'featured' => false,
                'status' => 'active',
                'images' => json_encode(['https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766324498/beautiful-waterfall-streaming-into-river-surrounded-by-greens_dgyhld.jpg']),
                'inclusions' => json_encode(['Ranger Fees', 'Maasai Escort', 'Camping']),
                'exclusions' => json_encode(['Tips', 'Gear']),
            ],
        ];

        foreach ($tours as $t) {
            $t['slug'] = Str::slug($t['name']);
            Tour::create($t);
        }
    }
}
