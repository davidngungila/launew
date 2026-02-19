@extends('layouts.public')

@section('content')
<div class="py-20 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Order Summary -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">Checkout</h2>
                    <p class="text-slate-500 font-medium">Complete your reservation for {{ $booking->tour->name ?? 'Safari' }}</p>
                </div>

                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8 space-y-6">
                    <h4 class="text-xs font-black uppercase tracking-[0.2em] text-emerald-600">Order Summary</h4>
                    <div class="flex justify-between items-center pb-4 border-b border-slate-50">
                        <span class="text-sm font-bold text-slate-600">Booking ID</span>
                        <span class="text-sm font-black text-slate-900">BK-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-4 border-b border-slate-50">
                        <span class="text-sm font-bold text-slate-600">Tourists</span>
                        <span class="text-sm font-black text-slate-900">{{ $booking->adults }} Adults</span>
                    </div>
                    <div class="flex justify-between items-center text-xl pt-4">
                        <span class="font-black text-slate-900 uppercase tracking-tighter">Total Price</span>
                        <span class="font-black text-emerald-600">${{ number_format($booking->total_price, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Options -->
            <div class="bg-white rounded-[3rem] border border-slate-100 shadow-xl p-10 space-y-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" class="h-6 opacity-20">
                </div>

                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Select Payment Plan</h4>
                
                <div class="space-y-4">
                    <!-- Option: Full Payment -->
                    <a href="{{ route('checkout', ['id' => $booking->id, 'type' => 'full']) }}" class="block p-6 border-2 border-slate-100 rounded-[2rem] hover:border-emerald-500 hover:bg-emerald-50/50 transition-all group">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-black text-slate-900">Full Payment</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Pay 100% now to lock in your trip</p>
                            </div>
                            <p class="text-lg font-black text-emerald-600">${{ number_format($booking->total_price, 2) }}</p>
                        </div>
                    </a>

                    <!-- Option: 30% Deposit -->
                    <a href="{{ route('checkout', ['id' => $booking->id, 'type' => 'deposit']) }}" class="block p-6 border-2 border-slate-100 rounded-[2rem] hover:border-emerald-500 hover:bg-emerald-50/50 transition-all group">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-black text-slate-900">Pay Deposit Only</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Secure your spot with 30% down</p>
                            </div>
                            <p class="text-lg font-black text-emerald-600">${{ number_format($booking->total_price * 0.30, 2) }}</p>
                        </div>
                    </a>
                </div>

                <div class="pt-6 border-t border-slate-50">
                    <p class="text-[10px] text-slate-400 text-center font-bold uppercase tracking-widest flex items-center justify-center gap-2">
                        <i class="ph ph-shield-check text-emerald-500"></i> Secure Redirect to Stripe Checkout
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
