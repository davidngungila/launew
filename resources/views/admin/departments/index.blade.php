@extends('layouts.admin')

@section('title', 'Departments Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Departments</h1>
            <p class="text-slate-500 mt-2">Manage organizational structure and team assignments</p>
        </div>
        @if(auth()->user()->canManageTeam())
            <a href="{{ route('admin.departments.create') }}" class="bg-emerald-600 text-white px-5 py-2.5 rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <i class="ph ph-plus"></i>
                Add Department
            </a>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-semibold text-slate-900">Total Departments</h3>
                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class="ph ph-users-three text-emerald-600"></i>
                </div>
            </div>
            <p class="text-3xl font-black text-slate-900">{{ $departments->count() }}</p>
            <p class="text-sm text-slate-500">All departments</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-semibold text-slate-900">Active Departments</h3>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="ph ph-check-circle text-green-600"></i>
                </div>
            </div>
            <p class="text-3xl font-black text-slate-900">{{ $departments->where('status', 'active')->count() }}</p>
            <p class="text-sm text-slate-500">Operating</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-semibold text-slate-900">Core Departments</h3>
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="ph ph-star text-purple-600"></i>
                </div>
            </div>
            <p class="text-3xl font-black text-slate-900">{{ $departments->where('is_core_department', true)->count() }}</p>
            <p class="text-sm text-slate-500">Essential units</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-semibold text-slate-900">Total Budget</h3>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="ph ph-currency-dollar text-blue-600"></i>
                </div>
            </div>
            <p class="text-3xl font-black text-slate-900">${{ number_format($totalBudget, 2) }}</p>
            <p class="text-sm text-slate-500">Allocated funds</p>
        </div>
    </div>

    <!-- Departments Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="p-6 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-slate-900">Departments List</h2>
                <div class="flex items-center gap-3">
                    <!-- Search -->
                    <div class="relative">
                        <input type="text" placeholder="Search departments..." class="pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent w-64">
                        <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    </div>
                    
                    <!-- Type Filter -->
                    <select class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="">All Types</option>
                        <option value="executive">Executive</option>
                        <option value="operations">Operations</option>
                        <option value="finance">Finance</option>
                        <option value="human_resources">Human Resources</option>
                        <option value="marketing">Marketing</option>
                        <option value="sales">Sales</option>
                        <option value="customer_service">Customer Service</option>
                        <option value="it">IT</option>
                        <option value="tour_operations">Tour Operations</option>
                        <option value="guides">Tour Guides</option>
                    </select>

                    <!-- Branch Filter -->
                    <select class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Department</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Branch</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Manager</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Employees</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Budget</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Utilization</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @foreach($departments as $department)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="font-medium text-slate-900">{{ $department->name }}</div>
                                    <div class="text-sm text-slate-500">{{ $department->full_code }}</div>
                                    @if($department->is_core_department)
                                        <span class="ml-2 px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded-full">Core</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-medium rounded-full
                                    @if($department->type === 'executive') bg-yellow-100 text-yellow-800
                                    @elseif($department->type === 'operations') bg-blue-100 text-blue-800
                                    @elseif($department->type === 'finance') bg-green-100 text-green-800
                                    @elseif($department->type === 'human_resources') bg-purple-100 text-purple-800
                                    @elseif($department->type === 'marketing') bg-pink-100 text-pink-800
                                    @elseif($department->type === 'tour_operations') bg-emerald-100 text-emerald-800
                                    @else bg-gray-100 text-gray-800
                                    @endif
                                ">
                                    {{ $department->department_type_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-900">{{ $department->branch ? $department->branch->name : 'N/A' }}</div>
                                    <div class="text-slate-500">{{ $department->branch ? $department->branch->code : 'N/A' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center">
                                        <i class="ph ph-user text-slate-600"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-900">{{ $department->manager_name }}</div>
                                        <div class="text-sm text-slate-500">{{ $department->manager_email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                {{ $department->employee_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-900">${{ number_format($department->budget, 2) }}</div>
                                    <div class="text-slate-500">{{ $department->employee_count }} staff</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-16 bg-slate-200 rounded-full h-2">
                                        <div class="h-2 bg-emerald-600 rounded-full" style="width: {{ min(100, $department->budget_utilization) }}%"></div>
                                    </div>
                                    <span class="text-sm text-slate-900">{{ round($department->budget_utilization, 1) }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-medium rounded-full
                                    @if($department->status === 'active') bg-green-100 text-green-800
                                    @elseif($department->status === 'inactive') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif
                                ">
                                    {{ ucfirst($department->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.departments.show', $department->id) }}" class="text-emerald-600 hover:text-emerald-900 font-medium">
                                        <i class="ph ph-eye"></i>
                                        View
                                    </a>
                                    @if(auth()->user()->canManageTeam())
                                        <a href="{{ route('admin.departments.edit', $department->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                            <i class="ph ph-pencil"></i>
                                            Edit
                                        </a>
                                    @endif
                                    @if($department->email)
                                        <a href="mailto:{{ $department->email }}" class="text-purple-600 hover:text-purple-900 font-medium">
                                            <i class="ph ph-envelope"></i>
                                            Email
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
