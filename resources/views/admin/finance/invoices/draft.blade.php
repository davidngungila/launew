@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Draft Invoices</h1>
            <p class="text-slate-500 font-medium">Currently mapped to unpaid bookings until invoice tables are introduced</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.finance.invoices.all') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">All Invoices</a>
            <a href="{{ route('admin.finance.invoices.overdue') }}" class="px-5 py-2.5 bg-rose-600 text-white font-bold rounded-xl hover:bg-rose-700 transition-all shadow-lg shadow-rose-500/20">Overdue</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Draft-like Count</div>
            <div class="mt-3 text-3xl font-black text-slate-900">{{ $stats['draft_like'] ?? 0 }}</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Booking</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Customer</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tour</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($rows as $b)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5 text-sm font-black text-slate-900">
                                <a class="hover:text-emerald-600" href="{{ route('admin.bookings.show', $b->id) }}">BK-{{ str_pad($b->id, 5, '0', STR_PAD_LEFT) }}</a>
                            </td>
                            <td class="px-6 py-5 text-sm font-bold text-slate-700">{{ $b->customer_name }}</td>
                            <td class="px-6 py-5 text-sm font-bold text-slate-700">{{ $b->tour->name ?? 'Safari' }}</td>
                            <td class="px-6 py-5 text-right text-sm font-black text-slate-900">${{ number_format((float) $b->total_price, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-slate-400 font-bold">No draft-like invoices found.</td>
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
