@extends('layouts.public')

@section('content')
<!-- Hero Section -->
<section class="relative pt-48 pb-32 overflow-hidden bg-emerald-950">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Tanzania Group Safari" class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-gradient-to-b from-emerald-950/60 via-emerald-950 to-emerald-950"></div>
    </div>
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <span class="inline-block px-4 py-1.5 bg-emerald-500/20 text-emerald-400 rounded-full text-xs font-black tracking-[0.3em] uppercase mb-6 border border-emerald-500/30">Shared Adventures</span>
        <h1 class="text-5xl md:text-7xl font-serif text-white mb-8 font-bold italic">Tanzania Group <br> <span class="text-emerald-500">Departure Packages</span></h1>
        <p class="text-xl text-emerald-100/70 max-w-3xl mx-auto leading-relaxed font-medium">Kilimanjaro & Safari Group Departures. Share the wonder of the wild with like-minded travelers and conquer the highest peak of Africa.</p>
    </div>
</section>

<!-- Content Intro -->
<section class="py-24 bg-white relative overflow-hidden">
    <div class="max-w-5xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <h2 class="text-4xl font-serif font-bold text-slate-900 mb-8 italic">Safari and Climbing <br> Mount Kilimanjaro</h2>
                <div class="prose prose-lg text-slate-600 leading-relaxed font-medium">
                    <p>“Climbing Mount Kilimanjaro” – the highest peak of Africa is on the bucket list of most adventure enthusiasts. Climbing Kilimanjaro gives a truly unique wilderness experience as you ascend to the peak of the world’s highest free-standing mountain.</p>
                    <p>Joining a group departure is more than just a cost-effective way to travel; it's an opportunity to build lifelong friendships, share challenges, and celebrate victories together under the African sun.</p>
                </div>
                <div class="mt-10 flex flex-wrap gap-4">
                    <div class="flex items-center gap-3 bg-emerald-50 px-6 py-3 rounded-2xl border border-emerald-100">
                        <i class="ph-bold ph-users text-emerald-600 text-xl"></i>
                        <span class="text-sm font-bold text-emerald-900 uppercase tracking-widest">Connect with People</span>
                    </div>
                    <div class="flex items-center gap-3 bg-emerald-50 px-6 py-3 rounded-2xl border border-emerald-100">
                        <i class="ph-bold ph-shield-check text-emerald-600 text-xl"></i>
                        <span class="text-sm font-bold text-emerald-900 uppercase tracking-widest">Professional Guides</span>
                    </div>
                </div>
            </div>
            <div class="relative">
                <div class="rounded-[3rem] overflow-hidden shadow-2xl rotate-3 hover:rotate-0 transition-transform duration-700 aspect-[4/5]">
                    <img src="https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046350/kilimanjaro-climbing_bvcs7p.jpg" alt="Kilimanjaro Climbing Group" class="w-full h-full object-cover">
                </div>
                <div class="absolute -bottom-8 -left-8 bg-white p-8 rounded-[2rem] shadow-2xl border border-slate-50">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center text-white">
                            <i class="ph-fill ph-mountains text-2xl"></i>
                        </div>
                        <div>
                            <span class="block text-2xl font-black italic tracking-tighter text-slate-900 leading-none">5,895m</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">To the Peak</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Upcoming Departures -->
