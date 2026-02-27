@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Operations Performance</h1>
            <p class="text-slate-500 font-medium">Readiness KPIs, incident load, and upcoming departures</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.operations.reports.completion') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Completion Report</a>
            <a href="{{ route('admin.operations.calendar') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">Calendar</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Upcoming (30d)</div>
            <div class="mt-3 text-3xl font-black text-slate-900">{{ $stats['upcoming_30'] ?? 0 }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Ready (All Assigned)</div>
            <div class="mt-3 text-3xl font-black text-emerald-600">{{ $stats['ready_all_assigned'] ?? 0 }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Missing Assignments</div>
            <div class="mt-3 text-3xl font-black text-amber-600">{{ $stats['missing_assignments'] ?? 0 }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Open Incidents</div>
            <div class="mt-3 text-3xl font-black text-red-600">{{ $stats['open_incidents'] ?? 0 }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">New Feedback</div>
            <div class="mt-3 text-3xl font-black text-slate-900">{{ $stats['new_feedback'] ?? 0 }}</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Upcoming Departures (30 Days)</div>
            <div class="mt-2 text-sm font-bold text-slate-600">Readiness snapshot per booking</div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-white">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Date</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest min-w-[220px]">Client / ID</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest min-w-[240px]">Tour</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Readiness</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($upcoming as $booking)
                        @php
                            $missingGuide = empty($booking->guide_id);
                            $missingDriver = empty($booking->driver_id);
                            $missingVehicle = empty($booking->vehicle_id);
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5">
                                <div class="text-sm font-black text-slate-900">{{ $booking->start_date ? date('d M Y', strtotime($booking->start_date)) : 'TBD' }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-black text-slate-900">{{ $booking->customer_name }}</div>
                                <div class="text-[10px] font-bold text-slate-400 tracking-widest uppercase">BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-bold text-slate-700">{{ $booking->tour->name ?? 'Safari' }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex flex-wrap gap-2">
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-[0.2em] border {{ $missingGuide ? 'bg-red-50 text-red-700 border-red-100' : 'bg-emerald-50 text-emerald-700 border-emerald-100' }}">Guide</span>
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-[0.2em] border {{ $missingDriver ? 'bg-red-50 text-red-700 border-red-100' : 'bg-emerald-50 text-emerald-700 border-emerald-100' }}">Driver</span>
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-[0.2em] border {{ $missingVehicle ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-emerald-50 text-emerald-700 border-emerald-100' }}">Vehicle</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Open</a>
                                    <a href="{{ route('admin.bookings.assignments.edit', $booking->id) }}" class="px-4 py-2 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">Assignments</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center">
                                <p class="text-slate-400 font-medium">No upcoming departures found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-8 border-t border-slate-50 flex items-center justify-between">
            <p class="text-xs font-bold text-slate-400">Showing <span class="text-slate-900">{{ $upcoming->firstItem() ?? 0 }}</span> to <span class="text-slate-900">{{ $upcoming->lastItem() ?? 0 }}</span> of <span class="text-slate-900">{{ $upcoming->total() }}</span> Bookings</p>
            <div class="flex items-center gap-2">
                {{ $upcoming->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</div>
@endsection
