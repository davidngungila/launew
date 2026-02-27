@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Supplier Payments</h1>
            <p class="text-slate-500 font-medium">Coordinate supplier/operator bills and payouts</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.operations.suppliers.operators') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Operators</a>
            <a href="{{ route('admin.operations.suppliers.contracts') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Contracts</a>
            <a href="{{ route('admin.finance.ap.supplier-bills') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">Open Supplier Bills</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Bookings Next 30 Days</div>
            <div class="mt-3 text-3xl font-black text-slate-900">{{ $stats['bookings_next_30'] ?? 0 }}</div>
            <div class="mt-1 text-sm font-medium text-slate-500">Forecast upcoming supplier workload</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Operators</div>
            <div class="mt-3 text-3xl font-black text-emerald-600">{{ $stats['operators'] ?? 0 }}</div>
            <div class="mt-1 text-sm font-medium text-slate-500">Active suppliers with commission terms</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-10">
        <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Payment Workflow</div>
        <div class="mt-3 text-sm font-bold text-slate-700">Use Finance &gt; Accounts Payable to record supplier bills and schedule payments.</div>
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.finance.ap.supplier-bills') }}" class="p-6 rounded-2xl border border-slate-100 hover:border-emerald-200 hover:bg-emerald-50/30 transition-all">
                <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Finance</div>
                <div class="mt-2 text-lg font-black text-slate-900">Supplier Bills</div>
                <div class="mt-1 text-sm font-medium text-slate-500">Record bills and supplier invoices</div>
            </a>
            <a href="{{ route('admin.finance.ap.pending-payments') }}" class="p-6 rounded-2xl border border-slate-100 hover:border-emerald-200 hover:bg-emerald-50/30 transition-all">
                <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Finance</div>
                <div class="mt-2 text-lg font-black text-slate-900">Pending Payments</div>
                <div class="mt-1 text-sm font-medium text-slate-500">Approve and schedule payouts</div>
            </a>
            <a href="{{ route('admin.finance.ap.operator-payments') }}" class="p-6 rounded-2xl border border-slate-100 hover:border-emerald-200 hover:bg-emerald-50/30 transition-all">
                <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Finance</div>
                <div class="mt-2 text-lg font-black text-slate-900">Operator Payments</div>
                <div class="mt-1 text-sm font-medium text-slate-500">Review operator payout ledger</div>
            </a>
        </div>
    </div>
</div>
@endsection
