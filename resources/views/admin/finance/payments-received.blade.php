@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Payments Received</h1>
            <p class="text-slate-500 font-medium">Track successful payments from clients (Stripe / Flutterwave)</p>
        </div>
        <a href="{{ route('admin.finance.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Financial Overview</a>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex items-center justify-between">
            <h3 class="text-xl font-black text-slate-900">Recent Payments</h3>
            <a href="{{ route('admin.bookings.index') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">View bookings</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Booking</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Customer</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Method</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Reference</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @php
                        $rows = \App\Models\Booking::query()
                            ->select(['id','customer_name','payment_method','payment_reference','total_price','payment_status'])
                            ->whereIn('payment_status', ['paid','partially_paid'])
                            ->latest()
                            ->limit(25)
                            ->get();
                    @endphp

                    @forelse($rows as $b)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6 text-sm font-black text-slate-900">
                                <a class="hover:text-emerald-600" href="{{ route('admin.bookings.show', $b->id) }}">#{{ $b->id }}</a>
                            </td>
                            <td class="px-8 py-6 text-sm font-bold text-slate-700">{{ $b->customer_name }}</td>
                            <td class="px-8 py-6 text-xs font-black text-slate-500 uppercase">{{ $b->payment_method ?? 'N/A' }}</td>
                            <td class="px-8 py-6 text-xs font-mono text-slate-500">{{ $b->payment_reference ?? 'N/A' }}</td>
                            <td class="px-8 py-6 text-right text-sm font-black text-emerald-600">${{ number_format($b->total_price, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-8 py-10 text-center text-slate-400 font-bold" colspan="5">No payments recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
