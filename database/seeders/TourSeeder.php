<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use Illuminate\Support\Str;

class TourSeeder extends Seeder
{
    public function run(): void
    {
        Tour::truncate();
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
        ];

        foreach ($tours as $t) {
            $t['slug'] = Str::slug($t['name']);
            Tour::create($t);
        }
    }
}
