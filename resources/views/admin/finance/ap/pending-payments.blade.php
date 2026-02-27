@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Pending Payments</h1>
            <p class="text-slate-500 font-medium">Review supplier-related expenses to approve and schedule payments</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.finance.ap.supplier-bills') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Supplier Bills</a>
            <a href="{{ route('admin.finance.ap.operator-payments') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">Operator Payments</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Pending Items</div>
            <div class="mt-3 text-3xl font-black text-slate-900">{{ $stats['pending_count'] ?? 0 }}</div>
            <div class="mt-1 text-sm font-medium text-slate-500">Supplier-related expense transactions</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Pending Amount</div>
            <div class="mt-3 text-3xl font-black text-amber-600">${{ number_format((float) ($stats['pending_amount'] ?? 0), 2) }}</div>
            <div class="mt-1 text-sm font-medium text-slate-500">Approve for payout scheduling</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Queue</div>
            <div class="mt-2 text-sm font-bold text-slate-600">This page will be connected to payment approval workflow in next phase</div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-white">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Date</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Category</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest min-w-[320px]">Description</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Amount</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Booking</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($pendingBills as $bill)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5">
                                <div class="text-sm font-black text-slate-900">{{ $bill->transaction_date ? date('d M Y', strtotime($bill->transaction_date)) : '' }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="inline-flex px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-[0.2em] border bg-amber-50 text-amber-700 border-amber-100">{{ $bill->category }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-bold text-slate-700">{{ $bill->description }}</div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="text-sm font-black text-slate-900">${{ number_format((float) $bill->amount, 2) }}</div>
                            </td>
                            <td class="px-6 py-5">
                                @if(!empty($bill->booking_id))
                                    <a href="{{ route('admin.bookings.show', $bill->booking_id) }}" class="text-sm font-black text-emerald-700 hover:text-emerald-900">BK-{{ str_pad($bill->booking_id, 5, '0', STR_PAD_LEFT) }}</a>
                                @else
                                    <span class="text-sm font-bold text-slate-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center">
                                <p class="text-slate-400 font-medium">No pending items found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-8 border-t border-slate-50 flex items-center justify-between">
            <p class="text-xs font-bold text-slate-400">Showing <span class="text-slate-900">{{ $pendingBills->firstItem() ?? 0 }}</span> to <span class="text-slate-900">{{ $pendingBills->lastItem() ?? 0 }}</span> of <span class="text-slate-900">{{ $pendingBills->total() }}</span> Items</p>
            <div class="flex items-center gap-2">
                {{ $pendingBills->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</div>
@endsection
