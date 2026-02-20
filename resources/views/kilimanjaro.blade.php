@extends('layouts.public')

@section('content')
<!-- Hero Section -->
<section class="relative pt-48 pb-32 overflow-hidden bg-slate-900">
    <div class="absolute inset-0 z-0">
        <img src="https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046350/kilimanjaro-climbing_bvcs7p.jpg" alt="Kilimanjaro Summit" class="w-full h-full object-cover blur-sm opacity-40">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900 to-slate-900"></div>
    </div>
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <span class="inline-block px-4 py-1.5 bg-emerald-600/20 text-emerald-400 rounded-full text-xs font-bold tracking-widest uppercase mb-6 border border-emerald-600/30">Roof of Africa</span>
        <h1 class="text-5xl md:text-7xl font-serif text-white mb-8 font-bold">Best Kilimanjaro Routes <br> <span class="text-emerald-500">for Every Climber</span></h1>
        <p class="text-xl text-slate-300 max-w-3xl mx-auto leading-relaxed">Discover the legendary paths to the summit of Mount Kilimanjaro. From the scenic Lemosho to the direct Umbwe, find your perfect ascent route.</p>
    </div>
</section>

<!-- Routes Guide -->
<section class="py-32 bg-white" x-data="{ activeRoute: 'machame' }">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            <!-- Sidebar Navigation -->
            <div class="lg:col-span-4 lg:sticky lg:top-32 h-fit">
                <div class="space-y-4">
                    <button @click="activeRoute = 'machame'" :class="activeRoute === 'machame' ? 'bg-emerald-600 text-white shadow-xl shadow-emerald-600/20' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'" class="w-full text-left p-6 rounded-3xl font-bold transition-all flex items-center justify-between group">
                        Machame Route (Whiskey)
                        <i class="ph ph-caret-right" :class="activeRoute === 'machame' ? 'opacity-100' : 'opacity-0'"></i>
                    </button>
                    <button @click="activeRoute = 'lemosho'" :class="activeRoute === 'lemosho' ? 'bg-emerald-600 text-white shadow-xl shadow-emerald-600/20' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'" class="w-full text-left p-6 rounded-3xl font-bold transition-all flex items-center justify-between group">
                        Lemosho Route
                        <i class="ph ph-caret-right" :class="activeRoute === 'lemosho' ? 'opacity-100' : 'opacity-0'"></i>
                    </button>
                    <button @click="activeRoute = 'marangu'" :class="activeRoute === 'marangu' ? 'bg-emerald-600 text-white shadow-xl shadow-emerald-600/20' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'" class="w-full text-left p-6 rounded-3xl font-bold transition-all flex items-center justify-between group">
                        Marangu Route (Coca-Cola)
                        <i class="ph ph-caret-right" :class="activeRoute === 'marangu' ? 'opacity-100' : 'opacity-0'"></i>
                    </button>
                    <button @click="activeRoute = 'rongai'" :class="activeRoute === 'rongai' ? 'bg-emerald-600 text-white shadow-xl shadow-emerald-600/20' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'" class="w-full text-left p-6 rounded-3xl font-bold transition-all flex items-center justify-between group">
                        Rongai Route
                        <i class="ph ph-caret-right" :class="activeRoute === 'rongai' ? 'opacity-100' : 'opacity-0'"></i>
                    </button>
                    <button @click="activeRoute = 'umbwe'" :class="activeRoute === 'umbwe' ? 'bg-emerald-600 text-white shadow-xl shadow-emerald-600/20' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'" class="w-full text-left p-6 rounded-3xl font-bold transition-all flex items-center justify-between group">
                        Umbwe Route
                        <i class="ph ph-caret-right" :class="activeRoute === 'umbwe' ? 'opacity-100' : 'opacity-0'"></i>
                    </button>
                    <button @click="activeRoute = 'northern'" :class="activeRoute === 'northern' ? 'bg-emerald-600 text-white shadow-xl shadow-emerald-600/20' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'" class="w-full text-left p-6 rounded-3xl font-bold transition-all flex items-center justify-between group">
                        Northern Circuit
                        <i class="ph ph-caret-right" :class="activeRoute === 'northern' ? 'opacity-100' : 'opacity-0'"></i>
                    </button>
                </div>
            </div>

            <!-- Content Area -->
            <div class="lg:col-span-8">
                <!-- Machame -->
                <div x-show="activeRoute === 'machame'" x-transition:enter="transition ease-out duration-300" class="space-y-10">
                    <div class="relative rounded-[3rem] overflow-hidden h-80">
                        <img src="https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766042771/7-DAYS-SAFARI-TANZANIA--1536x1024_d9kzfh.webp" alt="Machame" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                        <h2 class="absolute bottom-10 left-10 text-4xl font-serif text-white font-bold">Machame Route</h2>
                    </div>
                    <div class="prose prose-lg max-w-none text-slate-600">
                        <p class="text-xl leading-relaxed">Known as the <strong>'Whiskey Route,'</strong> Machame is popular for its scenic variety, traversing diverse landscapes from rainforest to alpine desert. It offers 6- or 7-day itineraries, with the longer option providing far better acclimatization.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 my-12">
                            <div class="bg-emerald-50 p-8 rounded-3xl border border-emerald-100">
                                <h4 class="text-emerald-700 font-bold mb-4 flex items-center gap-2 italic">
                                    <i class="ph ph-check-circle text-2xl"></i> Pros
                                </h4>
                                <ul class="space-y-3 text-emerald-800 font-medium">
                                    <li>Highly scenic with varied landscapes</li>
                                    <li>Good acclimatization profile on longer itineraries</li>
                                    <li>Excellent summit success rates</li>
                                </ul>
                            </div>
                            <div class="bg-orange-50 p-8 rounded-3xl border border-orange-100">
                                <h4 class="text-orange-700 font-bold mb-4 flex items-center gap-2 italic">
                                    <i class="ph ph-warning-circle text-2xl"></i> Cons
                                </h4>
                                <ul class="space-y-3 text-orange-800 font-medium">
                                    <li>Can be crowded during peak seasons</li>
                                    <li>6-day option offers less time for acclimatization</li>
                                    <li>Physically demanding days</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lemosho -->
                <div x-show="activeRoute === 'lemosho'" x-transition:enter="transition ease-out duration-300" class="space-y-10">
                    <div class="relative rounded-[3rem] overflow-hidden h-80">
                        <img src="https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766324377/7-Days-Mount-Kilimanjaro-Climb-Lemosho-Route-2.webp.bv.webp" alt="Lemosho" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                        <h2 class="absolute bottom-10 left-10 text-4xl font-serif text-white font-bold">Lemosho Route</h2>
                    </div>
                    <div class="prose prose-lg max-w-none text-slate-600">
                        <p class="text-xl leading-relaxed">Starting on the western slope, Lemosho is renowned for its panoramic views and <strong>excellent acclimatization</strong>. It offers 6- to 8-day treks, merging with the Machame route near Lava Tower.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 my-12">
                            <div class="bg-emerald-50 p-8 rounded-3xl border border-emerald-100">
                                <h4 class="text-emerald-700 font-bold mb-4 flex items-center gap-2 italic">
                                    <i class="ph ph-check-circle text-2xl"></i> Pros
                                </h4>
                                <ul class="space-y-3 text-emerald-800 font-medium">
                                    <li>Very high summit success rate due to gradual ascent</li>
                                    <li>Traverses the scenic Shira Plateau</li>
                                    <li>Avoids early crowds on the western side</li>
                                </ul>
                            </div>
                            <div class="bg-orange-50 p-8 rounded-3xl border border-orange-100">
                                <h4 class="text-orange-700 font-bold mb-4 flex items-center gap-2 italic">
                                    <i class="ph ph-warning-circle text-2xl"></i> Cons
                                </h4>
                                <ul class="space-y-3 text-orange-800 font-medium">
                                    <li>Can get busy during the high seasons</li>
                                    <li>Higher cost due to transport to trailhead</li>
                                    <li>Longer itinerary required</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Placeholder for others to avoid bloat, but implementing structured for Marangu -->
                <div x-show="activeRoute === 'marangu'" x-transition:enter="transition ease-out duration-300" class="space-y-10">
                    <div class="relative rounded-[3rem] overflow-hidden h-80">
                         <img src="https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766324379/7-days-umbwe-route-600x300.webp.bv.webp" alt="Marangu" class="w-full h-full object-cover">
                         <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                         <h2 class="absolute bottom-10 left-10 text-4xl font-serif text-white font-bold">Marangu Route</h2>
                    </div>
                    <p class="text-xl text-slate-600 leading-relaxed italic">The "Coca-Cola" route is the only path providing hut accommodation. It follows a direct ascent and descent path.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Group Climbs Calendar -->
