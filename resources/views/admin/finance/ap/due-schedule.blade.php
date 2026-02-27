@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Due Schedule</h1>
            <p class="text-slate-500 font-medium">Upcoming expense payments (next 30 days)</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.finance.ap.supplier-bills') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Supplier Bills</a>
            <a href="{{ route('admin.finance.ap.pending-payments') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Pending Payments</a>
            <a href="{{ route('admin.finance.ap.due-schedule.export-pdf') }}" target="_blank" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">Export PDF</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Due (7 Days)</div>
            <div class="mt-3 text-3xl font-black text-slate-900">{{ $stats['due_7_count'] ?? 0 }}</div>
            <div class="mt-1 text-sm font-black text-rose-600">${{ number_format((float) ($stats['due_7_amount'] ?? 0), 2) }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Due (30 Days)</div>
            <div class="mt-3 text-3xl font-black text-slate-900">{{ $stats['due_30_count'] ?? 0 }}</div>
            <div class="mt-1 text-sm font-black text-amber-600">${{ number_format((float) ($stats['due_30_amount'] ?? 0), 2) }}</div>
        </div>
        <div class="md:col-span-2 bg-slate-900 rounded-2xl p-6 text-white shadow-xl">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-white/50">Notes</div>
            <div class="mt-3 text-sm font-bold text-white/70">This schedule is based on expense transaction dates. Next phase will add approval/payment status per bill.</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Date</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Category</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest min-w-[320px]">Description</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Amount</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Booking</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($rows as $t)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5 text-sm font-black text-slate-900">{{ $t->transaction_date ? date('d M Y', strtotime($t->transaction_date)) : '' }}</td>
                            <td class="px-6 py-5">
                                <span class="inline-flex px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-[0.2em] border bg-slate-50 text-slate-700 border-slate-100">{{ $t->category }}</span>
                            </td>
                            <td class="px-6 py-5 text-sm font-bold text-slate-700">{{ $t->description }}</td>
                            <td class="px-6 py-5 text-right text-sm font-black text-rose-600">-${{ number_format((float) $t->amount, 2) }}</td>
                            <td class="px-6 py-5">
                                @if($t->booking_id)
                                    <a href="{{ route('admin.bookings.show', $t->booking_id) }}" class="text-sm font-black text-emerald-700 hover:underline">BK-{{ str_pad($t->booking_id, 5, '0', STR_PAD_LEFT) }}</a>
                                @else
                                    <span class="text-sm font-bold text-slate-400">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400 font-bold">No upcoming expenses found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-8 border-t border-slate-50 flex items-center justify-between">
            <p class="text-xs font-bold text-slate-400">Showing <span class="text-slate-900">{{ $rows->firstItem() ?? 0 }}</span> to <span class="text-slate-900">{{ $rows->lastItem() ?? 0 }}</span> of <span class="text-slate-900">{{ $rows->total() }}</span></p>
            {{ $rows->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>
@endsection
