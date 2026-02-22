@extends('layouts.public')

@section('content')
@php
    $amount = $booking->total_price;
    if (($type ?? 'full') === 'deposit') {
        $amount = $booking->total_price * 0.30;
    }
@endphp
<div class="min-h-screen bg-slate-950 flex items-center justify-center relative overflow-hidden" x-data="{ 
        step: 0,
        percent: 0,
        percentTimer: null,
        status: 'processing', // 'processing', 'error', 'success'
        errorMessage: '',
        steps: [
            { id: 'verify', text: 'Verifying Booking #{{ $booking->id }}', delay: 800 },
            { id: 'secure', text: 'Securing Transaction Session', delay: 1200 },
            { id: 'merchant', text: 'Authenticating with Central Bank Gateway', delay: 1000 },
            { id: 'link', text: 'Generating Flutterwave Checkout Link', delay: 1500 },
            { id: 'final', text: 'Finalizing Security Handshake', delay: 800 }
        ],
        async init() {
            // Start simulation
            this.percent = 0;
            if (this.percentTimer) clearInterval(this.percentTimer);
            this.percentTimer = setInterval(() => {
                if (this.status !== 'processing') return;
                // Keep it moving but never exceed 99% until redirect moment
                this.percent = Math.min(99, this.percent + 1);
            }, 80);
            this.runSimulation();
            
            // Start actual fetch
            this.fetchPaymentLink();
        },
        async runSimulation() {
            for(let i=0; i < this.steps.length; i++) {
                if (this.status !== 'processing') break;
                this.step = i;
                await new Promise(r => setTimeout(r, this.steps[i].delay));
            }
        },
        paymentLink: null,
        fetchPaymentLink() {
            fetch('{{ route('flutterwave.get-link', ['id' => $booking->id, 'type' => $type]) }}')
                .then(async res => {
                    const data = await res.json();
                    if (res.ok && data.link) {
                        this.paymentLink = data.link;
                        // Check if simulation is already near end
                        this.checkAndRedirect();
                    } else {
                        throw new Error(data.error || 'Gateway initialization failed.');
                    }
                })
                .catch((e) => {
                    this.status = 'error';
                    this.errorMessage = e.message;
                    if (this.percentTimer) clearInterval(this.percentTimer);
                });
        },
        checkAndRedirect() {
            if (this.step >= this.steps.length - 1 && this.paymentLink) {
                // Finish the splash before redirect
                this.percent = 100;
                if (this.percentTimer) clearInterval(this.percentTimer);
                window.location.href = this.paymentLink;
            } else {
                // If link arrived early, wait for simulation to finish
                setTimeout(() => this.checkAndRedirect(), 500);
            }
        }
    }" x-init="init()">
    
    <!-- Advanced Background -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-[-20%] left-[-10%] w-[60%] h-[60%] bg-emerald-600/10 rounded-full blur-[150px] animate-pulse"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[60%] h-[60%] bg-emerald-600/5 rounded-full blur-[150px]"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-[0.03]"></div>
    </div>

    <!-- Main Container -->
    <div class="max-w-6xl w-full px-6 relative z-10">
        
        <!-- Processing State -->
        <div x-show="status === 'processing'" x-transition:enter="transition ease-out duration-500" class="space-y-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                <div class="lg:col-span-7 space-y-10">
                    <div class="text-center lg:text-left">
                        <div class="flex items-center gap-5 justify-center lg:justify-start mb-8">
                            <div class="relative inline-flex">
                                <div class="w-20 h-20 bg-emerald-500/10 rounded-[2rem] border border-emerald-500/30 flex items-center justify-center animate-bounce duration-[2000ms]">
                                    <i class="ph ph-shield-check text-4xl text-emerald-500"></i>
                                </div>
                                <div class="absolute -top-2 -right-2 w-6 h-6 bg-emerald-500 rounded-full border-4 border-slate-950 animate-ping"></div>
                            </div>
                            <div>
                                <h1 class="text-3xl md:text-4xl font-serif font-black text-white mb-2">Secure Flutterwave Checkout</h1>
                                <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.4em]">Transaction Phase: Active</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-center lg:justify-start gap-4">
                            <div class="relative w-20 h-20 rounded-[2rem] bg-white/5 border border-white/10 flex items-center justify-center overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/25 to-transparent"></div>
                                <div class="relative z-10 text-center">
                                    <div class="text-2xl font-black text-white" x-text="percent + '%'">0%</div>
                                    <div class="text-[9px] font-black uppercase tracking-[0.3em] text-slate-500">Loading</div>
                                </div>
                            </div>
                            <div class="flex-1 max-w-md">
                                <div class="h-2.5 bg-white/5 border border-white/10 rounded-full overflow-hidden">
                                    <div class="h-full bg-emerald-500 rounded-full transition-all duration-200" :style="'width:' + percent + '%'" style="width:0%"></div>
                                </div>
                                <div class="mt-2 flex items-center justify-between text-[10px] font-black uppercase tracking-[0.3em] text-slate-600">
                                    <span>Initializing</span>
                                    <span x-text="percent >= 100 ? 'Ready' : 'Working'">Working</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="relative bg-white/5 backdrop-blur-3xl border border-white/10 p-10 md:p-12 rounded-[3.5rem] shadow-2xl overflow-hidden">
                        <div class="absolute inset-0 pointer-events-none">
                            <div class="absolute -top-20 -right-24 w-72 h-72 bg-emerald-500/10 rounded-full blur-[90px]"></div>
                        </div>

                        <div class="flex items-center justify-between gap-6 mb-10">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-600">Protected by encryption</p>
                                <p class="text-white font-bold tracking-tight">Generating secure payment session</p>
                            </div>
                            <div class="flex items-center gap-3 text-slate-500">
                                <i class="ph ph-lock-key-fill text-2xl"></i>
                                <span class="px-3 py-1 bg-white/5 border border-white/10 rounded-xl text-[9px] font-black tracking-widest">PCI-DSS</span>
                            </div>
                        </div>

                        <div class="absolute left-[3.35rem] top-28 bottom-14 w-px bg-gradient-to-b from-emerald-500/80 via-slate-700 to-slate-900"></div>

                        <div class="relative space-y-10">
                            <template x-for="(s, index) in steps" :key="s.id">
                                <div class="flex items-center gap-8 transition-all duration-700" :class="step >= index ? 'opacity-100 translate-x-0' : 'opacity-10 -translate-x-8'">
                                    <div class="relative z-10 w-6 h-6 flex items-center justify-center">
                                        <div class="absolute inset-0 bg-slate-900 rounded-full border border-white/10"></div>
                                        <div x-show="step > index" class="relative z-20 text-emerald-500 animate-in zoom-in duration-300">
                                            <i class="ph-fill ph-check-circle text-xl"></i>
                                        </div>
                                        <div x-show="step === index" class="relative z-20 w-3 h-3 bg-emerald-500 rounded-full shadow-[0_0_20px_rgba(16,185,129,1)] animate-pulse"></div>
                                        <div x-show="step < index" class="relative z-20 w-1.5 h-1.5 bg-slate-700 rounded-full"></div>
                                    </div>
                                    <div class="space-y-1">
                                        <span class="text-[10px] font-black uppercase tracking-[0.3em] transition-colors duration-500" :class="step === index ? 'text-emerald-400' : 'text-slate-600'" x-text="step === index ? 'Current Phase' : (step > index ? 'Verified' : 'Scheduled')"></span>
                                        <p class="text-base font-bold tracking-wide" :class="step === index ? 'text-white' : 'text-slate-500'" x-text="s.text"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-8 rounded-[2.5rem] flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full border-2 border-emerald-500/30 overflow-hidden">
                                <img src="https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766237623/w4f02zqo47s1wfsujsce.jpg" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="text-xs font-black text-white">Support on standby</p>
                                <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-widest">We monitor failed payments</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="ph ph-shield-check-fill text-2xl text-emerald-500 opacity-50"></i>
                            <i class="ph ph-lock-key-fill text-2xl text-slate-500 opacity-50"></i>
                            <span class="px-3 py-1 bg-slate-800 text-slate-400 text-[9px] font-black rounded-lg">SECURE CHECKOUT</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl overflow-hidden">
                        <div class="p-10">
                            <div class="flex items-start justify-between gap-6 mb-10">
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400">Booking summary</p>
                                    <h2 class="text-2xl font-serif font-black text-slate-900 leading-tight">{{ $booking->tour->name ?? 'Safari Expedition' }}</h2>
                                    <p class="text-slate-500 text-sm font-bold mt-3 flex items-center gap-2"><i class="ph ph-map-pin"></i> {{ $booking->tour->location ?? 'Tanzania' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400">Payment type</p>
                                    <p class="text-sm font-black text-emerald-700">{{ (($type ?? 'full') === 'deposit') ? 'Deposit (30%)' : 'Full Payment' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-8">
                                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Start date</p>
                                    <p class="text-sm font-black text-slate-900">{{ $booking->start_date }}</p>
                                </div>
                                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Travelers</p>
                                    <p class="text-sm font-black text-slate-900">{{ $booking->adults }} Adults @if($booking->children) · {{ $booking->children }} Children @endif</p>
                                </div>
                            </div>

                            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white">
                                <div class="flex items-baseline justify-between mb-6">
                                    <div>
                                        <p class="text-[10px] font-black uppercase tracking-[0.35em] text-slate-300">Amount due</p>
                                        <p class="text-4xl font-black tracking-tight">${{ number_format($amount, 2) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] font-black uppercase tracking-[0.35em] text-slate-300">Currency</p>
                                        <p class="text-sm font-black">USD</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 text-xs font-bold text-slate-300">
                                    <div class="flex items-center gap-2"><i class="ph ph-credit-card"></i> Cards</div>
                                    <div class="flex items-center gap-2"><i class="ph ph-device-mobile"></i> Mobile Money</div>
                                    <div class="flex items-center gap-2"><i class="ph ph-bank"></i> Bank Transfer</div>
                                    <div class="flex items-center gap-2"><i class="ph ph-key"></i> Secure Redirect</div>
                                </div>
                            </div>

                            <div class="mt-8 flex flex-col sm:flex-row gap-4">
                                <a href="{{ route('bookings.checkout', $booking->id) }}" class="flex-1 px-8 py-4 bg-white border border-slate-200 text-slate-700 font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-slate-50 transition-all text-center">Back</a>
                                <a href="{{ route('contact') }}" class="flex-1 px-8 py-4 bg-emerald-600 text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-emerald-700 transition-all text-center">Need help</a>
                            </div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.35em] text-center mt-8">You will be redirected to Flutterwave to complete payment.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error State (Full Arranged Page) -->
        <div x-show="status === 'error'" x-transition:enter="transition ease-out duration-700 delay-200" class="animate-in zoom-in slide-in-from-bottom-8 duration-700">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-[3.5rem] shadow-2xl overflow-hidden">
                    <div class="p-10 md:p-14 relative">
                        <div class="absolute -top-24 -right-28 w-72 h-72 bg-rose-500/10 rounded-full blur-[90px]"></div>
                        <div class="absolute -bottom-24 -left-28 w-72 h-72 bg-emerald-500/5 rounded-full blur-[90px]"></div>

                        <div class="flex flex-col md:flex-row md:items-start gap-10 relative z-10">
                            <div class="shrink-0">
                                <div class="w-20 h-20 bg-rose-500/10 rounded-[2rem] border border-rose-500/20 flex items-center justify-center">
                                    <i class="ph ph-warning-octagon text-4xl text-rose-500"></i>
                                </div>
                            </div>

                            <div class="flex-1">
                                <p class="text-[10px] font-black uppercase tracking-[0.35em] text-rose-400 mb-4">Gateway status</p>
                                <h2 class="text-3xl md:text-4xl font-serif font-black text-white mb-4">System Handshake Interrupted</h2>
                                <p class="text-slate-400 leading-relaxed max-w-xl">
                                    We couldn’t generate your Flutterwave checkout link right now. This is usually temporary—please try again in a moment.
                                </p>

                                <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">What you can do</p>
                                        <ul class="space-y-2 text-sm text-slate-300 font-bold">
                                            <li class="flex items-center gap-2"><i class="ph ph-wifi-high text-emerald-400"></i> Check your internet connection</li>
                                            <li class="flex items-center gap-2"><i class="ph ph-clock text-emerald-400"></i> Wait 10–30 seconds and retry</li>
                                            <li class="flex items-center gap-2"><i class="ph ph-credit-card text-emerald-400"></i> Change payment method</li>
                                        </ul>
                                    </div>
                                    <div class="bg-rose-500/5 border border-rose-500/10 rounded-2xl p-6">
                                        <p class="text-[10px] font-black uppercase tracking-widest text-rose-300 mb-2">Error Signal</p>
                                        <p class="text-xs text-rose-200 font-mono break-words" x-text="errorMessage"></p>
                                    </div>
                                </div>

                                <div class="mt-10 flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                                    <button @click="status = 'processing'; init()" class="group flex-1 inline-flex items-center justify-center gap-3 px-10 py-5 bg-emerald-500 text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-emerald-400 transition-all shadow-xl shadow-emerald-500/10">
                                        <i class="ph ph-arrow-counter-clockwise font-black group-hover:rotate-180 transition-transform duration-700"></i> Try Again
                                    </button>
                                    <a href="{{ route('bookings.checkout', $booking->id) }}" class="flex-1 inline-flex items-center justify-center gap-3 px-10 py-5 bg-white/5 border border-white/10 text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-white/10 transition-all">
                                        <i class="ph ph-arrows-left-right"></i> Change Payment Method
                                    </a>
                                </div>

                                <div class="mt-10 pt-8 border-t border-white/10 flex items-center justify-between gap-6">
                                    <div class="flex items-center gap-3 text-slate-500">
                                        <i class="ph ph-shield-check-fill text-xl text-emerald-500/70"></i>
                                        <span class="text-[10px] font-black uppercase tracking-[0.35em]">Security Protocol Active</span>
                                    </div>
                                    <a href="{{ route('contact') }}" class="text-[10px] font-black uppercase tracking-[0.35em] text-emerald-400 hover:text-emerald-300 transition-colors">Contact support</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="text-center text-slate-600 text-[10px] font-black uppercase tracking-[0.3em] mt-10">No charge was made. Your booking is still reserved.</p>
            </div>
        </div>

    </div>
</div>
@endsection
