<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LAU Paradise Adventure | Discover the Wild</title>
    <link rel="icon" type="image/png" href="{{ asset('lau-adventuress-logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Manrope', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .glass { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(15px); }
        .nav-link { font-size: 1.05rem; position: relative; }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 1.5rem;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #064e3b 0%, #10b981 100%);
            transition: width 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .nav-link:hover::after {
            width: 100%;
            animation: borderSlide 1s infinite linear;
            background: linear-gradient(90deg, #064e3b 25%, #10b981 25%, #10b981 50%, #064e3b 50%, #064e3b 75%, #10b981 75%);
            background-size: 200% 100%;
        }
        @keyframes borderSlide {
            0% { background-position: 100% 0; }
            100% { background-position: -100% 0; }
        }
        .border-move {
            position: relative;
            padding-bottom: 1rem;
            display: inline-block;
        }
        .border-move::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #064e3b 25%, #10b981 25%, #10b981 50%, #064e3b 50%, #064e3b 75%, #10b981 75%);
            background-size: 200% 100%;
            animation: borderSlide 2s infinite linear;
            border-radius: 4px;
        }
        .group:hover .mega-menu { opacity: 1; visibility: visible; transform: translateY(0); }
        .mega-menu { 
            opacity: 0; 
            visibility: hidden; 
            transform: translateY(10px); 
            transition: all 0.3s ease;
        }
        .nav-border-animate {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #064e3b 25%, #10b981 25%, #10b981 50%, #064e3b 50%, #064e3b 75%, #10b981 75%);
            background-size: 200% 100%;
            animation: borderSlide 3s infinite linear;
        }
    </style>
