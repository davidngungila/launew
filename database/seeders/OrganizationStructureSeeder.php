<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Organization;
use App\Models\Branch;
use App\Models\Department;
use App\Models\User;
use App\Models\Role;

class OrganizationStructureSeeder extends Seeder
{
    public function run(): void
    {
        // Get or create main organization
        $organization = Organization::firstOrCreate(
            ['code' => 'LPA'],
            [
                'name' => 'LAU Paradise Adventure',
                'email' => 'info@lauparadise.com',
                'phone' => '+255 123 456 789',
                'website' => 'https://lauparadise.com',
                'address' => 'Kilimanjaro International Airport Area',
                'city' => 'Arusha',
                'country' => 'Tanzania',
                'postal_code' => '00000',
                'status' => 'active',
                'type' => 'tour_operator',
                'license_number' => 'TO-2023-TZ-001',
                'license_expiry' => now()->addYears(2),
                'description' => 'Premium safari and adventure tour operator specializing in authentic African experiences',
                'social_media' => [
                    'facebook' => 'https://facebook.com/lauparadise',
                    'instagram' => 'https://instagram.com/lauparadise',
                    'twitter' => 'https://twitter.com/lauparadise',
                ],
                'timezone' => 'Africa/Dar_es_Salaam',
                'currency' => 'TZS',
                'tax_id' => 'TIN-123456789',
                'registration_number' => 'REG-2023-001',
                'annual_revenue' => 2500000.00,
                'employee_count' => 45,
                'founded_date' => '2020-01-15',
            ]
        );

        // Create branches
        $headquarters = Branch::firstOrCreate(
            ['organization_id' => $organization->id, 'code' => 'HQ'],
            [
                'name' => 'LAU Paradise Headquarters',
                'email' => 'hq@lauparadise.com',
                'phone' => '+255 123 456 780',
                'address' => 'Kilimanjaro International Airport Area',
                'city' => 'Arusha',
                'country' => 'Tanzania',
                'postal_code' => '00000',
                'latitude' => -3.4313,
                'longitude' => 36.9499,
                'status' => 'active',
                'type' => 'headquarters',
                'manager_name' => 'John Smith',
                'manager_email' => 'john.smith@lauparadise.com',
                'manager_phone' => '+255 123 456 001',
                'operating_hours' => [
                    'monday' => ['08:00', '18:00'],
                    'tuesday' => ['08:00', '18:00'],
                    'wednesday' => ['08:00', '18:00'],
                    'thursday' => ['08:00', '18:00'],
                    'friday' => ['08:00', '18:00'],
                    'saturday' => ['09:00', '15:00'],
                    'sunday' => ['closed'],
                ],
                'facilities' => ['office', 'parking', 'conference_room', 'kitchen', 'storage'],
                'employee_count' => 25,
                'established_date' => '2020-01-15',
                'is_main_branch' => true,
            ]
        );

        $darEsSalaamBranch = Branch::firstOrCreate(
            ['organization_id' => $organization->id, 'code' => 'DSM'],
            [
                'name' => 'Dar es Salaam Office',
                'email' => 'dsm@lauparadise.com',
                'phone' => '+255 22 123 456 789',
                'address' => 'Masaki Peninsula, Msasani Peninsula',
                'city' => 'Dar es Salaam',
                'country' => 'Tanzania',
                'postal_code' => '11000',
                'latitude' => -6.7924,
                'longitude' => 39.2083,
                'status' => 'active',
                'type' => 'regional',
                'manager_name' => 'Sarah Johnson',
                'manager_email' => 'sarah.j@lauparadise.com',
                'manager_phone' => '+255 22 123 456 002',
                'operating_hours' => [
                    'monday' => ['08:30', '17:30'],
                    'tuesday' => ['08:30', '17:30'],
                    'wednesday' => ['08:30', '17:30'],
                    'thursday' => ['08:30', '17:30'],
                    'friday' => ['08:30', '17:30'],
                    'saturday' => ['09:00', '13:00'],
                    'sunday' => ['closed'],
                ],
                'facilities' => ['office', 'parking', 'meeting_room'],
                'employee_count' => 12,
                'established_date' => '2021-06-01',
            ]
        );

        $zanzibarBranch = Branch::firstOrCreate(
            ['organization_id' => $organization->id, 'code' => 'ZNZ'],
            [
                'name' => 'Zanzibar Beach Office',
                'email' => 'zanzibar@lauparadise.com',
                'phone' => '+255 24 123 456 789',
                'address' => 'Stone Town, Ng\'ambo',
                'city' => 'Zanzibar',
                'country' => 'Tanzania',
                'postal_code' => '72000',
                'latitude' => -6.1659,
                'longitude' => 39.2026,
                'status' => 'active',
                'type' => 'local',
                'manager_name' => 'Michael Davis',
                'manager_email' => 'michael.d@lauparadise.com',
                'manager_phone' => '+255 24 123 456 003',
                'operating_hours' => [
                    'monday' => ['09:00', '17:00'],
                    'tuesday' => ['09:00', '17:00'],
                    'wednesday' => ['09:00', '17:00'],
                    'thursday' => ['09:00', '17:00'],
                    'friday' => ['09:00', '17:00'],
                    'saturday' => ['10:00', '14:00'],
                    'sunday' => ['closed'],
                ],
                'facilities' => ['office', 'beach_access', 'storage'],
                'employee_count' => 8,
                'established_date' => '2022-03-15',
            ]
        );

        // Get roles for assignment
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $adminRole = Role::where('name', 'System Administrator')->first();
        $managerRole = Role::where('name', 'Booking Manager')->first();
        $consultantRole = Role::where('name', 'Travel Consultant')->first();

        // Create departments for headquarters
        $executiveDept = Department::firstOrCreate(
            ['organization_id' => $organization->id, 'branch_id' => $headquarters->id, 'code' => 'EXEC'],
            [
                'name' => 'Executive Office',
                'description' => 'Executive management and strategic planning',
                'status' => 'active',
                'type' => 'executive',
                'email' => 'executive@lauparadise.com',
                'phone' => '+255 123 456 790',
                'manager_id' => 1, // Super Admin
                'employee_count' => 3,
                'budget' => 500000.00,
                'responsibilities' => ['Strategic Planning', 'Business Development', 'Stakeholder Relations'],
                'skills_required' => ['Leadership', 'Strategic Thinking', 'Financial Management'],
                'established_date' => '2020-01-15',
                'is_core_department' => true,
                'sort_order' => 1,
            ]
        );

        $operationsDept = Department::firstOrCreate(
            ['organization_id' => $organization->id, 'branch_id' => $headquarters->id, 'code' => 'TOUR'],
            [
                'name' => 'Tour Operations',
                'description' => 'Tour planning, coordination and execution',
                'status' => 'active',
                'type' => 'tour_operations',
                'email' => 'operations@lauparadise.com',
                'phone' => '+255 123 456 791',
                'manager_id' => 4, // John Smith
                'assistant_manager_id' => 5, // Sarah Johnson
                'employee_count' => 12,
                'budget' => 800000.00,
                'cost_centers' => ['Transport', 'Guides', 'Equipment', 'Logistics'],
                'responsibilities' => ['Tour Planning', 'Guide Management', 'Vehicle Coordination', 'Quality Control'],
                'skills_required' => ['Tour Planning', 'Logistics', 'Customer Service', 'Problem Solving'],
                'established_date' => '2020-01-15',
                'is_core_department' => true,
                'sort_order' => 2,
            ]
        );

        $financeDept = Department::firstOrCreate(
            ['organization_id' => $organization->id, 'branch_id' => $headquarters->id, 'code' => 'FIN'],
            [
                'name' => 'Finance & Accounting',
                'description' => 'Financial management, accounting and reporting',
                'status' => 'active',
                'type' => 'finance',
                'email' => 'finance@lauparadise.com',
                'phone' => '+255 123 456 792',
                'manager_id' => 2, // Admin
                'employee_count' => 5,
                'budget' => 300000.00,
                'responsibilities' => ['Financial Planning', 'Accounting', 'Budget Management', 'Compliance'],
                'skills_required' => ['Accounting', 'Financial Analysis', 'Excel', 'Tax Knowledge'],
                'established_date' => '2020-02-01',
                'is_core_department' => true,
                'sort_order' => 3,
            ]
        );

        $marketingDept = Department::firstOrCreate(
            ['organization_id' => $organization->id, 'branch_id' => $headquarters->id, 'code' => 'MKT'],
            [
                'name' => 'Marketing & Sales',
                'description' => 'Marketing campaigns, sales and customer acquisition',
                'status' => 'active',
                'type' => 'marketing',
                'email' => 'marketing@lauparadise.com',
                'phone' => '+255 123 456 793',
                'manager_id' => 6, // Michael Davis
                'employee_count' => 7,
                'budget' => 400000.00,
                'responsibilities' => ['Marketing Campaigns', 'Sales', 'Digital Marketing', 'Brand Management'],
                'skills_required' => ['Marketing', 'Sales', 'Digital Marketing', 'Content Creation'],
                'established_date' => '2020-03-01',
                'sort_order' => 4,
            ]
        );

        // Create departments for Dar es Salaam branch
        $dsmCustomerServiceDept = Department::firstOrCreate(
            ['organization_id' => $organization->id, 'branch_id' => $darEsSalaamBranch->id, 'code' => 'CS'],
            [
                'name' => 'Customer Service',
                'description' => 'Customer support and service management',
                'status' => 'active',
                'type' => 'customer_service',
                'email' => 'customerservice@lauparadise.com',
                'phone' => '+255 22 123 456 790',
                'manager_id' => 7, // Emma Wilson
                'employee_count' => 6,
                'budget' => 200000.00,
                'responsibilities' => ['Customer Support', 'Inquiry Management', 'Complaint Resolution'],
                'skills_required' => ['Customer Service', 'Communication', 'Problem Solving'],
                'established_date' => '2021-06-01',
                'sort_order' => 1,
            ]
        );

        // Create departments for Zanzibar branch
        $zanzibarGuidesDept = Department::firstOrCreate(
            ['organization_id' => $organization->id, 'branch_id' => $zanzibarBranch->id, 'code' => 'GUIDE'],
            [
                'name' => 'Tour Guides',
                'description' => 'Beach and cultural tour guides',
                'status' => 'active',
                'type' => 'guides',
                'email' => 'guides@lauparadise.com',
                'phone' => '+255 24 123 456 790',
                'manager_id' => 8, // Robert Anderson
                'employee_count' => 4,
                'budget' => 150000.00,
                'responsibilities' => ['Tour Guiding', 'Cultural Education', 'Safety Management'],
                'skills_required' => ['Tour Guiding', 'Languages', 'First Aid', 'Local Knowledge'],
                'established_date' => '2022-03-15',
                'sort_order' => 1,
            ]
        );

        // Update existing users with organization structure
        $this->updateUsersWithOrganization($organization, $headquarters, $darEsSalaamBranch, $zanzibarBranch);

        $this->command->info('Organization structure created successfully!');
        $this->command->info("Organization: {$organization->name}");
        $this->command->info("Branches: {$organization->branches()->count()}");
        $this->command->info("Departments: {$organization->departments()->count()}");
    }

