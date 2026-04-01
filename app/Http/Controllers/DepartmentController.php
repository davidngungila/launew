<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Organization;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DepartmentController extends Controller
{
    public function index(): View
    {
        $departments = Department::with(['organization', 'branch', 'manager', 'assistantManager'])->get();
        $branches = Branch::with('organization')->get();
        $totalBudget = Department::sum('budget');

        return view('admin.departments.index', compact(
            'departments',
            'branches',
            'totalBudget'
        ));
    }

    public function create(): View
    {
        $organizations = Organization::all();
        $branches = Branch::all();
        $users = User::all();

        return view('admin.departments.create', compact(
            'organizations',
            'branches',
            'users'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'branch_id' => 'nullable|exists:branches,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:departments,code',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,merged',
            'type' => 'required|in:executive,operations,finance,human_resources,marketing,sales,customer_service,it,legal,procurement,quality_assurance,research_development,administration,tour_operations,guides,transport,accommodation,food_beverage,security,maintenance',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'manager_id' => 'nullable|exists:users,id',
            'assistant_manager_id' => 'nullable|exists:users,id',
            'employee_count' => 'required|integer|min:0',
            'budget' => 'nullable|numeric|min:0',
            'established_date' => 'nullable|date',
            'parent_department_id' => 'nullable|exists:departments,id',
            'sort_order' => 'integer|min:0',
            'is_core_department' => 'boolean',
        ]);

        Department::create($validated);

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Department created successfully.');
    }

    public function show(Department $department): View
    {
        $department->load(['organization', 'branch', 'manager', 'assistantManager', 'users', 'parentDepartment', 'childDepartments']);
        
        $users = $department->users()->with(['roles', 'branch'])->get();
        $childDepartments = $department->childDepartments()->with(['manager', 'users'])->get();

        return view('admin.departments.show', compact(
            'department',
            'users',
            'childDepartments'
        ));
    }

    public function edit(Department $department): View
    {
        $organizations = Organization::all();
        $branches = Branch::all();
        $users = User::all();
        $departments = Department::all(); // For parent department selection

        return view('admin.departments.edit', compact(
            'department',
            'organizations',
            'branches',
            'users',
            'departments'
        ));
    }

    public function update(Request $request, Department $department): RedirectResponse
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'branch_id' => 'nullable|exists:branches,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:departments,code,' . $department->id,
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,merged',
            'type' => 'required|in:executive,operations,finance,human_resources,marketing,sales,customer_service,it,legal,procurement,quality_assurance,research_development,administration,tour_operations,guides,transport,accommodation,food_beverage,security,maintenance',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'manager_id' => 'nullable|exists:users,id',
            'assistant_manager_id' => 'nullable|exists:users,id',
            'employee_count' => 'required|integer|min:0',
            'budget' => 'nullable|numeric|min:0',
            'established_date' => 'nullable|date',
            'parent_department_id' => 'nullable|exists:departments,id',
            'sort_order' => 'integer|min:0',
            'is_core_department' => 'boolean',
        ]);

        $department->update($validated);

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department): RedirectResponse
    {
        $department->delete();

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Department deleted successfully.');
    }

    public function dashboard(Department $department): View
    {
        $department->load(['organization', 'branch', 'manager', 'assistantManager', 'users', 'parentDepartment', 'childDepartments']);
        
        $stats = [
            'total_employees' => $department->total_employee_count,
            'direct_employees' => $department->employee_count,
            'sub_departments' => $department->childDepartments()->count(),
            'budget_utilization' => $department->budget_utilization,
            'performance_metrics' => $department->performance_metrics,
            'hierarchy_level' => $department->hierarchy_level,
            'department_path' => $department->department_path,
            'department_tree' => $department->department_tree,
            'can_add_employee' => $department->canAddEmployee(),
            'can_add_sub_department' => $department->canAddSubDepartment(),
        ];

        return view('admin.departments.dashboard', compact('department', 'stats'));
    }
}
