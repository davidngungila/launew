<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Role;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientDemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->updateOrCreate(
            ['email' => 'client@lauparadise.com'],
            [
                'name' => 'Sample Client',
                'password' => Hash::make('Client@12345'),
            ]
        );

        $customerRole = Role::query()->firstOrCreate(['name' => 'Customer']);
        $user->roles()->syncWithoutDetaching([$customerRole->id]);

        $tour = Tour::query()->orderBy('id')->first();
        if (!$tour) {
            return;
        }

        Booking::query()->firstOrCreate(
            [
                'user_id' => $user->id,
                'tour_id' => $tour->id,
                'start_date' => now()->addDays(30)->toDateString(),
            ],
            [
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => '+255700000000',
                'adults' => 2,
                'children' => 1,
                'special_requests' => 'Demo booking created by ClientDemoSeeder.',
                'total_price' => (float) ($tour->base_price * (2 + (1 * 0.5))),
                'status' => 'pending',
                'payment_status' => 'unpaid',
            ]
        );
    }
}
