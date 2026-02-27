<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultStaffUsersSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'name' => 'Laurine Godfrey Muhimbano',
                'email' => 'laurinemuhimbano@gmail.com',
                'role' => 'Accountant',
            ],
            [
                'name' => 'Laurance kilondera mahaza',
                'email' => 'Laurancekilondera6@gmail.com',
                'role' => 'Admin / General Manager',
            ],
            [
                'name' => 'Dionis baltazari sungi',
                'email' => 'baltazaridionis@gmail.com',
                'role' => 'Marketing Officer',
            ],
        ];

        foreach ($rows as $r) {
            $user = User::query()->updateOrCreate(
                ['email' => $r['email']],
                [
                    'name' => $r['name'],
                    'password' => Hash::make('lau123'),
                    'email_verified_at' => now(),
                ]
            );

            $role = Role::query()->where('name', $r['role'])->first();
            if ($role) {
                $user->roles()->syncWithoutDetaching([$role->id]);
            }
        }
    }
}