</head>
<body class="bg-white text-slate-900 antialiased font-medium" x-data="{ mobileMenuOpen: false }">
    <!-- Top Info Bar -->
    <div class="hidden lg:block bg-slate-900 text-white/70 py-2 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center text-[11px] font-bold uppercase tracking-widest">
            <div class="flex items-center gap-8">
                <span class="flex items-center gap-2"><i class="ph-bold ph-phone text-emerald-400"></i> +255 683 163 219</span>
                <span class="flex items-center gap-2"><i class="ph-bold ph-envelope text-emerald-400"></i> lauparadiseadventure@gmail.com</span>
                <span class="flex items-center gap-2"><i class="ph-bold ph-map-pin text-emerald-400"></i> Moshi, Tanzania</span>
            </div>
            <div class="flex items-center gap-6">
                <a href="#" class="hover:text-emerald-400 transition-colors">FB</a>
                <a href="#" class="hover:text-emerald-400 transition-colors">IG</a>
                <a href="#" class="hover:text-emerald-400 transition-colors">TW</a>
                <a href="#" class="hover:text-emerald-400 transition-colors">YT</a>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="sticky top-0 w-full z-50 glass border-b border-slate-100 h-24 flex items-center">
        <div class="max-w-7xl mx-auto px-6 w-full flex items-center justify-between">
            <a href="/" class="flex items-center gap-3 group/logo">
                <div class="relative w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center p-2 group-hover/logo:bg-emerald-100 transition-colors">
                    <img src="{{ asset('lau-adventuress-logo.png') }}" alt="LAU Safaris Logo" class="w-full h-full object-contain transition-transform group-hover/logo:scale-110">
                </div>
                <div class="flex flex-col">
                    <span class="text-2xl font-black tracking-tighter text-slate-900 leading-none">LAU</span>
                    <span class="text-[11px] font-extrabold tracking-[0.25em] text-emerald-600 uppercase leading-none mt-1">PARADISE ADVENTURE</span>
                </div>
            </a>
            
            <!-- Desktop Layout -->
            <div class="hidden lg:flex items-center gap-8">
                <a href="/" class="nav-link font-bold text-sm tracking-tight hover:text-emerald-600 transition-colors py-4">Home</a>
                
                <!-- Safaris Mega Menu -->
                <div class="relative group py-4">
                    <a href="/tours" class="nav-link font-bold text-sm tracking-tight hover:text-emerald-600 transition-colors flex items-center gap-1 cursor-pointer">
                        Safaris <i class="ph ph-caret-down text-[10px] transition-transform group-hover:rotate-180"></i>
                    </a>
                    <div class="mega-menu absolute top-[calc(100%+0px)] -left-20 w-[650px] bg-white rounded-[2.5rem] shadow-[0_30px_60px_-15px_rgba(0,0,0,0.15)] border border-slate-100 p-8 z-50">
                        <div class="grid grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600 mb-4 px-3">Top Expeditions</h4>
                                <a href="/tours" class="flex items-center gap-4 group/item p-3 rounded-2xl hover:bg-emerald-50/50 transition-all border border-transparent hover:border-emerald-100">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden shadow-inner">
                                        <img src="https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766042771/8-Days-Tanzania-holiday-Wildebeest-migration-1536x1018_gyndkw.jpg" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">Great Migration</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Seasonal Peak</p>
                                    </div>
                                </a>
                                <a href="/tours" class="flex items-center gap-4 group/item p-3 rounded-2xl hover:bg-emerald-50/50 transition-all border border-transparent hover:border-emerald-100">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden shadow-inner">
                                        <img src="https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046350/kilimanjaro-climbing_bvcs7p.jpg" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">Mount Kilimanjaro</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Roof of Africa</p>
                                    </div>
                                </a>
                            </div>
                            <div class="bg-slate-50 rounded-3xl p-6">
                                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600 mb-4">Quick Links</h4>
                                <ul class="space-y-4">
                                    <li><a href="/tours" class="flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-emerald-600 transition-colors"><i class="ph ph-shield-check text-emerald-500"></i> Safety & Guidelines</a></li>
                                    <li><a href="/tours" class="flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-emerald-600 transition-colors"><i class="ph ph-backpack text-emerald-500"></i> Essential Packing List</a></li>
                                    <li><a href="/tours" class="flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-emerald-600 transition-colors"><i class="ph ph-camera text-emerald-500"></i> Photo Safari Special</a></li>
                                </ul>
                                <div class="mt-6 pt-6 border-t border-slate-200">
                                    <a href="/tours" class="text-xs font-black text-emerald-700 bg-white px-5 py-3 rounded-xl shadow-sm border border-slate-100 flex items-center justify-between hover:bg-emerald-500 hover:text-white transition-all">
                                        View All Packages <i class="ph ph-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="/about" class="nav-link font-bold text-sm tracking-tight hover:text-emerald-600 transition-colors py-4">Our Story</a>
                <a href="/contact" class="nav-link font-bold text-sm tracking-tight hover:text-emerald-600 transition-colors py-4">Connect</a>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="hidden md:flex items-center px-4 py-2 bg-slate-50 rounded-2xl border border-slate-100">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse mr-3"></div>
                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-500">Guides Online</span>
                </div>
                <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center gap-2 text-xs font-black uppercase tracking-widest text-slate-700 hover:text-emerald-600 transition-all">
                    Portal
                </a>
                <a href="/tours" class="hidden md:inline-flex items-center gap-2 text-xs font-black uppercase tracking-[0.2em] text-white bg-slate-900 border-2 border-slate-900 px-8 py-3 rounded-full hover:bg-emerald-600 hover:border-emerald-600 shadow-xl shadow-slate-900/10 transition-all">
                    Start Planning
                </a>
                
                <!-- Mobile Toggle -->
                <button @click="mobileMenuOpen = true" class="lg:hidden w-12 h-12 bg-emerald-600 text-white rounded-2xl flex items-center justify-center hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/20">
                    <i class="ph-bold ph-list text-2xl"></i>
                </button>
            </div>
        </div>
        <div class="nav-border-animate"></div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-400"
         x-transition:enter-start="opacity-0 translate-x-full"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 translate-x-full"
         class="fixed inset-0 z-[100] lg:hidden" x-cloak>
        
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" @click="mobileMenuOpen = false"></div>
        
        <!-- Sidebar -->
        <div class="absolute right-0 top-0 bottom-0 w-[85%] max-w-sm bg-white shadow-2xl overflow-y-auto">
            <div class="p-8">
                <div class="flex items-center justify-between mb-12">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('lau-adventuress-logo.png') }}" class="h-10 w-auto" alt="Logo">
                        <div class="flex flex-col">
                            <span class="font-black text-slate-900 leading-none">LAU</span>
                            <span class="text-[8px] font-black tracking-widest text-emerald-600 uppercase">Paradise</span>
                        </div>
                    </div>
                    <button @click="mobileMenuOpen = false" class="w-12 h-12 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center hover:bg-rose-50 hover:text-rose-500 transition-all">
                        <i class="ph ph-x text-2xl"></i>
                    </button>
                </div>

                <div class="space-y-8">
                    <a href="/" class="block text-3xl font-serif font-black text-slate-900 hover:text-emerald-600 transition-colors">Home</a>
                    <a href="/tours" class="block text-3xl font-serif font-black text-slate-900 hover:text-emerald-600 transition-colors">Our Safaris</a>
                    <a href="/about" class="block text-3xl font-serif font-black text-slate-900 hover:text-emerald-600 transition-colors">Our Story</a>
                    <a href="/contact" class="block text-3xl font-serif font-black text-slate-900 hover:text-emerald-600 transition-colors">Connect</a>
                </div>

                <div class="mt-20 pt-10 border-t border-slate-100 space-y-8">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Direct Contact</h4>
                        <a href="tel:+255683163219" class="text-lg font-bold text-slate-900 flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center"><i class="ph ph-phone"></i></span>
                            +255 683 163 219
                        </a>
                        <a href="mailto:lauparadiseadventure@gmail.com" class="text-sm font-bold text-slate-500 flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center"><i class="ph ph-envelope"></i></span>
                            lauparadiseadventure@gmail.com
                        </a>
                    </div>
                    
                    <div class="bg-emerald-950 p-8 rounded-[3rem] text-white overflow-hidden relative group">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-125 transition-transform duration-700">
                            <i class="ph-bold ph-brand-safari text-8xl"></i>
                        </div>
                        <h4 class="text-xl font-serif font-black mb-2 relative z-10">Start Your Story</h4>
                        <p class="text-sm text-emerald-100/60 mb-8 leading-relaxed relative z-10">Tanzania is waiting for you. Let's design the perfect journey.</p>
                        <a href="/tours" class="w-full inline-block py-4 bg-emerald-500 text-white font-black text-xs uppercase tracking-[0.2em] text-center rounded-2xl shadow-xl shadow-emerald-500/20 relative z-10 border border-emerald-400/20">Book Adventure</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('content')

    <!-- Footer -->
    <footer class="bg-slate-950 text-white pt-24 pb-12 relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute inset-0 z-0 pointer-events-none opacity-[0.03]">
            <img src="https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766262424/biologist-forest.jpg" class="w-full h-full object-cover grayscale">
        </div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <!-- Newsletter Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 pb-20 border-b border-white/5 items-center">
                <div>
                    <span class="inline-block px-4 py-1.5 bg-emerald-900/30 text-emerald-400 text-[10px] font-black uppercase tracking-[0.2em] rounded-full mb-6 border border-emerald-900/50">Stay Inspired</span>
                    <h2 class="text-3xl md:text-5xl font-serif font-black mb-4 leading-tight">Join the Inner Circle of <br> <span class="text-emerald-500 italic">Safari Enthusiasts</span></h2>
                    <p class="text-slate-400 text-lg">Receive exclusive travel guides, wildlife news, and member-only offers.</p>
                </div>
                <div class="max-w-md lg:ml-auto w-full">
                    <form class="flex gap-2 p-2 bg-white/5 rounded-3xl border border-white/10 backdrop-blur-md focus-within:border-emerald-500/50 transition-all">
                        <input type="email" placeholder="Email Address" class="bg-transparent border-none focus:ring-0 text-white flex-1 px-4 placeholder:text-slate-500 font-bold">
                        <button class="bg-emerald-600 hover:bg-emerald-500 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-xl shadow-emerald-900/20">
                            Join
                        </button>
                    </form>
                    <p class="text-[10px] text-slate-500 mt-4 text-center px-4">By subscribing, you agree to our Privacy Policy and consent to receive marketing emails.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16 py-20">
                <!-- Branding -->
                <div class="space-y-8">
                    <a href="/" class="flex flex-col group">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 rounded-xl bg-white/5 p-2 border border-white/10 group-hover:bg-emerald-600 group-hover:border-emerald-600 transition-all duration-500">
                                <img src="{{ asset('lau-adventuress-logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                            </div>
                            <span class="text-3xl font-black tracking-tighter group-hover:text-emerald-500 transition-colors">LAU</span>
                        </div>
                        <span class="text-[10px] font-black tracking-[0.4em] text-emerald-500 uppercase leading-none px-1">PARADISE ADVENTURE</span>
                    </a>
                    <p class="text-slate-400 leading-relaxed text-sm">
                        Crafting a new generation of safari excellence. We merge modern luxury with the raw, authentic spirit of the Tanzanian wilderness. Founded in 2025, dedicated to the wild.
                    </p>
                    <div class="flex items-center gap-4">
                        @foreach(['facebook', 'instagram', 'linkedin-logo', 'youtube-logo'] as $icon)
                        <a href="#" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:bg-emerald-600 hover:text-white hover:-translate-y-1 transition-all">
                            <i class="ph ph-{{ $icon }} text-xl"></i>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Explore -->
                <div>
                    <h4 class="text-xs font-black uppercase tracking-[0.3em] text-white mb-8 border-l-2 border-emerald-500 pl-4">The Collection</h4>
                    <ul class="space-y-5 text-sm font-bold text-slate-400">
                        <li><a href="/tours" class="hover:text-emerald-500 transition-all flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-slate-800 group-hover:bg-emerald-500 transition-all"></span> Great Migration Safaris</a></li>
                        <li><a href="/tours" class="hover:text-emerald-500 transition-all flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-slate-800 group-hover:bg-emerald-500 transition-all"></span> Kilimanjaro Climbing</a></li>
                        <li><a href="/tours" class="hover:text-emerald-500 transition-all flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-slate-800 group-hover:bg-emerald-500 transition-all"></span> Zanzibar Retreats</a></li>
                        <li><a href="/tours" class="hover:text-emerald-500 transition-all flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-slate-800 group-hover:bg-emerald-500 transition-all"></span> Cultural Encounters</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h4 class="text-xs font-black uppercase tracking-[0.3em] text-white mb-8 border-l-2 border-emerald-500 pl-4">Expertise</h4>
                    <ul class="space-y-5 text-sm font-bold text-slate-400">
                        <li><a href="/about" class="hover:text-emerald-500 transition-all">Our Story & Vision</a></li>
                        <li><a href="/contact" class="hover:text-emerald-500 transition-all">Meet Our Guides</a></li>
                        <li><a href="/contact" class="hover:text-emerald-500 transition-all">Sustainable Tourism</a></li>
                        <li><a href="/contact" class="hover:text-emerald-500 transition-all">Travel Blog</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-xs font-black uppercase tracking-[0.3em] text-white mb-8 border-l-2 border-emerald-500 pl-4">Contact</h4>
                    <ul class="space-y-6">
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-emerald-950/50 flex items-center justify-center shrink-0 border border-emerald-900/30">
                                <i class="ph-bold ph-phone text-emerald-500"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-1">Direct Line</p>
                                <p class="text-sm font-black">+255 683 163 219</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-emerald-950/50 flex items-center justify-center shrink-0 border border-emerald-900/30">
                                <i class="ph-bold ph-envelope text-emerald-500"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-1">Inquiries</p>
                                <p class="text-sm font-black">lauparadiseadventure@gmail.com</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-emerald-950/50 flex items-center justify-center shrink-0 border border-emerald-900/30">
                                <i class="ph-bold ph-map-pin text-emerald-500"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-1">HQ Office</p>
                                <p class="text-sm font-black">Moshi, Tanzania</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="pt-10 border-t border-white/5 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex items-center gap-8">
                    <p class="text-[11px] font-bold text-slate-500 tracking-wider">© 2026 LAU PARADISE ADVENTURE. ALL RIGHTS RESERVED.</p>
                </div>
                <div class="flex items-center gap-8 text-[11px] font-black uppercase tracking-widest text-slate-500">
                    <a href="#" class="hover:text-emerald-500 transition-colors">Privacy</a>
                    <a href="#" class="hover:text-emerald-500 transition-colors">Terms</a>
                    <a href="#" class="hover:text-emerald-500 transition-colors">Cookies</a>
                    <div class="flex items-center gap-4 ml-4">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Flag_of_Tanzania.svg/320px-Flag_of_Tanzania.svg.png" class="h-3 w-auto opacity-50 grayscale hover:grayscale-0 transition-all cursor-help" title="Proudly Tanzanian">
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/255683163219" target="_blank" class="fixed bottom-8 right-8 z-50 w-16 h-16 bg-green-500 text-white rounded-full flex items-center justify-center shadow-2xl hover:scale-110 hover:bg-green-600 transition-all">
        <i class="ph ph-whatsapp-logo text-3xl"></i>
    </a>
</body>
</html>
