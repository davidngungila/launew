@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 pb-20">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-all">
            <i class="ph ph-caret-left-bold"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Edit Dossier</h1>
            <p class="text-slate-500 font-medium">Update booking information and status</p>
        </div>
    </div>

    <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-10 space-y-10">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="md:col-span-2">
                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600 mb-4 px-1">Customer</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Full Name</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name', $booking->customer_name) }}" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Email Address</label>
                        <input type="email" name="customer_email" value="{{ old('customer_email', $booking->customer_email) }}" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                    </div>
                    <div class="space-y-1.5 md:col-span-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Phone Number</label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone', $booking->customer_phone) }}" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                    </div>
                </div>
            </div>

            <div class="md:col-span-2">
                <hr class="border-slate-50 mb-8">
                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600 mb-4 px-1">Trip</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Tour Package</label>
                        <select name="tour_id" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none cursor-pointer">
                            @foreach($tours as $tour)
                                <option value="{{ $tour->id }}" {{ (string) old('tour_id', $booking->tour_id) === (string) $tour->id ? 'selected' : '' }}>{{ $tour->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date', $booking->start_date ? \Carbon\Carbon::parse($booking->start_date)->format('Y-m-d') : '') }}" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Adults</label>
                        <input type="number" name="adults" min="1" value="{{ old('adults', $booking->adults) }}" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Children</label>
                        <input type="number" name="children" min="0" value="{{ old('children', $booking->children) }}" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Total Price (USD)</label>
                        <input type="number" step="0.01" name="total_price" value="{{ old('total_price', $booking->total_price) }}" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Status</label>
                        <select name="status" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none cursor-pointer">
                            @foreach(['pending','confirmed','cancelled','completed'] as $s)
                                <option value="{{ $s }}" {{ old('status', $booking->status) === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Payment Status</label>
                        <select name="payment_status" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none cursor-pointer">
                            @foreach(['unpaid','partially_paid','paid'] as $ps)
                                <option value="{{ $ps }}" {{ old('payment_status', $booking->payment_status) === $ps ? 'selected' : '' }}>{{ strtoupper($ps) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-1.5 md:col-span-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Special Requests</label>
                        <textarea name="special_requests" rows="3" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">{{ old('special_requests', $booking->special_requests) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6 flex items-center justify-end gap-4">
            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">Cancel</a>
            <button type="submit" class="px-10 py-4 bg-emerald-600 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-emerald-500/20 hover:bg-emerald-700 transition-all">Save Changes</button>
        </div>
    </form>
</div>
@endsection