<section class="py-32 bg-slate-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-20">
            <span class="text-emerald-600 font-black text-xs uppercase tracking-[0.4em] mb-4 inline-block">Join the Expedition</span>
            <h2 class="text-4xl md:text-5xl font-serif text-slate-900 font-bold mb-6 italic">Group Climbs: 2026–2027 Departures</h2>
        </div>

        <!-- Month Filter (Simulated) -->
        <div class="flex items-center justify-center gap-4 mb-16 overflow-x-auto pb-4 px-4 no-scrollbar">
            @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                <button class="{{ $month === 'Feb' ? 'bg-emerald-600 text-white shadow-xl shadow-emerald-600/20' : 'bg-white text-slate-500 hover:bg-slate-100' }} px-8 py-3 rounded-2xl font-bold transition-all flex border border-slate-100">
                    {{ $month }}
                </button>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Departure Card 1 -->
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100 flex flex-col group">
                <div class="flex items-start justify-between mb-8">
                    <div class="w-14 h-14 bg-emerald-600 text-white rounded-2xl flex flex-col items-center justify-center italic">
                        <span class="text-xl font-bold leading-none">21</span>
                        <span class="text-[10px] font-bold uppercase tracking-widest mt-1">Feb</span>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-slate-900">$2,575</span>
                </div>
                <h4 class="text-lg font-bold text-slate-800 mb-6 flex-grow">Kilimanjaro via Umbwe - 6 Days</h4>
                <div class="space-y-3 mb-8">
                    <div class="flex items-center gap-3 text-xs font-bold text-slate-500 uppercase tracking-widest">
                        <i class="ph ph-tree text-emerald-500 text-lg"></i> Tropical Forest
                    </div>
                    <div class="flex items-center gap-3 text-xs font-bold text-slate-500 uppercase tracking-widest">
                        <i class="ph ph-bird text-emerald-500 text-lg"></i> Forest Birds
                    </div>
                    <div class="flex items-center gap-3 text-xs font-bold text-emerald-600 uppercase tracking-widest">
                        <i class="ph ph-person-simple-hike text-lg"></i> Hard Route
                    </div>
                </div>
                <a href="/contact" class="w-full py-4 bg-slate-900 text-white text-center rounded-2xl font-bold hover:bg-emerald-600 transition-colors">Join Group</a>
            </div>

            <!-- Departure Card 2 -->
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100 flex flex-col group ring-2 ring-emerald-500 ring-offset-4 ring-offset-transparent">
                <div class="flex items-start justify-between mb-8">
                    <div class="w-14 h-14 bg-emerald-600 text-white rounded-2xl flex flex-col items-center justify-center italic">
                        <span class="text-xl font-bold leading-none">21</span>
                        <span class="text-[10px] font-bold uppercase tracking-widest mt-1">Feb</span>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-slate-900">$3,413</span>
                </div>
                <h4 class="text-lg font-bold text-slate-800 mb-6 flex-grow">Lemosho route - 8 days</h4>
                <div class="space-y-3 mb-8">
                    <div class="flex items-center gap-3 text-xs font-bold text-slate-500 uppercase tracking-widest">
                        <i class="ph ph-mountains text-emerald-500 text-lg"></i> Cathedral Point
                    </div>
                    <div class="flex items-center gap-3 text-xs font-bold text-slate-500 uppercase tracking-widest">
                        <i class="ph ph-star text-emerald-500 text-lg"></i> Extra Summit
                    </div>
                </div>
                <a href="/contact" class="w-full py-4 bg-emerald-600 text-white text-center rounded-2xl font-bold hover:bg-emerald-700 shadow-xl shadow-emerald-600/30 transition-colors">Join Group</a>
            </div>

            <!-- Departure Card 3 -->
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100 flex flex-col group">
                <div class="flex items-start justify-between mb-8">
                    <div class="w-14 h-14 bg-emerald-600 text-white rounded-2xl flex flex-col items-center justify-center italic">
                        <span class="text-xl font-bold leading-none">22</span>
                        <span class="text-[10px] font-bold uppercase tracking-widest mt-1">Feb</span>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-slate-900">$3,042</span>
                </div>
                <h4 class="text-lg font-bold text-slate-800 mb-6 flex-grow">Lemosho route - 7 days</h4>
                <div class="space-y-3 mb-8">
                    <div class="flex items-center gap-3 text-xs font-bold text-slate-500 uppercase tracking-widest">
                        <i class="ph ph-airplane-landing text-emerald-500 text-lg"></i> High Drop-Off
                    </div>
                </div>
                <a href="/contact" class="w-full py-4 bg-slate-900 text-white text-center rounded-2xl font-bold hover:bg-emerald-600 transition-colors">Join Group</a>
            </div>

            <!-- Departure Card 4 -->
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100 flex flex-col group">
                <div class="flex items-start justify-between mb-8">
                    <div class="w-14 h-14 bg-emerald-600 text-white rounded-2xl flex flex-col items-center justify-center italic">
                        <span class="text-xl font-bold leading-none">26</span>
                        <span class="text-[10px] font-bold uppercase tracking-widest mt-1">Feb</span>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-slate-900">$3,026</span>
                </div>
                <h4 class="text-lg font-bold text-slate-800 mb-6 flex-grow">Rongai route - 7 days</h4>
                <div class="space-y-3 mb-8">
                    <div class="flex items-center gap-3 text-xs font-bold text-slate-500 uppercase tracking-widest">
                        <i class="ph ph-moon text-emerald-500 text-lg"></i> Full Moon Climb
                    </div>
                    <div class="flex items-center gap-3 text-xs font-bold text-slate-500 uppercase tracking-widest">
                        <i class="ph ph-cloud-rain text-emerald-500 text-lg"></i> Less Rainfall
                    </div>
                </div>
                <a href="/contact" class="w-full py-4 bg-slate-900 text-white text-center rounded-2xl font-bold hover:bg-emerald-600 transition-colors">Join Group</a>
            </div>
        </div>
    </div>
