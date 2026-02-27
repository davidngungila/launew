@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 pb-20">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.finance.invoices.all') }}" class="w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-all">
            <i class="ph ph-caret-left-bold"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Create Invoice</h1>
            <p class="text-slate-500 font-medium">This will be connected to full invoice lifecycle in next phase</p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-10 space-y-8">
        <div class="text-sm font-bold text-slate-600">
            For now, invoices are generated from bookings (Voucher PDF / Receipt PDF).
        </div>

        <div class="space-y-2">
            <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Select Booking</label>
            <select class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900">
                @foreach($bookings as $b)
                    <option value="{{ $b->id }}">BK-{{ str_pad($b->id, 5, '0', STR_PAD_LEFT) }} · {{ $b->customer_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a target="_blank" href="{{ route('admin.bookings.index') }}" class="px-8 py-4 bg-white border border-slate-200 text-slate-700 font-black text-xs uppercase tracking-[0.2em] rounded-2xl hover:bg-slate-50 transition-all text-center">Open Bookings List</a>
            <a target="_blank" href="{{ route('admin.finance.invoices.all') }}" class="px-8 py-4 bg-slate-900 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl hover:bg-slate-800 transition-all text-center">Go to All Invoices</a>
        </div>
    </div>
</div>
@endsection
