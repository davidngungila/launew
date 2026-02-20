@extends('layouts.public')

@section('content')
<section class="py-32 bg-slate-50 min-h-screen flex items-center justify-center">
    <div class="max-w-3xl mx-auto px-6 w-full">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-serif font-black text-slate-900 mb-6">Finalize Your Expedition</h1>
            <p class="text-slate-500 font-medium tracking-wide text-lg">You are just one step away from your Tanzanian adventure.</p>
        </div>

        <!-- Full Payment Card - Focused Design -->
        <div class="bg-white rounded-[4rem] border border-slate-100 shadow-2xl p-16 space-y-12 transition-all hover:shadow-emerald-500/5 duration-700 relative overflow-hidden group">
            <!-- Background Accent -->
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-emerald-500/5 rounded-full blur-3xl group-hover:bg-emerald-500/10 transition-colors"></div>
            
            <div class="relative space-y-6 text-center">
                <div class="w-24 h-24 rounded-3xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-5xl mx-auto shadow-sm">
                    <i class="ph ph-shield-check"></i>
                </div>
                <div class="space-y-4">
                    <h3 class="text-4xl font-serif font-black text-slate-900 tracking-tight">Full Payment</h3>
                    <p class="text-slate-500 text-lg leading-relaxed max-w-xl mx-auto font-medium">
                        Pay the total amount now to fully secure your spot and skip any future balance invoices.
                    </p>
                </div>
            </div>
            
            <div class="pt-10 border-t border-slate-50 text-center">
                <p class="text-xs font-black uppercase text-slate-400 tracking-[0.3em] mb-3">Total Expedition Investment</p>
                <p class="text-6xl font-black text-slate-900 tracking-tighter">${{ number_format($booking->total_price, 2) }}</p>
            </div>

            <div class="space-y-6 max-w-md mx-auto">
                <a href="{{ route('flutterwave.pay', ['id' => $booking->id, 'type' => 'full']) }}" class="w-full py-6 bg-slate-900 text-white font-black text-sm uppercase tracking-[0.2em] rounded-[2rem] shadow-2xl shadow-slate-900/20 hover:bg-emerald-600 transition-all flex items-center justify-center gap-4 group">
                    Pay with Flutterwave 
                    <i class="ph ph-arrow-right text-lg group-hover:translate-x-2 transition-transform"></i>
                </a>
                <div class="flex flex-col items-center gap-4">
                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Cards, Mobile Money & Bank Transfer</p>
                    <div class="flex gap-6 opacity-30 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-500">
                        <i class="ph ph-credit-card text-3xl"></i>
                        <i class="ph ph-device-mobile text-3xl"></i>
                        <i class="ph ph-bank text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-16 bg-white/50 backdrop-blur-sm p-8 rounded-[3rem] border border-white flex flex-col md:flex-row items-center justify-center gap-8 shadow-sm">
             <div class="flex -space-x-4">
                <img class="w-12 h-12 rounded-full border-4 border-white ring-2 ring-emerald-500/10" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?fit=crop&w=100&q=80" alt="Avatar">
                <img class="w-12 h-12 rounded-full border-4 border-white ring-2 ring-emerald-500/10" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?fit=crop&w=100&q=80" alt="Avatar">
                <img class="w-12 h-12 rounded-full border-4 border-white ring-2 ring-emerald-500/10" src="https://images.unsplash.com/photo-1599566150163-29194dcaad36?fit=crop&w=100&q=80" alt="Avatar">
            </div>
            <p class="text-sm font-bold text-slate-500">Join <span class="text-slate-900 font-black">1,200+ global travelers</span> who booked safely this season.</p>
        </div>
    </div>
</section>
@endsection
