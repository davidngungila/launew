@extends('layouts.public')

@section('content')
<section class="py-32 bg-slate-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-serif font-black text-slate-900 mb-6">Finalize Your Expedition</h1>
            <p class="text-slate-500 font-medium tracking-wide text-lg">Confirm your details and proceed to secure booking.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
            <!-- Left: Full Booking Details -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-[3rem] border border-slate-100 shadow-xl p-12 overflow-hidden relative group">
                    <div class="absolute top-0 right-0 p-8 opacity-5 group-hover:opacity-10 transition-opacity">
                        <i class="ph ph-article text-9xl"></i>
                    </div>
                    
                    <h2 class="text-3xl font-serif font-black text-slate-900 mb-10 flex items-center gap-4">
                        <span class="w-12 h-1 bg-emerald-500 rounded-full"></span>
                        Full Booking Details
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        <div class="space-y-6">
                            <div class="space-y-1">
                                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Selected Expedition</p>
                                <p class="text-xl font-bold text-slate-900">{{ $booking->tour->name }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Departure Date</p>
                                <p class="text-xl font-bold text-emerald-600">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M, Y') }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Participants</p>
                                <p class="text-xl font-bold text-slate-900">{{ $booking->adults }} Adults, {{ $booking->children }} Children</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-1">
                                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Primary Contact</p>
                                <p class="text-xl font-bold text-slate-900">{{ $booking->customer_name }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Email Address</p>
                                <p class="text-xl font-bold text-slate-900">{{ $booking->customer_email }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Phone Number</p>
                                <p class="text-xl font-bold text-slate-900">{{ $booking->customer_phone }}</p>
                            </div>
                        </div>
                    </div>

                    @if($booking->special_requests)
                    <div class="mt-12 pt-8 border-t border-slate-50">
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-3">Special Instructions</p>
                        <p class="text-slate-600 italic leading-relaxed">"{{ $booking->special_requests }}"</p>
                    </div>
                    @endif

                    <div class="mt-12 flex flex-wrap gap-4">
                        <a href="{{ route('bookings.invoice.preview', $booking->id) }}" target="_blank" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-slate-900 font-black text-xs uppercase tracking-widest rounded-2xl border border-slate-100 hover:bg-slate-50 transition-all">
                            <i class="ph ph-eye text-xl text-emerald-600"></i> Preview Proforma PDF
                        </a>
                        <a href="{{ route('bookings.invoice', $booking->id) }}" class="inline-flex items-center gap-3 px-8 py-4 bg-slate-50 text-slate-900 font-black text-xs uppercase tracking-widest rounded-2xl border border-slate-100 hover:bg-slate-100 transition-all">
                            <i class="ph ph-file-pdf text-xl text-rose-500"></i> Export Proforma PDF
                        </a>
                    </div>
                </div>

                <!-- Reassurance -->
                <div class="bg-emerald-600 rounded-[2.5rem] p-10 text-white flex items-center gap-8">
                    <div class="w-20 h-20 rounded-2xl bg-white/10 flex items-center justify-center text-4xl shrink-0">
                        <i class="ph ph-shield-check"></i>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold mb-2">Tanzania Secure Gateway</h4>
                        <p class="text-emerald-100 text-sm leading-relaxed opacity-80">Your payment is processed through encrypted channels compliant with Tanzania Central Bank regulations. We support all local mobile money networks.</p>
                    </div>
                </div>
            </div>

            <!-- Right: Payment Summary -->
            <div class="space-y-8 sticky top-32">
                <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl p-12 space-y-10 group overflow-hidden">
                    <div class="text-center">
                        <p class="text-xs font-black uppercase text-slate-400 tracking-[0.3em] mb-4">Total Investment</p>
                        <div class="relative inline-block">
                            <p class="text-6xl font-black text-slate-900 tracking-tighter">${{ number_format($booking->total_price, 2) }}</p>
                            <div class="absolute -bottom-2 left-0 w-full h-1.5 bg-emerald-500/20 rounded-full"></div>
                        </div>
                    </div>

                    <div class="space-y-4 pt-10 border-t border-slate-50">
                        <div class="flex justify-between items-center text-sm font-bold">
                            <span class="text-slate-400 uppercase tracking-widest text-[10px]">Expedition Fee</span>
                            <span class="text-slate-900">${{ number_format($booking->total_price, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm font-bold">
                            <span class="text-slate-400 uppercase tracking-widest text-[10px]">Processing</span>
                            <span class="text-emerald-600">INCLUDED</span>
                        </div>
                        <div class="flex justify-between items-center text-sm font-bold">
                            <span class="text-slate-400 uppercase tracking-widest text-[10px]">VAT (Tanzania)</span>
                            <span class="text-slate-900">$0.00</span>
                        </div>
                    </div>

                    <div class="pt-6">
                        <div class="space-y-3">
                            <a href="{{ route('flutterwave.pay', ['id' => $booking->id, 'type' => 'deposit']) }}" class="w-full py-5 bg-white border-2 border-emerald-200 text-emerald-700 font-black text-xs uppercase tracking-[0.2em] rounded-[2rem] hover:bg-emerald-50 transition-all flex items-center justify-center gap-4 group">
                                Pay 30% Deposit (${{ number_format(($booking->deposit_amount ?? ($booking->total_price * 0.30)), 2) }})
                                <i class="ph ph-arrow-right text-lg group-hover:translate-x-2 transition-transform"></i>
                            </a>
                            <a href="{{ route('flutterwave.pay', ['id' => $booking->id, 'type' => 'full']) }}" class="w-full py-6 bg-slate-900 text-white font-black text-sm uppercase tracking-[0.2em] rounded-[2rem] shadow-2xl shadow-slate-900/40 hover:bg-emerald-600 transition-all flex items-center justify-center gap-4 group">
                                Pay Full Amount (${{ number_format($booking->total_price, 2) }})
                                <i class="ph ph-arrow-right text-lg group-hover:translate-x-2 transition-transform"></i>
                            </a>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-6">
                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.4em]">Integrated Secure Channels</p>
                        <div class="flex gap-8 items-center bg-slate-50 px-8 py-4 rounded-full">
                            <i class="ph ph-credit-card text-3xl text-slate-400"></i>
                            <i class="ph ph-device-mobile text-3xl text-slate-400"></i>
                            <i class="ph ph-bank text-3xl text-slate-400"></i>
                        </div>
                    </div>
                </div>

                <div class="text-center space-y-4 text-slate-400">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em]">Partnered with</p>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/1/1a/Flutterwave_Logo.png" class="h-6 mx-auto opacity-30 grayscale invert" alt="Flutterwave">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
