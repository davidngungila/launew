@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Cash Accounts</h1>
            <p class="text-slate-500 font-medium">Petty cash, tills and field cash float</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.finance.banking.bank-accounts') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Bank Accounts</a>
            <a href="{{ route('admin.finance.banking.transfers') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Transfers</a>
            <a href="{{ route('admin.finance.banking.reconciliation') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Reconciliation</a>
            <a href="{{ route('admin.finance.banking.accounts.create', ['type' => 'cash']) }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">New Account</a>
            <a href="{{ route('admin.finance.banking.cash-accounts.export-pdf') }}" target="_blank" class="px-5 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all">Export PDF</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Accounts</div>
            <div class="mt-3 text-3xl font-black text-slate-900">{{ $stats['count'] ?? 0 }}</div>
        </div>
        <div class="bg-slate-900 rounded-2xl p-6 text-white shadow-xl md:col-span-2">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-white/50">Total Cash (Calculated)</div>
            <div class="mt-3 text-3xl font-black">${{ number_format((float) ($stats['balance_total'] ?? 0), 2) }}</div>
            <div class="mt-2 text-xs font-bold text-white/60">Use transfers to move money between cash/bank.</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Account</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Currency</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Balance</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($accounts as $a)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5">
                                <div class="text-sm font-black text-slate-900">{{ $a->name }}</div>
                            </td>
                            <td class="px-6 py-5 text-sm font-black text-slate-900">{{ $a->currency }}</td>
                            <td class="px-6 py-5">
                                <span class="inline-flex px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-[0.2em] border {{ $a->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-slate-50 text-slate-700 border-slate-100' }}">{{ $a->is_active ? 'active' : 'inactive' }}</span>
                                <div class="mt-1 text-[10px] font-bold text-slate-400">Reconciled: {{ $a->last_reconciled_at ? $a->last_reconciled_at->format('d M Y') : '—' }}</div>
                            </td>
                            <td class="px-6 py-5 text-right text-sm font-black text-slate-900">${{ number_format((float) ($a->calculated_balance ?? 0), 2) }}</td>
                            <td class="px-6 py-5 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.finance.banking.accounts.edit', $a) }}" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all"><i class="ph-bold ph-pencil-simple text-lg"></i></a>
                                    <form action="{{ route('admin.finance.banking.accounts.destroy', $a) }}" method="POST" onsubmit="return confirm('Delete this account?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all"><i class="ph-bold ph-trash text-lg"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-10 text-center text-slate-400 font-bold">No cash accounts found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
