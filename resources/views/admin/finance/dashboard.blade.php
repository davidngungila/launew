@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Finance Dashboard</h1>
            <p class="text-slate-500 font-medium">Revenue, expenses, cash flow and performance signals</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.finance.invoices.all') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Invoices</a>
            <a href="{{ route('admin.finance.ap.supplier-bills') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Accounts Payable</a>
            <a href="{{ route('admin.finance.export-pdf') }}" target="_blank" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">Export PDF</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
        <div class="md:col-span-2 bg-slate-900 rounded-2xl p-6 text-white shadow-xl">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-white/50">Net Cashflow (MTD)</div>
            <div class="mt-3 text-4xl font-black">${{ number_format((float) ($stats['net_cashflow_mtd'] ?? 0), 2) }}</div>
            <div class="mt-3 text-xs font-bold text-white/60">{{ ($stats['month_start'] ?? now()->startOfMonth())->format('M d') }} - {{ ($stats['month_end'] ?? now()->endOfMonth())->format('M d, Y') }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Income (MTD)</div>
            <div class="mt-3 text-3xl font-black text-emerald-600">${{ number_format((float) ($stats['income_mtd'] ?? 0), 2) }}</div>
            <div class="mt-2 text-xs font-bold text-slate-400">Bookings + income ledger</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Expenses (MTD)</div>
            <div class="mt-3 text-3xl font-black text-rose-600">-${{ number_format((float) ($stats['expense_mtd'] ?? 0), 2) }}</div>
            <div class="mt-2 text-xs font-bold text-slate-400">Operational spend ledger</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Deposit Due (Estimate)</div>
            <div class="mt-3 text-3xl font-black text-amber-600">${{ number_format((float) ($stats['deposit_estimate'] ?? 0), 2) }}</div>
            <div class="mt-2 text-xs font-bold text-slate-400">Rule-based until transactions table is used</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Outstanding (Estimate)</div>
            <div class="mt-3 text-3xl font-black text-slate-900">${{ number_format((float) ($stats['outstanding_estimate'] ?? 0), 2) }}</div>
            <div class="mt-2 text-xs font-bold text-slate-400">Unpaid + partial balance</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                <div>
                    <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Ledger</div>
                    <div class="mt-1 text-xl font-black text-slate-900">Recent Transactions</div>
                </div>
                <a href="{{ route('admin.finance.expenses.index') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all">Expenses</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Date</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Type</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Description</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Category</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recentTransactions as $t)
                            @php
                                $isIncome = ($t->type === 'income');
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-xs font-black text-slate-700">{{ $t->transaction_date ? date('d M Y', strtotime($t->transaction_date)) : '' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-[0.2em] border {{ $isIncome ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-rose-50 text-rose-700 border-rose-100' }}">{{ $t->type }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-slate-900">{{ $t->description }}</div>
                                    @if($t->booking_id)
                                        <a class="text-[10px] font-black uppercase tracking-widest text-emerald-700 hover:underline" href="{{ route('admin.bookings.show', $t->booking_id) }}">BK-{{ str_pad($t->booking_id, 5, '0', STR_PAD_LEFT) }}</a>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $t->category }}</td>
                                <td class="px-6 py-4 text-right text-sm font-black {{ $isIncome ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $isIncome ? '+' : '-' }}${{ number_format((float) $t->amount, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-400 font-bold">No transactions yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Revenue Breakdown (MTD)</div>
                <div class="mt-4 space-y-4">
                    @php
                        $total = (float) ($revenueByTour->sum('amount') ?? 0);
                    @endphp
                    @forelse($revenueByTour as $row)
                        @php
                            $pct = $total > 0 ? round(($row['amount'] / $total) * 100) : 0;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                                <span>{{ $row['name'] }}</span>
                                <span>${{ number_format((float) $row['amount'], 0) }} ({{ $pct }}%)</span>
                            </div>
                            <div class="w-full h-2 bg-slate-50 rounded-full overflow-hidden">
                                <div class="h-full bg-emerald-600" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-sm font-bold text-slate-400">No paid revenue in selected period.</div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Quick Links</div>
                <div class="mt-4 grid grid-cols-1 gap-3">
                    <a href="{{ route('admin.finance.revenue.all-bookings') }}" class="px-5 py-3 bg-white border border-slate-200 rounded-2xl font-black text-slate-700 hover:bg-slate-50 transition-all">Booking Revenue</a>
                    <a href="{{ route('admin.finance.revenue.deposits') }}" class="px-5 py-3 bg-white border border-slate-200 rounded-2xl font-black text-slate-700 hover:bg-slate-50 transition-all">Deposits</a>
                    <a href="{{ route('admin.finance.revenue.outstanding-balances') }}" class="px-5 py-3 bg-white border border-slate-200 rounded-2xl font-black text-slate-700 hover:bg-slate-50 transition-all">Outstanding</a>
                    <a href="{{ route('admin.finance.revenue.multi-currency-tracker') }}" class="px-5 py-3 bg-white border border-slate-200 rounded-2xl font-black text-slate-700 hover:bg-slate-50 transition-all">Multi-Currency</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
