@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Customer Balances</h1>
            <p class="text-slate-500 font-medium">Accounts receivable summary grouped by customer email</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.finance.ar.aging-report') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Aging Report</a>
            <a href="{{ route('admin.finance.ar.payment-reminders') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Payment Reminders</a>
            <a href="{{ route('admin.finance.ar.customer-balances.export-pdf') }}" target="_blank" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">Export PDF</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Customers</div>
            <div class="mt-3 text-3xl font-black text-slate-900">{{ $stats['customers'] ?? 0 }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Paid (Estimate)</div>
            <div class="mt-3 text-3xl font-black text-emerald-600">${{ number_format((float) ($stats['paid_estimate_total'] ?? 0), 2) }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Outstanding</div>
            <div class="mt-3 text-3xl font-black text-amber-600">${{ number_format((float) ($stats['outstanding_total'] ?? 0), 2) }}</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Receivables</div>
            <div class="mt-2 text-sm font-bold text-slate-600">Outstanding is estimated from booking payment status + deposit rule</div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest min-w-[260px]">Customer</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Bookings</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Booked</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Paid (Est.)</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Outstanding</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($customers as $c)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5">
                                <div class="text-sm font-black text-slate-900">{{ $c['name'] }}</div>
                                <div class="text-[10px] font-bold text-slate-400">{{ $c['email'] }}</div>
                                @if(!empty($c['phone']))
                                    <div class="text-[10px] font-bold text-slate-400">{{ $c['phone'] }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-sm font-black text-slate-900">{{ $c['bookings'] }}</td>
                            <td class="px-6 py-5 text-right text-sm font-black text-slate-900">${{ number_format((float) $c['booked'], 2) }}</td>
                            <td class="px-6 py-5 text-right text-sm font-black text-emerald-600">${{ number_format((float) $c['paid_estimate'], 2) }}</td>
                            <td class="px-6 py-5 text-right text-sm font-black text-amber-600">${{ number_format((float) $c['outstanding'], 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400 font-bold">No customer balances found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-50">
            <p class="text-xs font-bold text-slate-400">Tip: Next phase will calculate balances from real gateway transactions + invoices due dates.</p>
        </div>
    </div>
</div>
@endsection
