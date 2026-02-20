@extends('layouts.public')

@section('content')
<div class="min-h-screen bg-slate-950 flex items-center justify-center relative overflow-hidden" x-data="{ 
        step: 0,
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
                });
        },
        checkAndRedirect() {
            if (this.step >= this.steps.length - 1 && this.paymentLink) {
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
    <div class="max-w-2xl w-full px-6 relative z-10">
        
        <!-- Processing State -->
        <div x-show="status === 'processing'" x-transition:enter="transition ease-out duration-500" class="space-y-12">
            <div class="text-center">
                <div class="relative inline-block mb-8">
                    <div class="w-24 h-24 bg-emerald-500/10 rounded-[2rem] border border-emerald-500/30 flex items-center justify-center animate-bounce duration-[2000ms]">
                        <i class="ph ph-shield-check text-5xl text-emerald-500"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-emerald-500 rounded-full border-4 border-slate-950 animate-ping"></div>
                </div>
                <h1 class="text-3xl md:text-4xl font-serif font-black text-white mb-4">Secure Gateway Encryption</h1>
                <p class="text-slate-500 text-xs font-black uppercase tracking-[0.4em]">Transaction Phase: Active</p>
            </div>

            <!-- The "Slash" Progress List -->
            <div class="relative bg-white/5 backdrop-blur-3xl border border-white/10 p-12 rounded-[3.5rem] shadow-2xl overflow-hidden">
                <!-- Vertical Slash Line -->
                <div class="absolute left-[3.35rem] top-20 bottom-20 w-px bg-gradient-to-b from-emerald-500/80 via-slate-700 to-slate-900"></div>

                <div class="relative space-y-12">
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
        </div>

        <!-- Error State (Full Arranged Page) -->
        <div x-show="status === 'error'" x-transition:enter="transition ease-out duration-700 delay-200" class="text-center space-y-10 animate-in zoom-in slide-in-from-bottom-8 duration-700">
            <div class="inline-flex items-center justify-center w-32 h-32 bg-rose-500/10 rounded-[3rem] border border-rose-500/20 mb-6 group">
                <i class="ph ph-warning-octagon text-6xl text-rose-500 group-hover:rotate-12 transition-transform"></i>
            </div>
            
            <div class="space-y-4">
                <h2 class="text-4xl font-serif font-black text-white">System Handshake Interrupted</h2>
                <p class="text-slate-400 max-w-md mx-auto leading-relaxed">
                    We encountered a technical delay while connecting to the Flutterwave gateway. This is often temporary.
                </p>
                <div class="bg-rose-500/5 border border-rose-500/10 p-4 rounded-2xl max-w-sm mx-auto">
                    <p class="text-[10px] font-bold text-rose-400 uppercase tracking-widest leading-none mb-1">Error Signal</p>
                    <p class="text-xs text-rose-300 font-mono" x-text="errorMessage"></p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-6 pt-10">
                <button @click="status = 'processing'; init()" class="group flex items-center gap-3 px-10 py-5 bg-white text-slate-900 font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-emerald-400 hover:text-white transition-all shadow-xl shadow-white/5">
                    <i class="ph ph-arrow-counter-clockwise font-black group-hover:rotate-180 transition-transform duration-700"></i> Attempt Reconnection
                </button>
                <a href="{{ route('bookings.checkout', $booking->id) }}" class="px-10 py-5 bg-white/5 border border-white/10 text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-white/10 transition-all">
                    Change Payment Method
                </a>
            </div>

            <div class="pt-12 text-slate-600 text-[10px] font-black uppercase tracking-[0.3em] flex items-center justify-center gap-4">
                <span class="w-12 h-px bg-slate-800"></span>
                Protocol Security: Active
                <span class="w-12 h-px bg-slate-800"></span>
            </div>
        </div>

        <!-- Support Info -->
        <div class="mt-16 bg-white/5 backdrop-blur-xl border border-white/10 p-8 rounded-[2.5rem] flex flex-col md:flex-row items-center justify-between gap-6" x-show="status === 'processing'">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full border-2 border-emerald-500/30 overflow-hidden">
                    <img src="https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766237623/w4f02zqo47s1wfsujsce.jpg" class="w-full h-full object-cover">
                </div>
                <div>
                    <p class="text-xs font-black text-white">Live Support Monitoring</p>
                    <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-widest">Managing Director Active</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <i class="ph ph-shield-check-fill text-2xl text-emerald-500 opacity-50"></i>
                <i class="ph ph-lock-key-fill text-2xl text-slate-500 opacity-50"></i>
                <span class="px-3 py-1 bg-slate-800 text-slate-400 text-[9px] font-black rounded-lg">PCI-DSS COMPLIANT</span>
            </div>
        </div>
    </div>
</div>
@endsection
