<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LAU Paradise Adventure | Discover the Wild</title>
    <link rel="icon" type="image/png" href="{{ asset('lau-adventuress-logo.png') }}">
    @php($integrations = \App\Models\SystemSetting::getValue('integrations', []))
    @php($gtmId = (string) data_get($integrations, 'gtm_container_id', ''))
    @php($ga4Id = (string) data_get($integrations, 'ga4_measurement_id', ''))
    @if($gtmId)
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','{{ $gtmId }}');</script>
    @endif
    @if($ga4Id)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga4Id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $ga4Id }}');
        </script>
    @endif
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
    @if($gtmId)
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif
    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 glass border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-24 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3 group/logo">
                <img src="{{ asset('lau-adventuress-logo.png') }}" alt="LAU Safaris Logo" class="h-14 w-auto object-contain transition-transform group-hover/logo:scale-105">
                <div class="flex flex-col">
                    <span class="text-2xl font-black tracking-tighter text-slate-900 leading-none">LAU</span>
                    <span class="text-[11px] font-extrabold tracking-[0.25em] text-emerald-600 uppercase leading-none mt-1">PARADISE ADVENTURE</span>
                </div>
            </a>
            
            <!-- Desktop Layout -->
            <div class="hidden lg:flex items-center gap-10">
                <a href="/" class="nav-link font-bold hover:text-emerald-600 transition-colors py-8">Home</a>
                <!-- Safaris Dropdown -->
                <div class="relative group py-8">
                    <a href="/tours" class="nav-link font-bold hover:text-emerald-600 transition-colors flex items-center gap-1">
                        Safaris <i class="ph ph-caret-down text-xs transition-transform group-hover:rotate-180"></i>
                    </a>
                    <div class="mega-menu absolute top-full left-0 w-[600px] bg-white rounded-[2rem] shadow-2xl border border-slate-100 p-8 z-50">
                        <div class="grid grid-cols-2 gap-8">
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-widest text-emerald-600 mb-6">Adventure Types</h4>
                                <div class="space-y-4">
                                    <a href="/tours" class="flex items-center gap-4 group/item p-3 rounded-2xl hover:bg-emerald-50 transition-all">
                                        <div class="w-12 h-12 rounded-xl overflow-hidden">
                                            <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 group-hover/item:text-emerald-700">Classic Serengeti</p>
                                            <p class="text-xs text-slate-500">Best Seller Experience</p>
                                        </div>
                                    </a>
                                    <a href="/tours" class="flex items-center gap-4 group/item p-3 rounded-2xl hover:bg-emerald-50 transition-all">
                                        <div class="w-12 h-12 rounded-xl overflow-hidden">
                                            <img src="http://res.cloudinary.com/dmqdm8gfk/image/upload/v1766042771/8-Days-Tanzania-holiday-Wildebeest-migration-1536x1018_gyndkw.jpg" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 group-hover/item:text-emerald-700">Luxury Camping</p>
                                            <p class="text-xs text-slate-500">Wild & Comfortable</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-widest text-emerald-600 mb-6">Experience Styles</h4>
                                <div class="space-y-4">
                                    <a href="/tours" class="flex items-center gap-3 text-slate-700 hover:text-emerald-600 font-bold group/sub transition-colors">
                                        <i class="ph ph-users-four text-xl opacity-50 group-hover/sub:opacity-100"></i> Private Safaris
                                    </a>
                                    <a href="{{ route('kilimanjaro') }}" class="flex items-center gap-3 text-slate-700 hover:text-emerald-600 font-bold group/sub transition-colors">
                                        <i class="ph ph-mountains text-xl opacity-50 group-hover/sub:opacity-100"></i> Kilimanjaro Treks
                                    </a>
                                    <a href="/tours" class="flex items-center gap-3 text-slate-700 hover:text-emerald-600 font-bold group/sub transition-colors">
                                        <i class="ph ph-camera text-xl opacity-50 group-hover/sub:opacity-100"></i> Photographic Safaris
                                    </a>
                                    <a href="{{ route('group-departures') }}" class="flex items-center gap-3 text-emerald-600 hover:text-emerald-700 font-bold group/sub transition-colors">
                                        <i class="ph-bold ph-calendar-plus text-xl"></i> Group Departures
                                    </a>
                                </div>
                                <div class="mt-8 pt-6 border-t border-slate-50">
                                    <a href="/tours" class="text-sm font-black text-emerald-600 flex items-center gap-2 hover:gap-3 transition-all">
                                        Explore All Safaris <i class="ph ph-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tours Mega Menu -->
                <div class="relative group py-8">
                    <a href="/tours" class="nav-link font-bold hover:text-emerald-600 transition-colors flex items-center gap-1">
                        Destinations <i class="ph ph-caret-down text-xs transition-transform group-hover:rotate-180"></i>
                    </a>
                    <div class="mega-menu absolute top-full -left-20 w-[600px] bg-white rounded-[2rem] shadow-2xl border border-slate-100 p-8 z-50">
                        <div class="grid grid-cols-2 gap-8">
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-widest text-emerald-600 mb-6">Popular Regions</h4>
                                <div class="space-y-4">
                                    <a href="{{ route('regions.serengeti') }}" class="flex items-center gap-4 group/item p-3 rounded-2xl hover:bg-emerald-50 transition-all">
                                        <div class="w-12 h-12 rounded-xl overflow-hidden">
                                            <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 group-hover/item:text-emerald-700">Serengeti NP</p>
                                            <p class="text-xs text-slate-500">The Great Migration</p>
                                        </div>
                                    </a>
                                    <a href="{{ route('regions.ngorongoro') }}" class="flex items-center gap-4 group/item p-3 rounded-2xl hover:bg-emerald-50 transition-all">
                                        <div class="w-12 h-12 rounded-xl overflow-hidden">
                                            <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 group-hover/item:text-emerald-700">Ngorongoro</p>
                                            <p class="text-xs text-slate-500">UNESCO World Heritage</p>
                                        </div>
                                    </a>
                                    <a href="{{ route('regions.zanzibar') }}" class="flex items-center gap-4 group/item p-3 rounded-2xl hover:bg-emerald-50 transition-all">
                                        <div class="w-12 h-12 rounded-xl overflow-hidden">
                                            <img src="https://images.unsplash.com/photo-1493612276216-ee3925520721?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 group-hover/item:text-emerald-700">Zanzibar</p>
                                            <p class="text-xs text-slate-500">Beaches & Culture</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-widest text-emerald-600 mb-6">Tanzania Specialties</h4>
                                <div class="space-y-4">
                                    <a href="{{ route('kilimanjaro') }}" class="flex items-center gap-3 text-slate-700 hover:text-emerald-600 font-bold group/sub transition-colors">
                                        <i class="ph ph-mountain text-xl opacity-50 group-hover/sub:opacity-100"></i> Kilimanjaro Treks
                                    </a>
                                    <a href="{{ route('regions.lake-manyara') }}" class="flex items-center gap-3 text-slate-700 hover:text-emerald-600 font-bold group/sub transition-colors">
                                        <i class="ph ph-umbrella text-xl opacity-50 group-hover/sub:opacity-100"></i> Zanzibar Beaches
                                    </a>
                                    <a href="{{ route('regions.ruaha') }}" class="flex items-center gap-3 text-slate-700 hover:text-emerald-600 font-bold group/sub transition-colors">
                                        <i class="ph ph-bird text-xl opacity-50 group-hover/sub:opacity-100"></i> Bird Watching Tours
                                    </a>
                                </div>
                                <div class="mt-8 pt-6 border-t border-slate-50">
                                    <a href="/tours" class="text-sm font-black text-emerald-600 flex items-center gap-2 hover:gap-3 transition-all">
                                        View All Packages <i class="ph ph-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- About Us Mega Menu -->
                <div class="relative group py-8">
                    <a href="/about" class="nav-link font-bold hover:text-emerald-600 transition-colors flex items-center gap-1">
                        About Us <i class="ph ph-caret-down text-xs transition-transform group-hover:rotate-180"></i>
                    </a>
                    <div class="mega-menu absolute top-full -left-40 w-[500px] bg-white rounded-[2rem] shadow-2xl border border-slate-100 p-8 z-50">
                        <div class="grid grid-cols-2 gap-6">
                            <a href="/about" class="block p-5 bg-slate-50 rounded-2xl hover:bg-emerald-600 hover:text-white group/box transition-all">
                                <i class="ph-bold ph-strategy text-3xl mb-4 text-emerald-600 group-hover/box:text-white"></i>
                                <h5 class="font-black mb-2">Our Story</h5>
                                <p class="text-xs opacity-70">New Gen started in 2025</p>
                            </a>
                            <a href="/contact" class="block p-5 bg-slate-50 rounded-2xl hover:bg-emerald-600 hover:text-white group/box transition-all">
                                <i class="ph-bold ph-chat-circle-dots text-3xl mb-4 text-emerald-600 group-hover/box:text-white"></i>
                                <h5 class="font-black mb-2">Expert Consultation</h5>
                                <p class="text-xs opacity-70">Talk to our safari specialists</p>
                            </a>
                        </div>
                    </div>
                </div>

                <a href="/contact" class="nav-link font-bold hover:text-emerald-600 transition-colors py-8">Contact</a>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center gap-2 text-sm font-semibold text-slate-700 bg-white border border-slate-200 px-5 py-2.5 rounded-full hover:bg-slate-50 transition-all">
                    Login
                </a>
                <a href="/tours" class="hidden md:inline-flex items-center gap-2 text-sm font-semibold text-white bg-emerald-600 px-6 py-2.5 rounded-full hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition-all">
                    Book Now
                </a>
                
                <!-- Mobile Toggle -->
                <button @click="mobileMenuOpen = true" class="lg:hidden w-12 h-12 bg-slate-50 text-slate-900 rounded-2xl flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-all">
                    <i class="ph ph-list text-2xl"></i>
                </button>
            </div>
        </div>
        <div class="nav-border-animate"></div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-x-full"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 translate-x-full"
         class="fixed inset-0 z-[100] lg:hidden">
        
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-md" @click="mobileMenuOpen = false"></div>
        
        <!-- Sidebar -->
        <div class="absolute right-0 top-0 bottom-0 w-[85%] max-w-sm bg-white shadow-2xl overflow-y-auto">
            <div class="p-8">
                <div class="flex items-center justify-between mb-12">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('lau-adventuress-logo.png') }}" class="h-10 w-auto" alt="Logo">
                        <span class="font-black text-slate-900">LAU SAFARIS</span>
                    </div>
                    <button @click="mobileMenuOpen = false" class="w-10 h-10 bg-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-rose-50 hover:text-rose-500 transition-all">
                        <i class="ph ph-x text-2xl"></i>
                    </button>
                </div>

                <div class="space-y-6">
                    <a href="/" class="block text-2xl font-serif font-black text-slate-900 hover:text-emerald-600">Home</a>
                    
                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center justify-between w-full text-2xl font-serif font-black text-slate-900">
                            Safaris <i class="ph ph-caret-down text-lg transition-transform" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" x-collapse class="pl-4 mt-4 space-y-4">
                            <a href="/tours" class="block text-sm font-bold text-slate-500 hover:text-emerald-600">Classic Serengeti</a>
                            <a href="/tours" class="block text-sm font-bold text-slate-500 hover:text-emerald-600">Private Safaris</a>
                            <a href="/tours" class="block text-sm font-bold text-slate-500 hover:text-emerald-600">Luxury Camping</a>
                            <a href="{{ route('kilimanjaro') }}" class="block text-sm font-bold text-slate-500 hover:text-emerald-600">Kilimanjaro Climbing</a>
                            <a href="{{ route('group-departures') }}" class="block text-sm font-bold text-emerald-600 italic">Group Departures</a>
                        </div>
                    </div>

                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center justify-between w-full text-2xl font-serif font-black text-slate-900">
                            Destinations <i class="ph ph-caret-down text-lg transition-transform" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" x-collapse class="pl-4 mt-4 space-y-4">
                            <a href="{{ route('regions.serengeti') }}" class="block text-sm font-bold text-slate-500 hover:text-emerald-600">Serengeti NP</a>
                            <a href="{{ route('regions.ngorongoro') }}" class="block text-sm font-bold text-slate-500 hover:text-emerald-600">Ngorongoro Crater</a>
                            <a href="{{ route('regions.zanzibar') }}" class="block text-sm font-bold text-slate-500 hover:text-emerald-600">Zanzibar</a>
                            <a href="{{ route('regions.tarangire') }}" class="block text-sm font-bold text-slate-500 hover:text-emerald-600">Tarangire</a>
                            <a href="{{ route('kilimanjaro') }}" class="block text-sm font-bold text-slate-500 hover:text-emerald-600">Kilimanjaro Treks</a>
                        </div>
                    </div>

                    <a href="/about" class="block text-2xl font-serif font-black text-slate-900 hover:text-emerald-600">About Us</a>
                    <a href="/contact" class="block text-2xl font-serif font-black text-slate-900 hover:text-emerald-600">Contact</a>
                </div>

                <div class="mt-20 pt-10 border-t border-slate-100">
                    <div class="bg-emerald-950 p-8 rounded-[2.5rem] text-white">
                        <h4 class="text-lg font-serif font-black mb-2">Ready to Start?</h4>
                        <p class="text-sm text-emerald-100/60 mb-8 leading-relaxed">Let's build your dream itinerary together.</p>
                        <a href="/tours" class="w-full inline-block py-4 bg-emerald-500 text-white font-black text-xs uppercase tracking-widest text-center rounded-2xl shadow-xl shadow-emerald-500/20">Book Adventure</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('content')

    <!-- Footer -->
    <footer class="bg-slate-900 text-white pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-20">
            <div class="col-span-1 md:col-span-1 lg:col-span-1">
                <a href="/" class="flex items-center gap-3 mb-6">
                    <img src="{{ asset('lau-adventuress-logo.png') }}" alt="LAU Safaris Logo" class="h-10 w-auto object-contain">
                    <div class="flex flex-col">
                        <span class="text-lg font-black tracking-tighter text-white leading-none">LAU</span>
                        <span class="text-[9px] font-bold tracking-[0.2em] text-emerald-400 uppercase leading-none">PARADISE ADVENTURE</span>
                    </div>
                </a>
                <p class="text-slate-400 leading-relaxed text-sm italic">
                    Authentic African safari excellence starting in 2025. Discover the beauty of Tanzania's wildlife with expert guides.
                </p>
            </div>
            <div>
                <h4 class="font-bold mb-6 text-emerald-500">Quick Links</h4>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li><a href="/" class="hover:text-white transition-colors">Home</a></li>
                    <li><a href="{{ route('group-departures') }}" class="hover:text-white transition-colors">Group Departures</a></li>
                    <li><a href="{{ route('kilimanjaro') }}" class="hover:text-white transition-colors">Kilimanjaro</a></li>
                    <li><a href="{{ route('tours.index') }}" class="hover:text-white transition-colors">Our Tours</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact Us</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-6 text-emerald-500">Popular Regions</h4>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li><a href="{{ route('regions.serengeti') }}" class="hover:text-white transition-colors">Serengeti NP</a></li>
                    <li><a href="{{ route('regions.ngorongoro') }}" class="hover:text-white transition-colors">Ngorongoro</a></li>
                    <li><a href="{{ route('kilimanjaro') }}" class="hover:text-white transition-colors">Mount Kilimanjaro</a></li>
                    <li><a href="{{ route('regions.zanzibar') }}" class="hover:text-white transition-colors">Zanzibar Island</a></li>
                    <li><a href="{{ route('regions.tarangire') }}" class="hover:text-white transition-colors">Tarangire NP</a></li>
                    <li><a href="{{ route('regions.lake-manyara') }}" class="hover:text-white transition-colors">Lake Manyara NP</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-6 text-emerald-500">Contact Info</h4>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li class="flex items-center gap-3">
                        <i class="ph ph-phone text-emerald-500"></i> +255 683 163 219
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="ph ph-envelope text-emerald-500"></i> lauparadiseadventure@gmail.com
                    </li>
                    <li class="flex items-center gap-3 font-bold">
                        <i class="ph ph-map-pin text-emerald-500"></i> Moshi, Tanzania
                    </li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 pt-10 border-t border-slate-800">
            <div class="flex flex-col items-center text-center gap-8">
                <div class="flex flex-col items-center gap-4">
                    <div class="flex flex-wrap items-center justify-center gap-y-2 gap-x-6 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <a href="{{ route('terms') }}" class="hover:text-emerald-500 transition-colors">Terms & Conditions</a>
                        <a href="{{ route('privacy') }}" class="hover:text-emerald-500 transition-colors">Privacy Policy</a>
                        <a href="{{ route('cookies') }}" class="hover:text-emerald-500 transition-colors">Cookies Policy</a>
                        <a href="{{ route('refund') }}" class="hover:text-emerald-500 transition-colors">Refund Policy</a>
                        <a href="{{ route('editorial') }}" class="hover:text-emerald-500 transition-colors">Editorial Policy</a>
                        <a href="{{ route('sustainability') }}" class="hover:text-emerald-500 transition-colors">Sustainability Policy</a>
                    </div>
                    <p class="text-sm text-slate-500">© 2026 LAU PARADISE ADVENTURE. All rights reserved.</p>
                </div>
                <div class="flex items-center gap-6">
                    <a href="#" class="text-slate-500 hover:text-white transition-colors"><i class="ph ph-facebook-logo text-xl"></i></a>
                    <a href="#" class="text-slate-500 hover:text-white transition-colors"><i class="ph ph-instagram-logo text-xl"></i></a>
                    <a href="#" class="text-slate-500 hover:text-white transition-colors"><i class="ph ph-twitter-logo text-xl"></i></a>
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