</section>

<!-- Choice Section (Private vs Group) -->
<section class="py-32 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Private -->
            <div class="relative rounded-[3.5rem] overflow-hidden p-12 text-white group bg-slate-900 min-h-[500px] flex flex-col justify-end">
                <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&w=800&q=80" alt="Private Climb" class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:scale-105 transition-transform duration-1000">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
                <div class="relative z-10">
                    <h3 class="text-3xl font-serif font-bold mb-6 italic">Private Expeditions</h3>
                    <p class="text-slate-300 mb-10 leading-relaxed font-medium">Choose a private Kilimanjaro climb if you want a fully customized experience. It’s just you, your family or friends, and our expert team — on your schedule, at your pace, with an itinerary tailored to your needs.</p>
                    <a href="/contact" class="inline-flex items-center gap-3 px-10 py-4 bg-emerald-600 rounded-full font-bold shadow-xl shadow-emerald-600/30 hover:bg-emerald-700 transition-all">
                        Customize My Climb <i class="ph ph-gear"></i>
                    </a>
                </div>
            </div>

            <!-- Group -->
            <div class="relative rounded-[3.5rem] overflow-hidden p-12 text-white group bg-emerald-950 min-h-[500px] flex flex-col justify-end">
                <img src="http://res.cloudinary.com/dmqdm8gfk/image/upload/v1766042771/8-Days-Tanzania-holiday-Wildebeest-migration-1536x1018_gyndkw.jpg" alt="Group Climb" class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:scale-105 transition-transform duration-1000">
                <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-950/40 to-transparent"></div>
                <div class="relative z-10">
                    <h3 class="text-3xl font-serif font-bold mb-6 italic">Open-Group Climbs</h3>
                    <p class="text-emerald-100 mb-10 leading-relaxed font-medium">Join one of our open-group climbs and share the adventure with fellow trekkers from around the world. Group climbs offer great camaraderie, team spirit, and the chance to connect with like-minded travelers.</p>
                    <a href="/contact" class="inline-flex items-center gap-3 px-10 py-4 bg-white text-emerald-900 rounded-full font-bold shadow-xl hover:bg-emerald-50 transition-all">
                        Join an Open Group <i class="ph ph-users"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us / CTA -->
