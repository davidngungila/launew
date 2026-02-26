@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Operations Dashboard</h1>
            <p class="text-slate-500 font-medium">Tour planning, assignments, and readiness overview</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.operations.calendar') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                <i class="ph ph-calendar"></i>
                Calendar
            </a>
            <a href="{{ route('admin.operations.upcoming') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <i class="ph ph-road-horizon"></i>
                Upcoming
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-6 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Upcoming (30 days)</p>
            <h4 class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($stats['upcoming_30_days'] ?? 0) }}</h4>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Active Trips</p>
            <h4 class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($stats['active_trips'] ?? 0) }}</h4>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Pending Approval</p>
            <h4 class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($stats['pending_approval'] ?? 0) }}</h4>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Unassigned Guides</p>
            <h4 class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($stats['unassigned_guides'] ?? 0) }}</h4>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Unassigned Drivers</p>
            <h4 class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($stats['unassigned_drivers'] ?? 0) }}</h4>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Unassigned Vehicles</p>
            <h4 class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($stats['unassigned_vehicles'] ?? 0) }}</h4>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-black text-slate-900 tracking-tight">Next Departures</h3>
                <p class="text-slate-500 font-medium text-sm">Quick access for assignments and booking details</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.operations.assign.guides') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-xs">Assign Guides</a>
                <a href="{{ route('admin.operations.assign.drivers') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-xs">Assign Drivers</a>
                <a href="{{ route('admin.fleet.index') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-xs">Fleet</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-white">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest min-w-[180px]">Client / ID</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tour</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Travel Date</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Assignments</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($upcoming as $booking)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-900">{{ $booking->customer_name }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 mt-0.5 tracking-widest uppercase">#BK-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-sm font-bold text-slate-700 leading-tight truncate max-w-[240px]" title="{{ $booking->tour->name ?? 'Custom Safari' }}">{{ $booking->tour->name ?? 'Custom Safari' }}</p>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-xs font-black text-slate-900">{{ $booking->start_date ? date('d M Y', strtotime($booking->start_date)) : 'TBD' }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest space-y-1">
                                    <div>Guide: <span class="text-slate-900">{{ $booking->guide->name ?? 'Unassigned' }}</span></div>
                                    <div>Driver: <span class="text-slate-900">{{ $booking->driver->name ?? 'Unassigned' }}</span></div>
                                    <div>Vehicle: <span class="text-slate-900">{{ $booking->vehicle->plate_number ?? 'Unassigned' }}</span></div>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all"><i class="ph-bold ph-eye text-lg"></i></a>
                                    <a href="{{ route('admin.bookings.assignments.edit', $booking->id) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all"><i class="ph-bold ph-user-circle-gear text-lg"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center">
                                <p class="text-slate-400 font-medium">No upcoming bookings found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
