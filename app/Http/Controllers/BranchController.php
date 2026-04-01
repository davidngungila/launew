<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Organization;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BranchController extends Controller
{
    public function index(): View
    {
        $branches = Branch::with(['organization', 'departments'])->get();
        $countries = $branches->pluck('country')->unique()->filter()->sort()->values();
        $totalEmployees = User::whereNotNull('branch_id')->count();

        return view('admin.branches.index', compact(
            'branches',
            'countries',
            'totalEmployees'
        ));
    }

    public function create(): View
    {
        $organizations = Organization::all();
        return view('admin.branches.create', compact('organizations'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:branches,code',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'status' => 'required|in:active,inactive,closed',
            'type' => 'required|in:headquarters,regional,local,virtual',
            'manager_name' => 'nullable|string|max:255',
            'manager_email' => 'nullable|email|max:255',
            'manager_phone' => 'nullable|string|max:255',
            'employee_count' => 'required|integer|min:0',
            'established_date' => 'nullable|date',
            'is_main_branch' => 'boolean',
        ]);

        $branch = Branch::create($validated);

        // If this is the main branch, unmark others
        if ($validated['is_main_branch']) {
            Branch::where('organization_id', $validated['organization_id'])
                ->where('id', '!=', $branch->id)
                ->update(['is_main_branch' => false]);
        }

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'Branch created successfully.');
    }

    public function show(Branch $branch): View
    {
        $branch->load(['organization', 'departments', 'users']);
        
        $departments = $branch->departments()->with(['manager', 'assistantManager', 'users'])->get();
        $employees = $branch->users()->with(['department', 'roles'])->get();

        return view('admin.branches.show', compact(
            'branch',
            'departments',
            'employees'
        ));
    }

    public function edit(Branch $branch): View
    {
        $organizations = Organization::all();
        return view('admin.branches.edit', compact('branch', 'organizations'));
    }

    public function update(Request $request, Branch $branch): RedirectResponse
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:branches,code,' . $branch->id,
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'status' => 'required|in:active,inactive,closed',
            'type' => 'required|in:headquarters,regional,local,virtual',
            'manager_name' => 'nullable|string|max:255',
            'manager_email' => 'nullable|email|max:255',
            'manager_phone' => 'nullable|string|max:255',
            'employee_count' => 'required|integer|min:0',
            'established_date' => 'nullable|date',
            'is_main_branch' => 'boolean',
        ]);

        $branch->update($validated);

        // If this is the main branch, unmark others
        if ($validated['is_main_branch']) {
            Branch::where('organization_id', $validated['organization_id'])
                ->where('id', '!=', $branch->id)
                ->update(['is_main_branch' => false]);
        }

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'Branch updated successfully.');
    }

    public function destroy(Branch $branch): RedirectResponse
    {
        $branch->delete();

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'Branch deleted successfully.');
    }

    public function dashboard(Branch $branch): View
    {
        $branch->load(['organization', 'departments', 'users']);
        
        $stats = [
            'total_departments' => $branch->departments()->count(),
            'active_departments' => $branch->departments()->where('status', 'active')->count(),
            'total_employees' => $branch->users()->count(),
            'active_employees' => $branch->users()->where('is_active_employee', true)->count(),
            'performance_metrics' => $branch->performance_metrics,
            'is_open_now' => $branch->is_open_now,
            'operating_status' => $branch->operating_status,
            'has_coordinates' => $branch->hasCoordinates(),
        ];

        return view('admin.branches.dashboard', compact('branch', 'stats'));
    }
}
