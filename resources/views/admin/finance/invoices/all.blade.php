@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">All Invoices</h1>
            <p class="text-slate-500 font-medium">Booking vouchers/receipts (advanced invoice system comes next)</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.finance.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Dashboard</a>
            <a href="{{ route('admin.finance.invoices.export-pdf', ['status' => $status]) }}" target="_blank" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">Export PDF</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">Payment Status</label>
                <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 font-bold text-slate-700">
                    <option value="">All</option>
                    @foreach(['paid','partially_paid','unpaid'] as $st)
                        <option value="{{ $st }}" {{ ($status ?? '') === $st ? 'selected' : '' }}>{{ strtoupper(str_replace('_',' ', $st)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-4 flex items-center gap-3">
                <button type="submit" class="px-5 py-2.5 bg-slate-900 text-white font-black rounded-xl hover:bg-slate-800 transition-all">Apply</button>
                <a href="{{ route('admin.finance.invoices.all') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Reset</a>
                <a href="{{ route('admin.finance.invoices.create') }}" class="ml-auto px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">Create Invoice</a>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Total</div>
            <div class="mt-3 text-3xl font-black text-slate-900">{{ $stats['total'] ?? 0 }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Paid</div>
            <div class="mt-3 text-3xl font-black text-emerald-600">{{ $stats['paid'] ?? 0 }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Partial</div>
            <div class="mt-3 text-3xl font-black text-amber-600">{{ $stats['partial'] ?? 0 }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Unpaid</div>
            <div class="mt-3 text-3xl font-black text-rose-600">{{ $stats['unpaid'] ?? 0 }}</div>
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
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Payment</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Total</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">PDF</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($rows as $b)
                        @php
                            $p = $b->payment_status ?? 'unpaid';
                            $pClass = 'bg-red-50 text-red-700 border-red-100';
                            if ($p === 'paid') $pClass = 'bg-emerald-50 text-emerald-700 border-emerald-100';
                            if ($p === 'partially_paid') $pClass = 'bg-amber-50 text-amber-700 border-amber-100';
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5 text-sm font-black text-slate-900">
                                <a class="hover:text-emerald-600" href="{{ route('admin.bookings.show', $b->id) }}">BK-{{ str_pad($b->id, 5, '0', STR_PAD_LEFT) }}</a>
                            </td>
                            <td class="px-6 py-5 text-sm font-bold text-slate-700">{{ $b->customer_name }}</td>
                            <td class="px-6 py-5 text-sm font-bold text-slate-700">{{ $b->tour->name ?? 'Safari' }}</td>
                            <td class="px-6 py-5">
                                <span class="inline-flex px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-[0.2em] border {{ $pClass }}">{{ $p }}</span>
                            </td>
                            <td class="px-6 py-5 text-right text-sm font-black text-slate-900">${{ number_format((float) $b->total_price, 2) }}</td>
                            <td class="px-6 py-5 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a target="_blank" href="{{ route('bookings.invoice.preview', $b->id) }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all">Preview</a>
                                    <a target="_blank" href="{{ route('bookings.invoice', $b->id) }}" class="px-4 py-2 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all">Download</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-400 font-bold">No invoices found.</td>
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
