@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Revenue Reports</h1>
            <p class="text-slate-500 font-medium">Revenue summary based on bookings and payment status</p>
        </div>
        <a href="{{ route('admin.finance.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Financial Overview</a>
    </div>

    @php
        $total = \App\Models\Booking::sum('total_price');
        $paid = \App\Models\Booking::where('payment_status', 'paid')->sum('total_price');
        $partial = \App\Models\Booking::where('payment_status', 'partially_paid')->sum('total_price');
        $pending = $total - ($paid + $partial);
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-emerald-600 p-8 rounded-[2.5rem] text-white shadow-xl shadow-emerald-600/20">
            <p class="text-[10px] font-black uppercase tracking-widest text-white/70">Total Revenue</p>
            <p class="text-3xl font-black mt-2">${{ number_format($total, 2) }}</p>
        </div>
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Paid</p>
            <p class="text-3xl font-black text-slate-900 mt-2">${{ number_format($paid, 2) }}</p>
        </div>
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Partially paid</p>
            <p class="text-3xl font-black text-slate-900 mt-2">${{ number_format($partial, 2) }}</p>
        </div>
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Pending</p>
            <p class="text-3xl font-black text-slate-900 mt-2">${{ number_format($pending, 2) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex items-center justify-between">
            <h3 class="text-xl font-black text-slate-900">Latest bookings</h3>
            <a href="{{ route('admin.bookings.index') }}" class="px-5 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all">Bookings</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Booking</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Customer</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Payment status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach(\App\Models\Booking::latest()->limit(20)->get() as $b)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6 text-sm font-black text-slate-900">
                                <a class="hover:text-emerald-600" href="{{ route('admin.bookings.show', $b->id) }}">#{{ $b->id }}</a>
                            </td>
                            <td class="px-8 py-6 text-sm font-bold text-slate-700">{{ $b->customer_name }}</td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-slate-100 text-slate-600">{{ $b->payment_status ?? 'N/A' }}</span>
                            </td>
                            <td class="px-8 py-6 text-right text-sm font-black text-slate-900">${{ number_format($b->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
