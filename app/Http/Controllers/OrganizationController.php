<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Branch;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrganizationController extends Controller
{
    public function index(): View
    {
        $organizations = Organization::with(['branches', 'departments'])->get();
        $totalBranches = Branch::count();
        $totalDepartments = Department::count();
        $totalEmployees = User::whereNotNull('organization_id')->count();

        return view('admin.organizations.index', compact(
            'organizations',
            'totalBranches',
            'totalDepartments',
            'totalEmployees'
        ));
    }

    public function create(): View
    {
        return view('admin.organizations.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:organizations,code',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive,suspended',
            'type' => 'required|in:tour_operator,travel_agency,hospitality,corporate,government,ngo',
            'license_number' => 'nullable|string|max:255',
            'license_expiry' => 'nullable|date',
            'description' => 'nullable|string',
            'timezone' => 'required|string|max:255',
            'currency' => 'required|string|size:3',
            'tax_id' => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'annual_revenue' => 'nullable|numeric|min:0',
            'employee_count' => 'required|integer|min:0',
            'founded_date' => 'nullable|date',
        ]);

        Organization::create($validated);

        return redirect()
            ->route('admin.organizations.index')
            ->with('success', 'Organization created successfully.');
    }

    public function show(Organization $organization): View
    {
        $organization->load(['branches', 'departments', 'users']);
        
        $branches = $organization->branches()->with('departments')->get();
        $departments = $organization->departments()->with(['manager', 'assistantManager', 'users'])->get();
        $employees = $organization->users()->with(['branch', 'department', 'roles'])->get();

        return view('admin.organizations.show', compact(
            'organization',
            'branches',
            'departments',
            'employees'
        ));
    }

    public function edit(Organization $organization): View
    {
        return view('admin.organizations.edit', compact('organization'));
    }

    public function update(Request $request, Organization $organization): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:organizations,code,' . $organization->id,
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive,suspended',
            'type' => 'required|in:tour_operator,travel_agency,hospitality,corporate,government,ngo',
            'license_number' => 'nullable|string|max:255',
            'license_expiry' => 'nullable|date',
            'description' => 'nullable|string',
            'timezone' => 'required|string|max:255',
            'currency' => 'required|string|size:3',
            'tax_id' => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'annual_revenue' => 'nullable|numeric|min:0',
            'employee_count' => 'required|integer|min:0',
            'founded_date' => 'nullable|date',
        ]);

        $organization->update($validated);

        return redirect()
            ->route('admin.organizations.index')
            ->with('success', 'Organization updated successfully.');
    }

    public function destroy(Organization $organization): RedirectResponse
    {
        $organization->delete();

        return redirect()
            ->route('admin.organizations.index')
            ->with('success', 'Organization deleted successfully.');
    }

    public function dashboard(Organization $organization): View
    {
        $organization->load(['branches', 'departments', 'users']);
        
        $stats = [
            'total_branches' => $organization->branches()->count(),
            'active_branches' => $organization->branches()->where('status', 'active')->count(),
            'total_departments' => $organization->departments()->count(),
            'active_departments' => $organization->departments()->where('status', 'active')->count(),
            'total_employees' => $organization->users()->count(),
            'active_employees' => $organization->users()->where('is_active_employee', true)->count(),
            'total_revenue' => $organization->total_revenue,
            'operating_countries' => $organization->operating_countries,
            'license_status' => $organization->license_status,
            'years_in_operation' => $organization->founded_date ? $organization->founded_date->diffInYears(now()) : null,
        ];

        return view('admin.organizations.dashboard', compact('organization', 'stats'));
    }
}
