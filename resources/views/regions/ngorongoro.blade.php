@extends('layouts.public')

@section('content')
<section class="relative pt-48 pb-32 overflow-hidden bg-slate-900">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&w=2000&q=80" alt="Ngorongoro Conservation Area" class="w-full h-full object-cover blur-sm opacity-40">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900 to-slate-900"></div>
    </div>
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <span class="inline-block px-4 py-1.5 bg-emerald-600/20 text-emerald-400 rounded-full text-xs font-bold tracking-widest uppercase mb-6 border border-emerald-600/30">Ngorongoro</span>
        <h1 class="text-5xl md:text-7xl font-serif text-white mb-8 font-bold">UNESCO World Heritage <br> <span class="text-emerald-500">Wildlife in One Day</span></h1>
        <p class="text-xl text-slate-300 max-w-3xl mx-auto leading-relaxed">The Ngorongoro Conservation Area is a unique natural wonder built around the world’s largest intact volcanic caldera.</p>
    </div>
</section>

<section class="py-32 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            <div class="lg:col-span-7">
                <h2 class="text-4xl md:text-5xl font-serif text-slate-900 font-bold mb-8 italic">Ngorongoro Conservation Area</h2>
                <div class="prose prose-lg max-w-none text-slate-600">
                    <p class="text-xl leading-relaxed">The Ngorongoro Conservation Area is a unique natural wonder and a UNESCO World Heritage Site. It is home to the Ngorongoro Crater — the world’s largest intact volcanic caldera.</p>
                    <p class="text-xl leading-relaxed">Inside the crater, visitors can see an extraordinary concentration of wildlife in a relatively small area, including endangered black rhinos.</p>
                    <p class="text-xl leading-relaxed">It is one of the best places in Africa for guaranteed wildlife sightings in a single day.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-14">
                    <div class="bg-emerald-50 p-8 rounded-3xl border border-emerald-100">
                        <h4 class="text-emerald-700 font-bold mb-4 flex items-center gap-2 italic"><i class="ph ph-shield-check text-2xl"></i> Why it’s special</h4>
                        <ul class="space-y-3 text-emerald-800 font-medium">
                            <li>High wildlife density</li>
                            <li>Excellent for one-day safaris</li>
                            <li>Chance to spot black rhino</li>
                        </ul>
                    </div>
                    <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100">
                        <h4 class="text-slate-800 font-bold mb-4 flex items-center gap-2 italic"><i class="ph ph-camera text-2xl"></i> Ideal for</h4>
                        <ul class="space-y-3 text-slate-600 font-medium">
                            <li>First-time safari travelers</li>
                            <li>Family-friendly trips</li>
                            <li>Photography & landscape lovers</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="bg-slate-950 text-white rounded-[3.5rem] overflow-hidden p-12 relative">
                    <div class="absolute inset-0 opacity-30">
                        <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=1200&q=80" alt="Ngorongoro" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                    <div class="relative z-10">
                        <span class="text-emerald-500 font-black text-xs uppercase tracking-[0.4em] mb-6 block">Plan your safari</span>
                        <h3 class="text-3xl font-serif font-bold mb-6 italic">Explore Ngorongoro packages</h3>
                        <p class="text-slate-300 mb-10 leading-relaxed font-medium">Browse tours that include Ngorongoro Crater and match your schedule and comfort level.</p>
                        <a href="{{ route('tours.index', ['destination' => 'Ngorongoro']) }}" class="inline-flex items-center gap-3 px-10 py-4 bg-emerald-600 rounded-full font-bold shadow-xl shadow-emerald-600/30 hover:bg-emerald-700 transition-all">View Tours <i class="ph-bold ph-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
