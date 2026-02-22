@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 pb-20">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.bookings.index') }}" class="w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-all">
            <i class="ph ph-caret-left-bold"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Manual Booking</h1>
            <p class="text-slate-500 font-medium">Create a new reservation manually in the system</p>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.bookings.store') }}" method="POST" class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-10 space-y-8">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Client Info -->
            <div class="col-span-1 md:col-span-2">
                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600 mb-4 px-1">Customer Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Full Name</label>
                        <input type="text" name="customer_name" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Email Address</label>
                        <input type="email" name="customer_email" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                    </div>
                    <div class="space-y-1.5 md:col-span-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Phone Number</label>
                        <input type="text" name="customer_phone" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                    </div>
                </div>
            </div>

            <!-- Trip Info -->
            <div class="col-span-1 md:col-span-2">
                <hr class="border-slate-50 mb-8">
                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600 mb-4 px-1">Trip Details</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Select Tour Package</label>
                        <select name="tour_id" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none cursor-pointer">
                            @foreach($tours as $tour)
                                <option value="{{ $tour->id }}">{{ $tour->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Start Date</label>
                        <input type="date" name="start_date" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Number of Adults</label>
                        <input type="number" name="adults" min="1" value="1" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Number of Children</label>
                        <input type="number" name="children" min="0" value="0" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Total Quotation ($)</label>
                        <input type="number" name="total_price" step="0.01" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                    </div>
                    <div class="space-y-1.5 md:col-span-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Special Requests</label>
                        <textarea name="special_requests" rows="3" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6">
            <button type="submit" class="w-full py-5 bg-emerald-600 text-white font-black text-xs uppercase tracking-[0.2em] rounded-[1.5rem] hover:bg-emerald-700 shadow-xl shadow-emerald-500/20 transition-all flex items-center justify-center gap-3">
                <i class="ph ph-check-circle-bold text-lg"></i>
                Finalize & Save Booking
            </button>
        </div>
    </form>
</div>
@endsection
