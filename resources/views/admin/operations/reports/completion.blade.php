@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Tour Completion Report</h1>
            <p class="text-slate-500 font-medium">Completion summary per booking with date filters</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.operations.reports.performance') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Operations Performance</a>
            <a href="{{ route('admin.operations.dashboard') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">Operations</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">Start</label>
                <input type="date" name="start" value="{{ $start ?? '' }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 font-bold text-slate-700" />
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">End</label>
                <input type="date" name="end" value="{{ $end ?? '' }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 font-bold text-slate-700" />
            </div>
            <div class="md:col-span-3 flex items-center gap-3">
                <button type="submit" class="px-5 py-2.5 bg-slate-900 text-white font-black rounded-xl hover:bg-slate-800 transition-all">Apply</button>
                <a href="{{ route('admin.operations.reports.completion') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Reset</a>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Total</div>
            <div class="mt-3 text-3xl font-black text-slate-900">{{ $stats['total'] ?? 0 }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Completed</div>
            <div class="mt-3 text-3xl font-black text-blue-600">{{ $stats['completed'] ?? 0 }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Confirmed</div>
            <div class="mt-3 text-3xl font-black text-emerald-600">{{ $stats['confirmed'] ?? 0 }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Cancelled</div>
            <div class="mt-3 text-3xl font-black text-red-600">{{ $stats['cancelled'] ?? 0 }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Revenue (Paid)</div>
            <div class="mt-3 text-3xl font-black text-slate-900">${{ number_format((float) ($stats['revenue_paid'] ?? 0), 0) }}</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Bookings</div>
            <div class="mt-2 text-sm font-bold text-slate-600">Export-ready table</div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-white">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Date</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest min-w-[220px]">Client / ID</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest min-w-[240px]">Tour</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Payment</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Total</th>
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
                                <span class="inline-flex px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-[0.2em] border {{ $badge }}">{{ $status }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-bold text-slate-700">{{ $booking->payment_status ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="text-sm font-black text-slate-900">${{ number_format((float) ($booking->total_price ?? 0), 2) }}</div>
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
                            <td colspan="7" class="px-8 py-12 text-center">
                                <p class="text-slate-400 font-medium">No bookings found</p>
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
