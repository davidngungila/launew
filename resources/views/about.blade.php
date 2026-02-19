@extends('layouts.public')

@section('content')
<div class="pt-24">
    <!-- Hero Section -->
    <section class="relative h-[60vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" 
                 class="w-full h-full object-cover scale-105" alt="Serengeti Sunset">
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px]"></div>
        </div>
        
        <div class="relative z-10 text-center px-6 max-w-4xl mx-auto">
            <span class="inline-block px-4 py-1.5 bg-emerald-500 text-white text-[10px] font-black uppercase tracking-[0.3em] rounded-full mb-6 shadow-xl shadow-emerald-500/20">Our Legacy</span>
            <h1 class="text-5xl md:text-7xl font-serif font-black text-white mb-6 leading-tight border-move">Elevating the African <br> <span class="text-emerald-400 italic">Safari Experience</span></h1>
            <p class="text-lg md:text-xl text-emerald-50/80 font-medium leading-relaxed max-w-2xl mx-auto">
                Discover the heartbeat of Tanzania with a team dedicated to authentic, sustainable, and luxury adventures.
            </p>
        </div>
    </section>

    <!-- Core Story -->
    <section class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div class="relative">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&w=400&q=80" class="rounded-[2rem] shadow-2xl transition-transform hover:-translate-y-2 duration-500" alt="Wildlife">
                        <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=400&q=80" class="rounded-[2rem] shadow-2xl transition-transform hover:translate-y-2 duration-500" alt="Safari jeep">
                    </div>
                    <div class="pt-12">
                        <img src="https://images.unsplash.com/photo-1493612276216-ee3925520721?auto=format&fit=crop&w=400&q=80" class="rounded-[2.5rem] shadow-2xl transition-transform hover:-translate-x-2 duration-500" alt="Lodge">
                    </div>
                </div>
                <!-- Experience Badge -->
                <div class="absolute -bottom-10 -right-10 bg-emerald-600 p-8 rounded-[3rem] text-white shadow-2xl shadow-emerald-600/40 hidden md:block">
                    <p class="text-4xl font-black mb-1">New Gen</p>
                    <p class="text-[10px] uppercase font-bold tracking-widest opacity-80 leading-tight">Founded in 2025</p>
                </div>
            </div>

            <div class="space-y-8">
                <div class="space-y-4">
                    <h4 class="text-emerald-600 font-black text-sm uppercase tracking-[0.2em]">Our Inception</h4>
                    <h2 class="text-4xl font-serif font-black text-slate-900 leading-tight">A Visionary Start in 2025</h2>
                </div>
                <p class="text-slate-600 leading-relaxed text-lg">
                    LAU Paradise Adventure was born in early **2025** with a simple yet profound mission: to redefine the Tanzanian safari through a lens of modern luxury and deep cultural respect. While others follow the beaten path, we specialize in crafting unique narratives that connect our travelers with the raw soul of Africa.
                </p>
                <p class="text-slate-600 leading-relaxed">
                    Headquartered in the foothills of Mount Kilimanjaro in Moshi, we are a local team with a global outlook. Our guides aren't just experts in wildlife; they are storytellers, protectors of the land, and the architects of your lifelong memories.
                </p>
                
                <div class="grid grid-cols-2 gap-8 pt-8 border-t border-slate-100">
                    <div>
                        <h5 class="text-2xl font-black text-slate-900 mb-1">100%</h5>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Locally Owned</p>
                    </div>
                    <div>
                        <h5 class="text-2xl font-black text-slate-900 mb-1">24/7</h5>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Luxury Support</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Us -->
    <section class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-20 space-y-4">
                <h4 class="text-emerald-600 font-black text-sm uppercase tracking-[0.2em]">Our Values</h4>
                <h2 class="text-4xl font-serif font-black text-slate-900 leading-tight">Why Choose LAU Paradise Adventure?</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                @foreach([
                    ['title' => 'Sustainable Tourism', 'desc' => 'We invest 10% of our profits into local community education and wildlife conservation projects.', 'icon' => 'leaf'],
                    ['title' => 'Tailored Excellence', 'desc' => 'Every itinerary is built from scratch, ensuring your journey reflects your personal taste and pace.', 'icon' => 'fingerprint'],
                    ['title' => 'Safety First', 'desc' => 'Our fleet is maintained to the highest international standards, equipped with satellite tracking and first aid.', 'icon' => 'shield-check']
                ] as $value)
                <div class="bg-white p-10 rounded-2xl shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 group">
                    <div class="w-16 h-16 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-8 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-500">
                        <i class="ph-bold ph-{{ $value['icon'] }} text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-4">{{ $value['title'] }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">{{ $value['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Our Team -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-20 space-y-4">
                <h4 class="text-emerald-600 font-black text-sm uppercase tracking-[0.2em]">The Architects of Adventure</h4>
                <h2 class="text-4xl font-serif font-black text-slate-900 leading-tight">Meet Our Leadership Team</h2>
                <p class="text-slate-500 font-medium">Combining decades of expedition expertise with a passion for Tanzanian hospitality.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach([
                    [
                        'name' => 'Lazaro Peter',
                        'role' => 'Founder & Lead Guide',
                        'bio' => '15+ years in the Serengeti, ensuring every expedition is culturally respectful.',
                        'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=800&q=80'
                    ],
                    [
                        'name' => 'Emmanuel David',
                        'role' => 'Head of Logistics',
                        'bio' => 'Mastermind behind fleet coordination and remote camps. David is our expert.',
                        'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=800&q=80'
                    ],
                    [
                        'name' => 'Neema John',
                        'role' => 'Customer Relations',
                        'bio' => 'Ensures your 5-star expectations are exceeded from inquiry to flight departure.',
                        'image' => 'https://images.unsplash.com/photo-1531123897727-8f129e16fd3c?auto=format&fit=crop&w=800&q=80'
                    ],
                    [
                        'name' => 'Grace Lyimo',
                        'role' => 'Finance Director',
                        'bio' => 'Managing our sustainable investments and ensuring transparency in all operations.',
                        'image' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=800&q=80'
                    ],
                    [
                        'name' => 'Kelvin Massawe',
                        'role' => 'Lead Photographer',
                        'bio' => 'Capturing the raw beauty of Tanzania. Kelvin helps document your journey.',
                        'image' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=800&q=80'
                    ]
                ] as $member)
                <div class="group">
                    <div class="relative mb-6 overflow-hidden rounded-2xl aspect-[3/4] shadow-lg">
                        <img src="{{ $member['image'] }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-700" alt="{{ $member['name'] }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent opacity-0 group-hover:opacity-60 transition-opacity duration-500"></div>
                        <div class="absolute bottom-4 left-4 right-4 flex items-center gap-3 translate-y-12 group-hover:translate-y-0 transition-transform duration-500">
                            <a href="#" class="w-8 h-8 bg-white/10 backdrop-blur-md rounded-full flex items-center justify-center text-white hover:bg-emerald-500 transition-colors text-xs">
                                <i class="ph ph-linkedin-logo"></i>
                            </a>
                        </div>
                    </div>
                    <h3 class="text-sm font-black text-slate-900 mb-1 group-hover:text-emerald-600 transition-colors">{{ $member['name'] }}</h3>
                    <p class="text-[9px] font-black uppercase tracking-widest text-emerald-500 mb-3">{{ $member['role'] }}</p>
                    <p class="text-slate-500 text-[11px] leading-relaxed line-clamp-2" title="{{ $member['bio'] }}">{{ $member['bio'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-emerald-950 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&w=2000&q=80" class="w-full h-full object-cover">
        </div>
        <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
            <h2 class="text-4xl md:text-5xl font-serif font-bold text-white mb-8">Ready to Start Your Story?</h2>
            <p class="text-xl text-emerald-100/70 mb-12">Let our specialists design your perfect Tanzanian escape from the ground up.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                <a href="/contact" class="px-10 py-5 bg-emerald-500 text-white font-black text-xs uppercase tracking-[0.2em] rounded-full hover:bg-emerald-400 shadow-xl shadow-emerald-500/20 transition-all">Start Planning</a>
                <a href="/tours" class="px-10 py-5 bg-white/5 backdrop-blur-md border border-white/20 text-white font-black text-xs uppercase tracking-[0.2em] rounded-full hover:bg-white/10 transition-all">Explore Tours</a>
            </div>
        </div>
    </section>
</div>
@endsection
