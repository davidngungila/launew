@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Park Fees</h1>
            <p class="text-slate-500 font-medium">Track permits and fee readiness per departure window</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.operations.calendar') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Calendar</a>
            <a href="{{ route('admin.operations.logistics.accommodation') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">Accommodation</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Departures Next 30 Days</div>
            <div class="mt-3 text-3xl font-black text-slate-900">{{ $stats['departures_30_days'] ?? 0 }}</div>
            <div class="mt-1 text-sm font-medium text-slate-500">Plan permits early to avoid delays</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Pending Bookings</div>
            <div class="mt-3 text-3xl font-black text-amber-600">{{ $stats['pending'] ?? 0 }}</div>
            <div class="mt-1 text-sm font-medium text-slate-500">Confirm before purchasing tickets</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Park Fees Queue</div>
            <div class="mt-2 text-sm font-bold text-slate-600">Use this list to coordinate park permits and entry fees</div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-white">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest min-w-[220px]">Client / ID</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest min-w-[240px]">Tour</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Start Date</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($bookings as $booking)
                        @php
                            $status = $booking->status ?? 'pending';
                            $badge = 'bg-slate-50 text-slate-700 border-slate-100';
                            if ($status === 'confirmed') $badge = 'bg-emerald-50 text-emerald-700 border-emerald-100';
                            if ($status === 'pending') $badge = 'bg-amber-50 text-amber-700 border-amber-100';
                            if ($status === 'completed') $badge = 'bg-blue-50 text-blue-700 border-blue-100';
                            if ($status === 'cancelled') $badge = 'bg-red-50 text-red-700 border-red-100';
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-900">{{ $booking->customer_name }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 mt-0.5 tracking-widest uppercase">#BK-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-sm font-bold text-slate-700 leading-tight truncate max-w-[320px]" title="{{ $booking->tour->name ?? 'Custom Safari' }}">{{ $booking->tour->name ?? 'Custom Safari' }}</p>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-xs font-black text-slate-900">{{ $booking->start_date ? date('d M Y', strtotime($booking->start_date)) : 'TBD' }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="inline-flex px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-[0.2em] border {{ $badge }}">{{ $status }}</span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Open</a>
                                    <a href="{{ route('admin.bookings.receipt.preview', $booking->id) }}" target="_blank" class="px-4 py-2 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all shadow-sm">Receipt</a>
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

        <div class="p-8 border-t border-slate-50 flex items-center justify-between">
            <p class="text-xs font-bold text-slate-400">Showing <span class="text-slate-900">{{ $bookings->firstItem() ?? 0 }}</span> to <span class="text-slate-900">{{ $bookings->lastItem() ?? 0 }}</span> of <span class="text-slate-900">{{ $bookings->total() }}</span> Bookings</p>
            <div class="flex items-center gap-2">
                {{ $bookings->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</div>
@endsection
