@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Reconciliation</h1>
            <p class="text-slate-500 font-medium">Record statement balances and compare with system balances</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.finance.banking.bank-accounts') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Bank Accounts</a>
            <a href="{{ route('admin.finance.banking.cash-accounts') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Cash Accounts</a>
            <a href="{{ route('admin.finance.banking.reconciliation.create') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">New Reconciliation</a>
            <a href="{{ route('admin.finance.banking.reconciliation.export-pdf') }}" target="_blank" class="px-5 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all">Export PDF</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Statement Date</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Account</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Statement</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">System</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Diff</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($reconciliations as $r)
                        @php
                            $diff = (float) $r->statement_balance - (float) $r->system_balance;
                            $diffClass = abs($diff) < 0.01 ? 'text-emerald-600' : 'text-rose-600';
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5 text-sm font-black text-slate-900">{{ $r->statement_date?->format('d M Y') }}</td>
                            <td class="px-6 py-5 text-sm font-bold text-slate-700">{{ $r->account->name ?? '—' }}</td>
                            <td class="px-6 py-5 text-right text-sm font-black text-slate-900">${{ number_format((float) $r->statement_balance, 2) }}</td>
                            <td class="px-6 py-5 text-right text-sm font-black text-slate-900">${{ number_format((float) $r->system_balance, 2) }}</td>
                            <td class="px-6 py-5 text-right text-sm font-black {{ $diffClass }}">{{ $diff >= 0 ? '+' : '' }}${{ number_format($diff, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-10 text-center text-slate-400 font-bold">No reconciliations recorded.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-8 border-t border-slate-50 flex items-center justify-between">
            <p class="text-xs font-bold text-slate-400">Showing <span class="text-slate-900">{{ $reconciliations->firstItem() ?? 0 }}</span> to <span class="text-slate-900">{{ $reconciliations->lastItem() ?? 0 }}</span> of <span class="text-slate-900">{{ $reconciliations->total() }}</span></p>
            {{ $reconciliations->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>
@endsection
