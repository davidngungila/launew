@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Assign Vehicles</h1>
            <p class="text-slate-500 font-medium">Bookings that require a vehicle assignment</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.operations.assign.guides') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Assign Guides</a>
            <a href="{{ route('admin.operations.assign.drivers') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Assign Drivers</a>
            <a href="{{ route('admin.operations.upcoming') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">Upcoming</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-white">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest min-w-[180px]">Client / ID</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest min-w-[220px]">Tour</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Travel Date</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Current Team</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-900">{{ $booking->customer_name }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 mt-0.5 tracking-widest uppercase">#BK-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-sm font-bold text-slate-700 leading-tight truncate max-w-[260px]" title="{{ $booking->tour->name ?? 'Custom Safari' }}">{{ $booking->tour->name ?? 'Custom Safari' }}</p>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-xs font-black text-slate-900">{{ $booking->start_date ? date('d M Y', strtotime($booking->start_date)) : 'TBD' }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest space-y-1">
                                    <div>Guide: <span class="text-slate-900">{{ $booking->guide->name ?? 'Unassigned' }}</span></div>
                                    <div>Driver: <span class="text-slate-900">{{ $booking->driver->name ?? 'Unassigned' }}</span></div>
                                    <div>Vehicle: <span class="text-red-600">Unassigned</span></div>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <a href="{{ route('admin.bookings.assignments.edit', $booking->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white font-black text-[10px] uppercase tracking-[0.2em] rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">
                                    <i class="ph-bold ph-jeep"></i>
                                    Assign
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center">
                                <p class="text-slate-400 font-medium">No vehicle assignments pending</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-8 border-t border-slate-50 flex items-center justify-between">
            <p class="text-xs font-bold text-slate-400">Showing <span class="text-slate-900">{{ $bookings->firstItem() ?? 0 }}</span> to <span class="text-slate-900">{{ $bookings->lastItem() ?? 0 }}</span> of <span class="text-slate-900">{{ $bookings->total() }}</span> Bookings</p>
            <div class="flex items-center gap-2">
                {{ $bookings->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</div>
@endsection
