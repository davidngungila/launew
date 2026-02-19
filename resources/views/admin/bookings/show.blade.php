@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 pb-20">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.bookings.index') }}" class="w-12 h-12 bg-white border border-slate-100 text-slate-400 rounded-2xl flex items-center justify-center hover:bg-slate-50 transition-all">
                <i class="ph ph-caret-left-bold"></i>
            </a>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Booking Details</h1>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600 mt-1">BK-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }} • {{ $booking->customer_name }}</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
             <button class="px-6 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-2xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                <i class="ph ph-printer"></i>
                Print Voucher
            </button>
            <button class="px-6 py-3 bg-emerald-600 text-white font-bold rounded-2xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <i class="ph ph-pencil"></i>
                Edit Booking
            </button>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left: Details -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden p-10">
                <h4 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-8">Reservation Overview</h4>
                
                <div class="grid grid-cols-2 gap-y-10">
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tour Package</p>
                        <p class="text-lg font-black text-slate-900">{{ $booking->tour->name ?? 'Custom Package' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Start Date</p>
                        <p class="text-lg font-black text-slate-900">{{ date('M d, Y', strtotime($booking->start_date)) }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Client Contact</p>
                        <p class="text-sm font-bold text-slate-900">{{ $booking->customer_email }}</p>
                        <p class="text-xs text-slate-500">{{ $booking->customer_phone }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Group Size</p>
                        <p class="text-lg font-black text-slate-900">{{ $booking->adults }} Adults {{ $booking->children > 0 ? ', ' . $booking->children . ' Children' : '' }}</p>
                    </div>
                </div>

                @if($booking->special_requests)
                <div class="mt-10 p-6 bg-slate-50 rounded-2xl border border-slate-100 italic text-slate-600 text-sm">
                    "{{ $booking->special_requests }}"
                </div>
                @endif
            </div>

            <!-- Team & Logistics -->
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-10">
                <h4 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-8">Logistics & Crew</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <i class="ph ph-identification-card text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Guide</p>
                            <p class="text-sm font-black text-slate-900">{{ $booking->guide->name ?? 'Not Assigned' }}</p>
                        </div>
                    </div>
                     <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i class="ph ph-steering-wheel text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Driver</p>
                            <p class="text-sm font-black text-slate-900">{{ $booking->driver->name ?? 'Not Assigned' }}</p>
                        </div>
                    </div>
                     <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center">
                            <i class="ph ph-jeep text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Vehicle</p>
                            <p class="text-sm font-black text-slate-900">{{ $booking->vehicle->plate_number ?? 'Not Assigned' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Status & Payment -->
        <div class="space-y-8">
            <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-white/40 mb-2">Total Amount</p>
                <h2 class="text-4xl font-black mb-10">${{ number_format($booking->total_price, 2) }}</h2>
                
                <div class="space-y-6">
                    <div class="flex justify-between items-center text-xs">
                        <span class="font-bold text-white/60 uppercase">Status</span>
                        <span class="px-3 py-1 bg-emerald-500 text-white font-black rounded-lg uppercase tracking-widest text-[9px]">{{ $booking->status }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="font-bold text-white/60 uppercase">Payment</span>
                        <span class="font-black text-emerald-400 uppercase">{{ $booking->payment_status }}</span>
                    </div>
                    <div class="pt-4">
                        <div class="w-full h-2 bg-white/10 rounded-full overflow-hidden">
                             <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $booking->payment_status === 'paid' ? '100%' : '30%' }}%"></div>
                        </div>
                         <p class="text-[9px] font-black text-white/40 mt-3 uppercase tracking-widest">Payment Reference: {{ $booking->payment_reference ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                    <i class="ph ph-envelope-simple text-2xl"></i>
                </div>
                <h5 class="text-sm font-black text-slate-900 mb-2">Communication Logs</h5>
                <p class="text-xs text-slate-400 font-medium mb-6 leading-relaxed">View all emails and SMS sent to the client for this booking.</p>
                <button class="w-full py-4 bg-slate-50 text-slate-600 font-black text-[10px] uppercase tracking-widest rounded-2xl hover:bg-slate-100 transition-all">View History</button>
            </div>
        </div>
    </div>
</div>
@endsection
