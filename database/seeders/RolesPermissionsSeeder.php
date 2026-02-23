<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolesPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'System Administrator',
            'Booking Manager',
            'Travel Consultant',
            'Tour Operator',
            'Finance Officer',
            'Customer',
        ];

        foreach ($roles as $r) {
            Role::query()->firstOrCreate(['name' => $r]);
        }

        $permissions = [
            'settings.manage',
            'users.manage',
            'roles.manage',
            'activity_logs.view',
            'system_health.view',
            'bookings.manage',
            'payments.view',
            'finance.reports.view',
            'tours.manage',
        ];

        foreach ($permissions as $p) {
            Permission::query()->firstOrCreate(['name' => $p]);
        }

        $adminRole = Role::query()->where('name', 'System Administrator')->first();
        if ($adminRole) {
            $adminRole->permissions()->sync(Permission::query()->pluck('id')->all());
        }

        $financeRole = Role::query()->where('name', 'Finance Officer')->first();
        if ($financeRole) {
            $financePerms = Permission::query()->whereIn('name', [
                'payments.view',
                'finance.reports.view',
                'activity_logs.view',
                'system_health.view',
            ])->pluck('id')->all();
            $financeRole->permissions()->sync($financePerms);
        }

        $operatorRole = Role::query()->where('name', 'Tour Operator')->first();
        if ($operatorRole) {
            $operatorPerms = Permission::query()->whereIn('name', [
                'tours.manage',
                'bookings.manage',
            ])->pluck('id')->all();
            $operatorRole->permissions()->sync($operatorPerms);
        }

        $adminUser = User::query()->where('email', 'admin@lauparadise.com')->first();
        if ($adminUser && $adminRole) {
            $adminUser->roles()->syncWithoutDetaching([$adminRole->id]);
        }
    }
}
