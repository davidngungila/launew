@extends('layouts.public')

@section('content')
<div class="py-40 bg-slate-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-[3rem] border border-slate-100 shadow-2xl p-12 text-center space-y-8 animate-in fade-in zoom-in duration-700">
        <div class="w-24 h-24 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto shadow-inner">
            <i class="ph ph-check-circle-bold text-5xl"></i>
        </div>
        
        <div class="space-y-3">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight leading-none">Payment Received!</h2>
            <p class="text-slate-500 font-medium px-4">Thank you, <span class="text-emerald-600 font-bold">{{ $booking->customer_name ?? 'Adventurer' }}</span>. Your safari booking has been updated.</p>
        </div>

        @if($booking)
        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 space-y-2">
            <div class="flex justify-between text-xs">
                <span class="text-slate-400 font-bold uppercase tracking-widest">Booking Ref</span>
                <span class="text-slate-900 font-black">#BK-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="flex justify-between text-xs">
                <span class="text-slate-400 font-bold uppercase tracking-widest">Amount Paid</span>
                <span class="text-emerald-600 font-black">${{ number_format($booking->deposit_amount ?: $booking->total_price, 2) }}</span>
            </div>
        </div>
        @endif

        <div class="pt-4 space-y-4">
            <a href="/" class="block w-full py-4 bg-slate-900 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl hover:bg-slate-800 transition-all">Back to Home</a>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-loose">Status: <span class="text-emerald-600">Verification Complete</span></p>
        </div>
    </div>
</div>
@endsection
