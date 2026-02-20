@extends('layouts.public')

@section('content')
<div class="pt-24">
    <!-- Hero Section -->
    <section class="relative h-[50vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" 
                 class="w-full h-full object-cover" alt="Safari Consultation">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[1px]"></div>
        </div>
        <div class="relative z-10 text-center px-6">
            <h1 class="text-5xl md:text-7xl font-serif font-black text-white mb-6 border-move">Contact Our <span class="text-emerald-400 italic">Specialists</span></h1>
            <p class="text-lg text-emerald-50/70 max-w-2xl mx-auto">Skip the generic forms. Tell us what you dream of seeing, and we'll build the map.</p>
        </div>
    </section>

    <!-- Main Contact Area -->
    <section class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
                <!-- Contact Info Panel -->
                <div class="lg:col-span-5 space-y-12">
                    <div>
                        <h4 class="text-emerald-600 font-black text-xs uppercase tracking-[0.3em] mb-4">Direct Access</h4>
                        <h2 class="text-4xl font-serif font-black text-slate-900 leading-tight">We are always just <br> a message away.</h2>
                    </div>

                    <div class="grid gap-8">
                        @foreach([
                            ['label' => 'Primary Support', 'val' => '+255 683 163 219', 'icon' => 'phone-call', 'sub' => 'WhatsApp Available 24/7'],
                            ['label' => 'Official Email', 'val' => 'lauparadiseadventure@gmail.com', 'icon' => 'envelope-simple', 'sub' => 'Response within 4 hours'],
                            ['label' => 'Base Office', 'val' => 'Moshi, Tanzania', 'icon' => 'map-pin-line', 'sub' => 'Foothills of Kilimanjaro']
                        ] as $item)
                        <div class="flex items-start gap-6 group">
                            <div class="w-14 h-14 rounded-2xl bg-slate-50 text-slate-400 flex items-center justify-center text-2xl group-hover:bg-emerald-600 group-hover:text-white group-hover:shadow-xl group-hover:shadow-emerald-500/20 transition-all duration-500">
                                <i class="ph ph-{{ $item['icon'] }}"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ $item['label'] }}</p>
                                <h4 class="text-lg font-black text-slate-900 mb-1">{{ $item['val'] }}</h4>
                                <p class="text-xs font-bold text-slate-400">{{ $item['sub'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Social proof card -->
                    <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white relative overflow-hidden group">
                        <div class="absolute -right-10 -bottom-10 opacity-10 group-hover:scale-125 transition-transform duration-1000 rotate-12">
                            <i class="ph ph-chat-circle-dots text-[10rem]"></i>
                        </div>
                        <h4 class="text-xl font-bold mb-4 relative z-10 font-serif">Plan with a Human, <br> Not an Algorithm.</h4>
                        <p class="text-slate-400 text-sm leading-relaxed mb-8 relative z-10">Our specialists have lived in Tanzania their entire lives. We know the secret spots that don't show up on maps.</p>
                        <a href="https://wa.me/255683163219" class="px-6 py-3 bg-emerald-500 text-white font-black text-[10px] uppercase tracking-widest rounded-xl inline-block hover:bg-emerald-400 transition-all relative z-10">Connect Instantly</a>
                    </div>
                </div>

                <!-- Inquiry Form -->
                <div class="lg:col-span-7">
                    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl p-10 md:p-16 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-8 opacity-5">
                            <i class="ph ph-pencil-line text-8xl"></i>
                        </div>
                        
                        <div class="relative z-10">
                            <div class="mb-12">
                                <h3 class="text-3xl font-serif font-black text-slate-900 mb-2">Build Your Itinerary</h3>
                                <p class="text-slate-400 font-medium text-sm tracking-tight">Our team will respond with a tailored quote within 24 hours.</p>
                            </div>

                            <form class="space-y-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-3">
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Full Name</label>
                                        <input type="text" placeholder="Johnathan Doe" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all placeholder:text-slate-300">
                                    </div>
                                    <div class="space-y-3">
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Email Connection</label>
                                        <input type="email" placeholder="john@example.com" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all placeholder:text-slate-300">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-3">
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Trip Type</label>
                                        <select class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                                            <option>Family Safari</option>
                                            <option>Luxury Honeymoon</option>
                                            <option>Kilimanjaro Trek</option>
                                            <option>Custom Wildlife Tour</option>
                                        </select>
                                    </div>
                                    <div class="space-y-3">
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Travel Duration</label>
                                        <div class="relative">
                                            <input type="text" placeholder="e.g. 10 Days" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all placeholder:text-slate-300">
                                            <span class="absolute right-6 top-1/2 -translate-y-1/2 text-slate-300"><i class="ph ph-calendar-blank"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Personal Requests & Dreams</label>
                                    <textarea rows="5" placeholder="Tell us about the animals you want to see or specific lodges you've heard about..." class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all placeholder:text-slate-300"></textarea>
                                </div>

                                <button type="submit" class="w-full py-6 bg-emerald-600 text-white font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-2xl shadow-emerald-600/20 hover:bg-emerald-700 hover:scale-[1.02] transition-all duration-300">
                                    Request Bespoke Quote
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="h-[600px] w-full bg-slate-100 relative overflow-hidden group">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127521.16854585189!2d37.26257540510862!3d-3.342130767073356!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1837000d11f99c67%3A0x685519f074d2836!2sMoshi%2C%20Tanzania!5e0!3m2!1sen!2s!4v1700000000000!5m2!1sen!2s" 
            class="w-full h-full border-0 grayscale hover:grayscale-0 transition-all duration-1000" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
        
        <!-- Interactive Overlay -->
        <div class="absolute inset-x-6 top-10 flex justify-between items-start pointer-events-none">
            <div class="bg-white/90 backdrop-blur-xl p-8 rounded-[2rem] shadow-2xl border border-white/50 pointer-events-auto max-w-sm transition-all duration-500 group-hover:translate-x-2">
                <h4 class="text-2xl font-black text-slate-900 mb-1">Moshi, Tanzania</h4>
                <p class="text-emerald-600 font-bold text-sm mb-4">Visit our base camp</p>
                <p class="text-slate-500 text-xs leading-relaxed mb-6">Located at the foothills of Mount Kilimanjaro, our headquarters is the starting point for all our epic adventures.</p>
                <a href="https://maps.app.goo.gl/moshi-tanzania" target="_blank" class="inline-flex items-center gap-2 text-slate-900 font-black text-[10px] uppercase tracking-widest hover:text-emerald-600 transition-colors">
                    <i class="ph ph-map-trifold text-lg"></i>
                    View Moshi Map
                </a>
            </div>
        </div>

        <a href="https://maps.app.goo.gl/moshi-tanzania" target="_blank" class="absolute bottom-10 right-10 bg-slate-900 text-white px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-[0.3em] shadow-2xl shadow-slate-900/40 hover:bg-emerald-600 hover:scale-105 transition-all opacity-0 group-hover:opacity-100 duration-500">
            Open in Google Maps
        </a>
    </section>
</div>
@endsection
