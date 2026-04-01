@extends('layouts.admin')

@section('title', 'Branches Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Branches</h1>
            <p class="text-slate-500 mt-2">Manage your organization's locations and facilities</p>
        </div>
        @if(auth()->user()->canManageTeam())
            <a href="{{ route('admin.branches.create') }}" class="bg-emerald-600 text-white px-5 py-2.5 rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <i class="ph ph-plus"></i>
                Add Branch
            </a>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-semibold text-slate-900">Total Branches</h3>
                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class="ph ph-map-pin text-emerald-600"></i>
                </div>
            </div>
            <p class="text-3xl font-black text-slate-900">{{ $branches->count() }}</p>
            <p class="text-sm text-slate-500">All locations</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-semibold text-slate-900">Active Branches</h3>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="ph ph-check-circle text-green-600"></i>
                </div>
            </div>
            <p class="text-3xl font-black text-slate-900">{{ $branches->where('status', 'active')->count() }}</p>
            <p class="text-sm text-slate-500">Operating</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-semibold text-slate-900">Countries</h3>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="ph ph-globe text-blue-600"></i>
                </div>
            </div>
            <p class="text-3xl font-black text-slate-900">{{ $countries->count() }}</p>
            <p class="text-sm text-slate-500">Operating regions</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-semibold text-slate-900">Total Employees</h3>
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="ph ph-users text-orange-600"></i>
                </div>
            </div>
            <p class="text-3xl font-black text-slate-900">{{ $totalEmployees }}</p>
            <p class="text-sm text-slate-500">Branch staff</p>
        </div>
    </div>

    <!-- Branches Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="p-6 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-slate-900">Branches List</h2>
                <div class="flex items-center gap-3">
                    <!-- Search -->
                    <div class="relative">
                        <input type="text" placeholder="Search branches..." class="pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent w-64">
                        <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    </div>
                    
                    <!-- Filter -->
                    <select class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="">All Types</option>
                        <option value="headquarters">Headquarters</option>
                        <option value="regional">Regional</option>
                        <option value="local">Local</option>
                        <option value="virtual">Virtual</option>
                    </select>

                    <!-- Country Filter -->
                    <select class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="">All Countries</option>
                        @foreach($countries as $country)
                            <option value="{{ $country }}">{{ $country }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Branch</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Manager</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Employees</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Operating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @foreach($branches as $branch)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center mr-3">
                                        @if($branch->is_main_branch)
                                            <i class="ph ph-buildings text-slate-600"></i>
                                        @elseif($branch->type === 'headquarters')
                                            <i class="ph ph-crown text-yellow-600"></i>
                                        @elseif($branch->type === 'regional')
                                            <i class="ph ph-map-pin text-blue-600"></i>
                                        @elseif($branch->type === 'local')
                                            <i class="ph ph-storefront text-green-600"></i>
                                        @else
                                            <i class="ph ph-cloud text-purple-600"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-900">{{ $branch->name }}</div>
                                        <div class="text-sm text-slate-500">{{ $branch->code }}</div>
                                        @if($branch->is_main_branch)
                                            <span class="ml-2 px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Main</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-medium rounded-full
                                    @if($branch->type === 'headquarters') bg-yellow-100 text-yellow-800
                                    @elseif($branch->type === 'regional') bg-blue-100 text-blue-800
                                    @elseif($branch->type === 'local') bg-green-100 text-green-800
                                    @else bg-purple-100 text-purple-800
                                    @endif
                                ">
                                    {{ ucfirst(str_replace('_', ' ', $branch->type)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-900">{{ $branch->city }}, {{ $branch->country }}</div>
                                    <div class="text-slate-500">{{ $branch->full_address }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center">
                                        <i class="ph ph-user text-slate-600"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-900">{{ $branch->manager_name }}</div>
                                        <div class="text-sm text-slate-500">{{ $branch->manager_email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-medium rounded-full
                                    @if($branch->status === 'active') bg-green-100 text-green-800
                                    @elseif($branch->status === 'inactive') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif
                                ">
                                    {{ ucfirst($branch->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                {{ $branch->employee_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full
                                        @if($branch->is_open_now) bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif
                                    ">
                                        {{ $branch->operating_status }}
                                    </span>
                                    @if($branch->operating_hours)
                                        <div class="text-xs text-slate-500">
                                            ({{ $branch->operating_hours[strtolower(now()->format('l'))][0] ?? 'N/A' }} - {{ $branch->operating_hours[strtolower(now()->format('l'))][1] ?? 'N/A' }})
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.branches.show', $branch->id) }}" class="text-emerald-600 hover:text-emerald-900 font-medium">
                                        <i class="ph ph-eye"></i>
                                        View
                                    </a>
                                    @if(auth()->user()->canManageTeam())
                                        <a href="{{ route('admin.branches.edit', $branch->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                            <i class="ph ph-pencil"></i>
                                            Edit
                                        </a>
                                    @endif
                                    @if($branch->hasCoordinates())
                                        <a href="{{ $branch->google_maps_url }}" target="_blank" class="text-purple-600 hover:text-purple-900 font-medium">
                                            <i class="ph ph-map-trifold"></i>
                                            Map
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
