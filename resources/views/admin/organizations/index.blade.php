@extends('layouts.admin')

@section('title', 'Organizations Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Organizations</h1>
            <p class="text-slate-500 mt-2">Manage your organization structure and business entities</p>
        </div>
        @if(auth()->user()->canManageTeam())
            <a href="{{ route('admin.organizations.create') }}" class="bg-emerald-600 text-white px-5 py-2.5 rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <i class="ph ph-plus"></i>
                Add Organization
            </a>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-semibold text-slate-900">Total Organizations</h3>
                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class="ph ph-buildings text-emerald-600"></i>
                </div>
            </div>
            <p class="text-3xl font-black text-slate-900">{{ $organizations->count() }}</p>
            <p class="text-sm text-slate-500">Active entities</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-semibold text-slate-900">Total Branches</h3>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="ph ph-map-pin text-blue-600"></i>
                </div>
            </div>
            <p class="text-3xl font-black text-slate-900">{{ $totalBranches }}</p>
            <p class="text-sm text-slate-500">All locations</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-semibold text-slate-900">Total Departments</h3>
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="ph ph-users-three text-purple-600"></i>
                </div>
            </div>
            <p class="text-3xl font-black text-slate-900">{{ $totalDepartments }}</p>
            <p class="text-sm text-slate-500">All departments</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-semibold text-slate-900">Total Employees</h3>
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="ph ph-user text-orange-600"></i>
                </div>
            </div>
            <p class="text-3xl font-black text-slate-900">{{ $totalEmployees }}</p>
            <p class="text-sm text-slate-500">Active staff</p>
        </div>
    </div>

    <!-- Organizations Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="p-6 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-slate-900">Organizations List</h2>
                <div class="flex items-center gap-3">
                    <!-- Search -->
                    <div class="relative">
                        <input type="text" placeholder="Search organizations..." class="pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent w-64">
                        <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    </div>
                    
                    <!-- Filter -->
                    <select class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="">All Types</option>
                        <option value="tour_operator">Tour Operator</option>
                        <option value="travel_agency">Travel Agency</option>
                        <option value="hospitality">Hospitality</option>
                        <option value="corporate">Corporate</option>
                        <option value="government">Government</option>
                        <option value="ngo">NGO</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Organization</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Branches</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Employees</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">License</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Founded</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @foreach($organizations as $organization)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($organization->logo)
                                        <img src="{{ $organization->logo_url }}" alt="{{ $organization->name }}" class="w-8 h-8 rounded-full object-cover mr-3">
                                    @else
                                        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="ph ph-buildings text-emerald-600"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-medium text-slate-900">{{ $organization->name }}</div>
                                        <div class="text-sm text-slate-500">{{ $organization->code }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-medium rounded-full
                                    @if($organization->type === 'tour_operator') bg-emerald-100 text-emerald-800
                                    @elseif($organization->type === 'travel_agency') bg-blue-100 text-blue-800
                                    @elseif($organization->type === 'hospitality') bg-purple-100 text-purple-800
                                    @elseif($organization->type === 'corporate') bg-gray-100 text-gray-800
                                    @elseif($organization->type === 'government') bg-orange-100 text-orange-800
                                    @else bg-pink-100 text-pink-800
                                    @endif
                                ">
                                    {{ ucfirst(str_replace('_', ' ', $organization->type)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-medium rounded-full
                                    @if($organization->status === 'active') bg-green-100 text-green-800
                                    @elseif($organization->status === 'inactive') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif
                                ">
                                    {{ ucfirst($organization->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                {{ $organization->branch_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                {{ $organization->employee_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full
                                        @if($organization->license_status === 'valid') bg-green-100 text-green-800
                                        @elseif($organization->license_status === 'expiring_soon') bg-yellow-100 text-yellow-800
                                        @elseif($organization->license_status === 'expired') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif
                                    ">
                                        {{ $organization->license_status }}
                                    </span>
                                    @if($organization->license_expiry)
                                        <span class="text-xs text-slate-500">
                                            ({{ $organization->license_expiry->format('M j, Y') }})
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $organization->founded_date ? $organization->founded_date->format('M j, Y') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.organizations.show', $organization->id) }}" class="text-emerald-600 hover:text-emerald-900 font-medium">
                                        <i class="ph ph-eye"></i>
                                        View
                                    </a>
                                    @if(auth()->user()->canManageTeam())
                                        <a href="{{ route('admin.organizations.edit', $organization->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                            <i class="ph ph-pencil"></i>
                                            Edit
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
