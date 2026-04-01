<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SampleUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Create various sample users for testing
        $sampleUsers = [
            // Admin users
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@lauparadise.com',
                'password' => 'Admin@12345',
                'role' => 'Super Admin',
            ],
            [
                'name' => 'System Administrator',
                'email' => 'sysadmin@lauparadise.com',
                'password' => 'Admin@12345',
                'role' => 'Admin',
            ],
            
            // Staff users
            [
                'name' => 'John Smith',
                'email' => 'john.smith@lauparadise.com',
                'password' => 'Staff@12345',
                'role' => 'Tour Guide',
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.j@lauparadise.com',
                'password' => 'Staff@12345',
                'role' => 'Sales Agent',
            ],
            [
                'name' => 'Michael Davis',
                'email' => 'michael.d@lauparadise.com',
                'password' => 'Staff@12345',
                'role' => 'Customer Service',
            ],
            [
                'name' => 'Emma Wilson',
                'email' => 'emma.w@lauparadise.com',
                'password' => 'Staff@12345',
                'role' => 'Marketing Officer',
            ],
            
            // Customer users
            [
                'name' => 'Robert Anderson',
                'email' => 'robert.anderson@email.com',
                'password' => 'Customer@12345',
                'role' => 'Customer',
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria.garcia@email.com',
                'password' => 'Customer@12345',
                'role' => 'Customer',
            ],
            [
                'name' => 'James Taylor',
                'email' => 'james.taylor@email.com',
                'password' => 'Customer@12345',
                'role' => 'Customer',
            ],
            [
                'name' => 'Lisa Chen',
                'email' => 'lisa.chen@email.com',
                'password' => 'Customer@12345',
                'role' => 'Customer',
            ],
            [
                'name' => 'David Brown',
                'email' => 'david.brown@email.com',
                'password' => 'Customer@12345',
                'role' => 'Customer',
            ],
            [
                'name' => 'Sophie Martin',
                'email' => 'sophie.martin@email.com',
                'password' => 'Customer@12345',
                'role' => 'Customer',
            ],
            [
                'name' => 'Ahmed Hassan',
                'email' => 'ahmed.hassan@email.com',
                'password' => 'Customer@12345',
                'role' => 'Customer',
            ],
            [
                'name' => 'Nina Petrov',
                'email' => 'nina.petrov@email.com',
                'password' => 'Customer@12345',
                'role' => 'Customer',
            ],
        ];

        foreach ($sampleUsers as $userData) {
            // Create or update user
            $user = User::query()->updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                    'email_verified_at' => now(),
                ]
            );

            // Assign role
            $role = Role::query()->where('name', $userData['role'])->first();
            if ($role) {
                $user->roles()->syncWithoutDetaching([$role->id]);
            } else {
                // Create role if it doesn't exist
                $newRole = Role::query()->firstOrCreate(['name' => $userData['role']]);
                $user->roles()->syncWithoutDetaching([$newRole->id]);
            }

            $this->command->info("Created/Updated user: {$userData['name']} ({$userData['email']}) with role: {$userData['role']}");
        }

        // Output login credentials summary
        $this->command->info("\n=== SAMPLE USER CREDENTIALS ===");
        $this->command->info("Super Admin: superadmin@lauparadise.com / Admin@12345");
        $this->command->info("Admin: sysadmin@lauparadise.com / Admin@12345");
        $this->command->info("Staff: john.smith@lauparadise.com / Staff@12345");
        $this->command->info("Customer: robert.anderson@email.com / Customer@12345");
        $this->command->info("================================\n");
    }
}