    private function updateUsersWithOrganization($organization, $headquarters, $darEsSalaamBranch, $zanzibarBranch)
    {
        // Update Super Admin
        $superAdmin = User::find(1);
        if ($superAdmin) {
            $superAdmin->update([
                'organization_id' => $organization->id,
                'branch_id' => $headquarters->id,
                'department_id' => 1, // Executive Office
                'employee_id' => 'EMP001',
                'job_title' => 'Chief Executive Officer',
                'employment_type' => 'full_time',
                'hire_date' => '2020-01-15',
                'salary' => 120000.00,
                'work_phone' => '+255 123 456 001',
                'work_email' => 'ceo@lauparadise.com',
                'is_active_employee' => true,
                'can_approve_expenses' => true,
                'can_manage_team' => true,
                'vacation_days_per_year' => 25,
                'sick_days_per_year' => 15,
            ]);
        }

        // Update Admin
        $admin = User::find(2);
        if ($admin) {
            $admin->update([
                'organization_id' => $organization->id,
                'branch_id' => $headquarters->id,
                'department_id' => 3, // Finance
                'employee_id' => 'EMP002',
                'job_title' => 'Chief Financial Officer',
                'employment_type' => 'full_time',
                'hire_date' => '2020-02-01',
                'salary' => 95000.00,
                'work_phone' => '+255 123 456 002',
                'work_email' => 'cfo@lauparadise.com',
                'is_active_employee' => true,
                'can_approve_expenses' => true,
                'can_manage_team' => true,
                'vacation_days_per_year' => 25,
                'sick_days_per_year' => 15,
            ]);
        }

        // Update other staff users
        $staffUsers = [
            4 => ['branch_id' => $headquarters->id, 'department_id' => 2, 'employee_id' => 'EMP004', 'job_title' => 'Operations Manager'],
            5 => ['branch_id' => $headquarters->id, 'department_id' => 2, 'employee_id' => 'EMP005', 'job_title' => 'Senior Tour Coordinator'],
            6 => ['branch_id' => $headquarters->id, 'department_id' => 4, 'employee_id' => 'EMP006', 'job_title' => 'Marketing Manager'],
            7 => ['branch_id' => $darEsSalaamBranch->id, 'department_id' => 5, 'employee_id' => 'EMP007', 'job_title' => 'Customer Service Manager'],
            8 => ['branch_id' => $zanzibarBranch->id, 'department_id' => 6, 'employee_id' => 'EMP008', 'job_title' => 'Lead Tour Guide'],
        ];

        foreach ($staffUsers as $userId => $details) {
            $user = User::find($userId);
            if ($user) {
                $user->update([
                    'organization_id' => $organization->id,
                    'branch_id' => $details['branch_id'],
                    'department_id' => $details['department_id'],
                    'employee_id' => $details['employee_id'],
                    'job_title' => $details['job_title'],
                    'employment_type' => 'full_time',
                    'hire_date' => now()->subMonths(rand(6, 24)),
                    'salary' => rand(35000, 70000),
                    'is_active_employee' => true,
                    'can_manage_team' => true,
                    'vacation_days_per_year' => 20,
                    'sick_days_per_year' => 10,
                ]);
            }
        }

        // Update remaining users as customers or consultants
        $remainingUsers = User::whereNotIn('id', array_keys([1, 2, 4, 5, 6, 7, 8]))->get();
        foreach ($remainingUsers as $user) {
            $user->update([
                'organization_id' => $organization->id,
                'branch_id' => $headquarters->id,
                'department_id' => 2, // Tour Operations as default
                'employee_id' => 'EMP' . str_pad($user->id, 3, '0', STR_PAD_LEFT),
                'job_title' => 'Travel Consultant',
                'employment_type' => 'full_time',
                'hire_date' => now()->subMonths(rand(1, 18)),
                'is_active_employee' => true,
                'vacation_days_per_year' => 20,
                'sick_days_per_year' => 10,
            ]);
        }
    }
}
