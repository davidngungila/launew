@extends('layouts.public')

@section('content')
<section class="py-32 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-serif font-bold text-slate-900 mb-4">Secure Your Expedition</h1>
            <p class="text-slate-500 font-medium tracking-wide">Select your preferred payment plan to confirm your booking.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Full Payment -->
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl p-12 space-y-8 flex flex-col justify-between hover:shadow-2xl transition-all group">
                <div class="space-y-4">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
                        <i class="ph ph-shield-check"></i>
                    </div>
                    <h3 class="text-2xl font-serif font-black text-slate-900">Full Payment</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Pay the total amount now to fully secure your spot and skip any future balance invoices.</p>
                </div>
                
                <div class="pt-6 border-t border-slate-50">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Total Expedition Value</p>
                    <p class="text-4xl font-black text-slate-900">${{ number_format($booking->total_price, 2) }}</p>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('flutterwave.pay', ['id' => $booking->id, 'type' => 'full']) }}" class="w-full py-5 bg-emerald-600 text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-xl shadow-emerald-600/20 hover:bg-emerald-700 transition-all flex items-center justify-center gap-3">
                        Pay with Flutterwave <i class="ph ph-caret-right"></i>
                    </a>
                    <p class="text-[9px] text-center text-slate-400 font-bold uppercase tracking-widest">Cards, Mobile Money & Bank Transfer</p>
                </div>
            </div>

            <!-- 30% Deposit -->
            <div class="bg-slate-900 rounded-[2.5rem] border border-slate-800 shadow-xl p-12 text-white space-y-8 flex flex-col justify-between hover:shadow-2xl transition-all group">
                <div class="space-y-4">
                    <div class="w-16 h-16 rounded-2xl bg-white/10 text-emerald-400 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
                        <i class="ph ph-hash"></i>
                    </div>
                    <h3 class="text-2xl font-serif font-black">Commitment Deposit</h3>
                    <p class="text-slate-300/60 text-sm leading-relaxed">Secure your booking with a 30% initial commitment. Pay the remaining 70% 30 days before departure.</p>
                </div>

                <div class="pt-6 border-t border-white/5">
                    <p class="text-[10px] font-black uppercase text-white/40 tracking-widest mb-1">Commital Amount (30%)</p>
                    <p class="text-4xl font-black text-white">${{ number_format($booking->total_price * 0.30, 2) }}</p>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('flutterwave.pay', ['id' => $booking->id, 'type' => 'deposit']) }}" class="w-full py-5 bg-white text-slate-900 font-black text-xs uppercase tracking-widest rounded-2xl shadow-xl shadow-white/10 hover:bg-emerald-400 hover:text-white transition-all flex items-center justify-center gap-3">
                        Pay Deposit via Flutterwave <i class="ph ph-caret-right text-lg"></i>
                    </a>
                    <p class="text-[9px] text-center text-white/40 font-bold uppercase tracking-widest">Powered by Flutterwave Security</p>
                </div>
            </div>
        </div>
        
        <div class="mt-16 bg-white p-8 rounded-3xl border border-slate-100 flex flex-col md:flex-row items-center gap-8">
             <div class="flex -space-x-3">
                <img class="w-10 h-10 rounded-full border-2 border-white ring-2 ring-emerald-500/20" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?fit=crop&w=100&q=80" alt="Avatar">
                <img class="w-10 h-10 rounded-full border-2 border-white ring-2 ring-emerald-500/20" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?fit=crop&w=100&q=80" alt="Avatar">
                <img class="w-10 h-10 rounded-full border-2 border-white ring-2 ring-emerald-500/20" src="https://images.unsplash.com/photo-1599566150163-29194dcaad36?fit=crop&w=100&q=80" alt="Avatar">
            </div>
            <p class="text-sm font-medium text-slate-500">Join over <span class="text-slate-900 font-black">1,200+ clients</span> who safely booked their Tanzanian dream with LAU Paradise Adventure this year.</p>
        </div>
    </div>
</section>
@endsection