<section class="py-32 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-20">
            <span class="text-emerald-600 font-bold text-xs uppercase tracking-[0.4em] mb-4 inline-block">Scheduled Expeditions</span>
            <h2 class="text-4xl md:text-5xl font-serif text-slate-900 font-bold mb-6 italic">Featured Group Packages</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Package 1: Kilimanjaro + Safari Combo -->
            <div class="bg-white rounded-[3rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100 group flex flex-col">
                <div class="relative h-64 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-6 left-6 px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-lg">Combo Package</div>
                    <div class="absolute bottom-6 right-6 px-4 py-2 bg-white/90 backdrop-blur-md text-slate-900 rounded-xl text-xs font-black uppercase tracking-widest border border-white/20 shadow-lg">12 Days</div>
                </div>
                <div class="p-10 flex-grow flex flex-col">
                    <h3 class="text-2xl font-serif font-bold text-slate-900 mb-4 italic leading-tight">Ultimate Kilimanjaro & Classic Safari</h3>
                    <p class="text-slate-500 text-sm mb-8 leading-relaxed font-medium">An all-in-one adventure: 7 days on the Lemosho Route followed by a 5-day luxury safari in Serengeti and Ngorongoro.</p>
                    <div class="space-y-4 mb-10 mt-auto pt-6 border-t border-slate-50">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">Upcoming Date</span>
                            <span class="text-slate-900 font-black italic uppercase tracking-tighter">Sept 15, 2026</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">Price from</span>
                            <span class="text-2xl font-black text-emerald-600 italic tracking-tighter">$4,250</span>
                        </div>
                    </div>
                    <a href="/contact" class="w-full py-4 bg-slate-900 text-white text-center rounded-2xl font-bold hover:bg-emerald-600 transition-colors uppercase tracking-[0.2em] text-[11px]">Join Departure</a>
                </div>
            </div>

            <!-- Package 2: Lemosho Group Climb -->
            <div class="bg-white rounded-[3rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100 group flex flex-col">
                <div class="relative h-64 overflow-hidden">
                    <img src="https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046350/kilimanjaro-climbing_bvcs7p.jpg" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-6 left-6 px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-lg">Peak Expedition</div>
                    <div class="absolute bottom-6 right-6 px-4 py-2 bg-white/90 backdrop-blur-md text-slate-900 rounded-xl text-xs font-black uppercase tracking-widest border border-white/20 shadow-lg">8 Days</div>
                </div>
                <div class="p-10 flex-grow flex flex-col">
                    <h3 class="text-2xl font-serif font-bold text-slate-900 mb-4 italic leading-tight">Lemosho Route Group Departure</h3>
                    <p class="text-slate-500 text-sm mb-8 leading-relaxed font-medium">Specifically designed for maximum acclimatization and high success rates on Africa's most scenic route.</p>
                    <div class="space-y-4 mb-10 mt-auto pt-6 border-t border-slate-50">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">Upcoming Date</span>
                            <span class="text-slate-900 font-black italic uppercase tracking-tighter">Oct 02, 2026</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">Price from</span>
                            <span class="text-2xl font-black text-emerald-600 italic tracking-tighter">$2,895</span>
                        </div>
                    </div>
                    <a href="/contact" class="w-full py-4 bg-slate-900 text-white text-center rounded-2xl font-bold hover:bg-emerald-600 transition-colors uppercase tracking-[0.2em] text-[11px]">Join Departure</a>
                </div>
            </div>

            <!-- Package 3: Great Migration Safari -->
            <div class="bg-white rounded-[3rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100 group flex flex-col">
                <div class="relative h-64 overflow-hidden">
                    <img src="https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766042771/8-Days-Tanzania-holiday-Wildebeest-migration-1536x1018_gyndkw.jpg" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-6 left-6 px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-lg">Wildlife Safari</div>
                    <div class="absolute bottom-6 right-6 px-4 py-2 bg-white/90 backdrop-blur-md text-slate-900 rounded-xl text-xs font-black uppercase tracking-widest border border-white/20 shadow-lg">6 Days</div>
                </div>
                <div class="p-10 flex-grow flex flex-col">
                    <h3 class="text-2xl font-serif font-bold text-slate-900 mb-4 italic leading-tight">Migration Shared Safari Expedition</h3>
                    <p class="text-slate-500 text-sm mb-8 leading-relaxed font-medium">Join our shared group to witness the spectacular Wildebeest Migration across the Serengeti plains.</p>
                    <div class="space-y-4 mb-10 mt-auto pt-6 border-t border-slate-50">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">Upcoming Date</span>
                            <span class="text-slate-900 font-black italic uppercase tracking-tighter">July 20, 2026</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">Price from</span>
                            <span class="text-2xl font-black text-emerald-600 italic tracking-tighter">$1,995</span>
                        </div>
                    </div>
                    <a href="/contact" class="w-full py-4 bg-slate-900 text-white text-center rounded-2xl font-bold hover:bg-emerald-600 transition-colors uppercase tracking-[0.2em] text-[11px]">Join Departure</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-32 bg-emerald-950 relative overflow-hidden">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-emerald-500/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
        <h2 class="text-4xl md:text-6xl font-serif text-white font-bold mb-10 italic">Ready for the Adventure <br> of a Lifetime?</h2>
        <p class="text-xl text-emerald-100/70 mb-12 leading-relaxed font-medium">Our group departures are limited to small sizes to ensure a personalized and premium experience for every traveler.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
            <a href="/contact" class="px-12 py-5 bg-emerald-600 text-white rounded-full font-bold shadow-2xl shadow-emerald-600/30 hover:bg-emerald-500 hover:scale-105 transition-all uppercase tracking-widest text-xs">Speak with an Expert</a>
            <a href="/tours" class="px-12 py-5 bg-white text-emerald-950 rounded-full font-bold hover:bg-emerald-50 hover:scale-105 transition-all uppercase tracking-widest text-xs">View All Tours</a>
        </div>
    </div>
</section>
@endsection
