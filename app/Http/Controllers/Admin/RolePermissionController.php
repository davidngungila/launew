<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function index()
    {
        $enterpriseRoles = [
            'System Administrator',
            'Admin / General Manager',
            'Booking Manager',
            'Travel Consultant',
            'Tour Operator',
            'Finance Officer',
            'Accountant',
            'Marketing Officer',
            'Sales Officer',
            'Operations Manager',
            'Driver / Guide',
            'External Agent',
            'Branch Manager',
            'IT Support',
            'Customer',
        ];

        foreach ($enterpriseRoles as $r) {
            Role::query()->firstOrCreate(['name' => $r]);
        }

        $enterprisePermissions = [
            'settings.manage',
            'users.manage',
            'roles.manage',
            'activity_logs.view',
            'system_health.view',
            'bookings.manage',
            'payments.view',
            'finance.reports.view',
            'tours.manage',
            'organization.manage',
            'branches.manage',
            'departments.manage',
            'integrations.manage',
            'audit_logs.view',
            'error_logs.view',
            'reports.view',
            'crm.manage',
            'leads.manage',
            'campaigns.manage',
            'promotions.manage',
            'quotations.manage',
            'operations.manage',
            'fleet.manage',
            'suppliers.manage',
            'expenses.manage',
            'invoices.manage',
            'banking.manage',
            'commissions.manage',
            'tax.manage',
        ];

        foreach ($enterprisePermissions as $p) {
            Permission::query()->firstOrCreate(['name' => $p]);
        }

        $roles = Role::query()->with('permissions')->orderBy('name')->get();
        $permissions = Permission::query()->orderBy('name')->get();

        return view('admin.settings.roles.index', compact('roles', 'permissions'));
    }

    public function storeRole(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        Role::create(['name' => $validated['name']]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'role.created',
            'subject_type' => Role::class,
            'properties' => ['name' => $validated['name']],
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1024),
        ]);

        return back()->with('success', 'Role created');
    }

    public function updateRole(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permission_ids' => 'array',
            'permission_ids.*' => 'integer|exists:permissions,id',
        ]);

        $role->update(['name' => $validated['name']]);
        $role->permissions()->sync($validated['permission_ids'] ?? []);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'role.updated',
            'subject_type' => Role::class,
            'subject_id' => $role->id,
            'properties' => [
                'name' => $validated['name'],
                'permission_ids' => $validated['permission_ids'] ?? [],
            ],
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1024),
        ]);

        return back()->with('success', 'Role updated');
    }
}