<section class="py-32 bg-slate-950 text-white relative overflow-hidden">
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-emerald-500/10 rounded-full blur-[120px] animate-pulse"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-20">
            <div class="lg:w-1/2">
                <span class="text-emerald-500 font-black text-xs uppercase tracking-[0.4em] mb-6 block">Unmatched Standards</span>
                <h2 class="text-5xl font-serif font-bold mb-8 italic">52 Reasons to choose <br> <span class="text-emerald-500">LAU Paradise</span></h2>
                <p class="text-xl text-slate-400 mb-12 leading-relaxed">Discover what makes us the most trusted and well-prepared Kilimanjaro operator — from safety and training to every detail on the mountain.</p>
                <div class="grid grid-cols-2 gap-8 mb-12 border-l border-emerald-500/30 pl-8">
                    <div>
                        <h4 class="text-3xl font-bold mb-2">99%</h4>
                        <p class="text-sm text-slate-500 font-bold uppercase tracking-widest">Summit Rate</p>
                    </div>
                    <div>
                        <h4 class="text-3xl font-bold mb-2">1,500+</h4>
                        <p class="text-sm text-slate-500 font-bold uppercase tracking-widest">Successful Ascents</p>
                    </div>
                </div>
                <a href="/about" class="inline-flex items-center gap-4 bg-emerald-600 text-white px-12 py-5 rounded-full font-bold shadow-2xl shadow-emerald-600/20 hover:scale-105 transition-all">
                    See Why It Matters <i class="ph-bold ph-arrow-right"></i>
                </a>
            </div>
            <div class="lg:w-1/2 relative">
                <div class="rounded-[4rem] overflow-hidden border border-white/10 shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-700">
                    <img src="https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046350/kilimanjaro-climbing_bvcs7p.jpg" alt="Climber on Kilimanjaro" class="w-full h-full object-cover">
                </div>
                <!-- Mini Stats Overlay -->
                <div class="absolute -bottom-10 -left-10 bg-white p-8 rounded-[2rem] shadow-2xl text-slate-900 flex items-center gap-6 -rotate-3">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-3xl">
                        <i class="ph-fill ph-mountains"></i>
                    </div>
                    <div>
                        <span class="block text-2xl font-black italic tracking-tighter">Certified</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Guiding Excellence</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection
