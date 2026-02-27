@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Transfers</h1>
            <p class="text-slate-500 font-medium">Move funds between cash and bank accounts</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.finance.banking.bank-accounts') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Bank Accounts</a>
            <a href="{{ route('admin.finance.banking.cash-accounts') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Cash Accounts</a>
            <a href="{{ route('admin.finance.banking.transfers.create') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">New Transfer</a>
            <a href="{{ route('admin.finance.banking.transfers.export-pdf') }}" target="_blank" class="px-5 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all">Export PDF</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Transfers</div>
            <div class="mt-3 text-3xl font-black text-slate-900">{{ $stats['count'] ?? 0 }}</div>
        </div>
        <div class="bg-slate-900 rounded-2xl p-6 text-white shadow-xl">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-white/50">Total Amount</div>
            <div class="mt-3 text-3xl font-black">${{ number_format((float) ($stats['total'] ?? 0), 2) }}</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Date</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">From</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">To</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Reference</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($transfers as $t)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5 text-sm font-black text-slate-900">{{ $t->transfer_date?->format('d M Y') }}</td>
                            <td class="px-6 py-5 text-sm font-bold text-slate-700">{{ $t->fromAccount->name ?? '—' }}</td>
                            <td class="px-6 py-5 text-sm font-bold text-slate-700">{{ $t->toAccount->name ?? '—' }}</td>
                            <td class="px-6 py-5 text-sm font-bold text-slate-500">{{ $t->reference ?? '—' }}</td>
                            <td class="px-6 py-5 text-right text-sm font-black text-slate-900">${{ number_format((float) $t->amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-10 text-center text-slate-400 font-bold">No transfers recorded.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-8 border-t border-slate-50 flex items-center justify-between">
            <p class="text-xs font-bold text-slate-400">Showing <span class="text-slate-900">{{ $transfers->firstItem() ?? 0 }}</span> to <span class="text-slate-900">{{ $transfers->lastItem() ?? 0 }}</span> of <span class="text-slate-900">{{ $transfers->total() }}</span></p>
            {{ $transfers->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>
@endsection
