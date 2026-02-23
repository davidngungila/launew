@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Generated Invoices</h1>
            <p class="text-slate-500 font-medium">Download invoices/vouchers for bookings</p>
        </div>
        <a href="{{ route('admin.finance.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Financial Overview</a>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex items-center justify-between">
            <h3 class="text-xl font-black text-slate-900">Latest Bookings</h3>
            <p class="text-xs font-bold text-slate-500">Use Voucher PDF to download</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Booking</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Customer</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @php
                        $rows = \App\Models\Booking::query()
                            ->select(['id','customer_name','payment_status','created_at'])
                            ->latest()
                            ->limit(25)
                            ->get();
                    @endphp

                    @forelse($rows as $b)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6 text-sm font-black text-slate-900">#{{ $b->id }}</td>
                            <td class="px-8 py-6 text-sm font-bold text-slate-700">{{ $b->customer_name }}</td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-slate-100 text-slate-600">{{ $b->payment_status ?? 'N/A' }}</span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a target="_blank" href="{{ route('bookings.invoice.preview', $b->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-slate-50 transition-all">
                                        <i class="ph ph-eye"></i>
                                        Preview
                                    </a>
                                    <a target="_blank" href="{{ route('bookings.invoice', $b->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-slate-800 transition-all">
                                        <i class="ph ph-download-simple"></i>
                                        Download
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-8 py-10 text-center text-slate-400 font-bold" colspan="4">No bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
