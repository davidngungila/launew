@extends('layouts.public')

@section('content')
<!-- Hero Slider -->
<section class="relative h-screen overflow-hidden">
    <!-- Swiper -->
    <div class="swiper heroSwiper h-full w-full">
        <div class="swiper-wrapper">
            <!-- Slide 1: Serengeti -->
            <div class="swiper-slide relative flex items-center">
                <div class="absolute inset-0 z-0">
                    <img src="https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766042771/8-Days-Tanzania-holiday-Wildebeest-migration-1536x1018_gyndkw.jpg" alt="Serengeti" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 via-slate-900/40 to-transparent"></div>
                </div>
                <div class="relative z-10 max-w-7xl mx-auto px-6 w-full pt-20">
                    <div class="max-w-2xl translate-y-10 opacity-0 transition-all duration-1000 slide-content">
                        <span class="inline-block px-4 py-1.5 bg-emerald-600/20 text-emerald-400 rounded-full text-xs font-bold tracking-widest uppercase mb-6 border border-emerald-600/30">Experience Excellence</span>
                        <h1 class="text-4xl md:text-6xl lg:text-7xl font-serif text-white mb-8 leading-[1.1] md:whitespace-nowrap">Unveil the magic of <span class="text-emerald-500">Wild Africa</span></h1>
                        <p class="text-xl text-slate-200 mb-12 leading-relaxed">Embark on a journey of a lifetime with Moshi's most trusted safari operator. Authentic, premium, and unforgettable adventures await at LAU Paradise Adventure.</p>
                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            <a href="/tours" class="w-full sm:w-auto px-10 py-4 bg-emerald-600 text-white font-bold rounded-full hover:bg-emerald-700 shadow-xl shadow-emerald-600/30 transition-all text-center">
                                Explore Our Packages
                            </a>
                            <a href="#" class="w-full sm:w-auto px-10 py-4 bg-white/10 text-white font-bold rounded-full border border-white/20 hover:bg-white/20 transition-all text-center backdrop-blur-md flex items-center justify-center gap-2 group">
                                <i class="ph-fill ph-play-circle text-2xl group-hover:scale-110 transition-transform"></i> Watch Film
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Kilimanjaro -->
            <div class="swiper-slide relative flex items-center">
                <div class="absolute inset-0 z-0">
                    <img src="https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046350/kilimanjaro-climbing_bvcs7p.jpg" alt="Kilimanjaro" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 via-slate-900/40 to-transparent"></div>
                </div>
                <div class="relative z-10 max-w-7xl mx-auto px-6 w-full pt-20">
                    <div class="max-w-2xl translate-y-10 opacity-0 transition-all duration-1000 slide-content">
                        <span class="inline-block px-4 py-1.5 bg-emerald-600/20 text-emerald-400 rounded-full text-xs font-bold tracking-widest uppercase mb-6 border border-emerald-600/30">Epic Heights</span>
                        <h1 class="text-4xl md:text-6xl lg:text-7xl font-serif text-white mb-8 leading-[1.1] md:whitespace-nowrap">Conquer the <span class="text-emerald-500">Roof of Africa</span></h1>
                        <p class="text-xl text-slate-200 mb-12 leading-relaxed">Experience the breathtaking views from the summit of Mount Kilimanjaro with our expert mountain guides.</p>
                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            <a href="/tours" class="w-full sm:w-auto px-10 py-4 bg-emerald-600 text-white font-bold rounded-full hover:bg-emerald-700 shadow-xl shadow-emerald-600/30 transition-all text-center">
                                View Trekking Routes
                            </a>
                            <a href="#" class="w-full sm:w-auto px-10 py-4 bg-white/10 text-white font-bold rounded-full border border-white/20 hover:bg-white/20 transition-all text-center backdrop-blur-md flex items-center justify-center gap-2 group">
                                <i class="ph-fill ph-play-circle text-2xl group-hover:scale-110 transition-transform"></i> Watch Film
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3: Ngorongoro -->
            <div class="swiper-slide relative flex items-center">
                <div class="absolute inset-0 z-0">
                    <img src="https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046228/tower-giraffes-gathered-around-bushes-open-woodlan_fsgqe3.jpg" alt="Ngorongoro" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 via-slate-900/40 to-transparent"></div>
                </div>
                <div class="relative z-10 max-w-7xl mx-auto px-6 w-full pt-20">
                    <div class="max-w-2xl translate-y-10 opacity-0 transition-all duration-1000 slide-content">
                        <span class="inline-block px-4 py-1.5 bg-emerald-600/20 text-emerald-400 rounded-full text-xs font-bold tracking-widest uppercase mb-6 border border-emerald-600/30">Natural Wonders</span>
                        <h1 class="text-4xl md:text-6xl lg:text-7xl font-serif text-white mb-8 leading-[1.1] md:whitespace-nowrap">Visit the <span class="text-emerald-500">Garden of Eden</span></h1>
                        <p class="text-xl text-slate-200 mb-12 leading-relaxed">Explore the Ngorongoro Crater, home to the highest density of big game in Africa.</p>
                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            <a href="/tours" class="w-full sm:w-auto px-10 py-4 bg-emerald-600 text-white font-bold rounded-full hover:bg-emerald-700 shadow-xl shadow-emerald-600/30 transition-all text-center">
                                Discover the Crater
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 4: Tarangire -->
            <div class="swiper-slide relative flex items-center">
                <div class="absolute inset-0 z-0">
                    <img src="https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046154/Angata-Tarangire-2-1-1536x863_amthnm.jpg" alt="Tarangire" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 via-slate-900/40 to-transparent"></div>
                </div>
                <div class="relative z-10 max-w-7xl mx-auto px-6 w-full pt-20">
                    <div class="max-w-2xl translate-y-10 opacity-0 transition-all duration-1000 slide-content">
                        <span class="inline-block px-4 py-1.5 bg-emerald-600/20 text-emerald-400 rounded-full text-xs font-bold tracking-widest uppercase mb-6 border border-emerald-600/30">Land of Giants</span>
                        <h1 class="text-4xl md:text-6xl lg:text-7xl font-serif text-white mb-8 leading-[1.1] md:whitespace-nowrap">Tarangire's <span class="text-emerald-500">Baobab Forests</span></h1>
                        <p class="text-xl text-slate-200 mb-12 leading-relaxed">Walk among ancient giants and massive elephant herds in one of Tanzania's most unique national parks.</p>
                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            <a href="/tours" class="w-full sm:w-auto px-10 py-4 bg-emerald-600 text-white font-bold rounded-full hover:bg-emerald-700 shadow-xl shadow-emerald-600/30 transition-all text-center">
                                View Tarangire Tours
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 5: Culture -->
            <div class="swiper-slide relative flex items-center">
                <div class="absolute inset-0 z-0">
                    <img src="https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766046195/hadzabe_qgukhh.jpg" alt="Hadzabe" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 via-slate-900/40 to-transparent"></div>
                </div>
                <div class="relative z-10 max-w-7xl mx-auto px-6 w-full pt-20">
                    <div class="max-w-2xl translate-y-10 opacity-0 transition-all duration-1000 slide-content">
                        <span class="inline-block px-4 py-1.5 bg-emerald-600/20 text-emerald-400 rounded-full text-xs font-bold tracking-widest uppercase mb-6 border border-emerald-600/30">Human Heritage</span>
                        <h1 class="text-4xl md:text-6xl lg:text-7xl font-serif text-white mb-8 leading-[1.1] md:whitespace-nowrap">The <span class="text-emerald-500">Hadzabe Tribe</span></h1>
                        <p class="text-xl text-slate-200 mb-12 leading-relaxed">Experience an authentic encounter with one of the last true hunter-gatherer tribes on Earth.</p>
                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            <a href="/tours" class="w-full sm:w-auto px-10 py-4 bg-emerald-600 text-white font-bold rounded-full hover:bg-emerald-700 transition-all text-center">
                                Cultural Expeditions
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 6: Elephants -->
            <div class="swiper-slide relative flex items-center">
                <div class="absolute inset-0 z-0">
                    <img src="https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766324498/long-range-shot-elephants-walking-grassy-field-near-trees_inlucz.jpg" alt="Elephants" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 via-slate-900/40 to-transparent"></div>
                </div>
                <div class="relative z-10 max-w-7xl mx-auto px-6 w-full pt-20">
                    <div class="max-w-2xl translate-y-10 opacity-0 transition-all duration-1000 slide-content">
                        <span class="inline-block px-4 py-1.5 bg-emerald-600/20 text-emerald-400 rounded-full text-xs font-bold tracking-widest uppercase mb-6 border border-emerald-600/30">Majestic Wildlife</span>
                        <h1 class="text-4xl md:text-6xl lg:text-7xl font-serif text-white mb-8 leading-[1.1] md:whitespace-nowrap">Wild <span class="text-emerald-500">Elephant Safaris</span></h1>
                        <p class="text-xl text-slate-200 mb-12 leading-relaxed">Follow the footsteps of these majestic creatures across the golden savannahs of Northern Tanzania.</p>
                        <div class="flex flex-col sm:sm:flex-row items-center gap-4">
                            <a href="/tours" class="w-full sm:w-auto px-10 py-4 bg-emerald-600 text-white font-bold rounded-full hover:bg-emerald-700 transition-all text-center">
                                Start Your Journey
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="absolute bottom-10 right-10 z-20 flex gap-4">
            <button class="swiper-prev w-14 h-14 rounded-full border border-white/20 bg-white/10 text-white flex items-center justify-center hover:bg-emerald-600 hover:border-emerald-600 transition-all backdrop-blur-md">
                <i class="ph ph-caret-left text-2xl"></i>
            </button>
            <button class="swiper-next w-14 h-14 rounded-full border border-white/20 bg-white/10 text-white flex items-center justify-center hover:bg-emerald-600 hover:border-emerald-600 transition-all backdrop-blur-md">
                <i class="ph ph-caret-right text-2xl"></i>
            </button>
        </div>

        <!-- Pagination -->
        <div class="swiper-pagination !bottom-10 !left-6 !text-left !w-auto"></div>
    </div>
</section>

<style>
    .swiper-pagination-bullet { width: 12px; height: 12px; background: rgba(255,255,255,0.3); opacity: 1; }
    .swiper-pagination-bullet-active { background: #10b981; width: 30px; border-radius: 6px; }
    .swiper-slide-active .slide-content { transform: translateY(0); opacity: 1; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swiper = new Swiper('.heroSwiper', {
            loop: true,
            speed: 1000,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-next',
                prevEl: '.swiper-prev',
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            }
        });
    });
</script>

<!-- Stats Bar -->
<section class="relative z-20 -mt-10 max-w-5xl mx-auto px-6">
    <div class="grid grid-cols-2 md:grid-cols-4 bg-white rounded-2xl shadow-2xl p-8 border border-slate-100 divide-x divide-slate-100">
        <div class="text-center px-4">
            <h3 class="text-4xl font-bold text-slate-900">2025</h3>
            <p class="text-sm text-slate-500 mt-2">Founded Year</p>
        </div>
        <div class="text-center px-4">
            <h3 class="text-4xl font-bold text-slate-900">1k+</h3>
            <p class="text-sm text-slate-500 mt-2">Tours Completed</p>
        </div>
        <div class="text-center px-4">
            <h3 class="text-4xl font-bold text-slate-900">150+</h3>
            <p class="text-sm text-slate-500 mt-2">Expert Guides</p>
        </div>
        <div class="text-center px-4">
            <h3 class="text-4xl font-bold text-slate-900">99%</h3>
            <p class="text-sm text-slate-500 mt-2">Happy Clients</p>
        </div>
    </div>
</section>

<!-- Featured Tours -->
<section class="py-32 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row items-end justify-between mb-16 gap-6">
            <div class="max-w-2xl">
                <h2 class="text-4xl font-serif text-slate-900 mb-6 font-bold">Most Popular Safari Packages</h2>
                <p class="text-slate-500">Carefully curated adventures that capture the very essence of the African wild. Choose your path and let us handle the rest.</p>
            </div>
            <a href="/tours" class="text-emerald-600 font-bold flex items-center gap-2 hover:gap-3 transition-all">
                View All Tours <i class="ph ph-arrow-right"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($featuredTours ?? [] as $tour)
            <!-- Tour Card -->
            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100">
                <div class="relative h-72 overflow-hidden">
                    @php $images = json_decode($tour->images, true); @endphp
                    <img src="{{ $images[0] ?? 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e' }}?auto=format&fit=crop&w=800&q=80" alt="{{ $tour->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-4 py-2 rounded-full text-xs font-bold text-slate-900 shadow-sm uppercase tracking-wider">
                        {{ $tour->duration_days }} Days
                    </div>
                </div>
                <div class="p-8">
                    <div class="flex items-center gap-2 text-emerald-500 text-sm font-bold mb-4">
                        <i class="ph-fill ph-star"></i>
                        <span class="text-slate-900">5.0</span>
                        <span class="text-slate-400 font-medium">(Verified)</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4 group-hover:text-emerald-600 transition-colors line-clamp-1">{{ $tour->name }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6 line-clamp-2">{{ $tour->description }}</p>
                    <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-slate-400 text-xs font-medium uppercase block">Starting from</span>
                            <span class="text-2xl font-bold text-slate-900 leading-none">${{ number_format($tour->base_price) }}</span>
                        </div>
                        <a href="{{ route('tours.show', $tour->id) }}" class="p-4 bg-slate-900 text-white rounded-2xl hover:bg-emerald-600 transition-colors">
                            <i class="ph ph-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 py-12 text-center text-slate-400 italic">
                Our featured expeditions are being updated. Check back soon!
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-32 relative overflow-hidden bg-slate-900">
    <div class="absolute top-0 right-0 w-1/2 h-full hidden lg:block">
        <img src="https://images.unsplash.com/photo-1493612276216-ee3925520721?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Safari Experience" class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/40 to-transparent"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="max-w-xl">
            <h2 class="text-4xl font-serif text-white mb-12 font-bold">Why choose LAU Paradise Adventure?</h2>
            
            <div class="space-y-12">
                <div class="flex gap-6">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-600/20 text-emerald-500 flex-shrink-0 flex items-center justify-center text-3xl">
                        <i class="ph-bold ph-sketch-logo"></i>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-white mb-4">Tailored Experience</h4>
                        <p class="text-slate-400 leading-relaxed">No two journeys are the same. We customize every detail to match your rhythm and expectations.</p>
                    </div>
                </div>
                
                <div class="flex gap-6">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-600/20 text-emerald-500 flex-shrink-0 flex items-center justify-center text-3xl">
                        <i class="ph-bold ph-shield-check"></i>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-white mb-4">Safety First</h4>
                        <p class="text-slate-400 leading-relaxed">Our vehicles are impeccably maintained and our guides are trained in wilderness first aid and safety protocols.</p>
                    </div>
                </div>
                
                <div class="flex gap-6">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-600/20 text-emerald-500 flex-shrink-0 flex items-center justify-center text-3xl">
                        <i class="ph-bold ph-leaf"></i>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-white mb-4">Sustainable Tourism</h4>
                        <p class="text-slate-400 leading-relaxed">We support local communities and practice eco-friendly operations to preserve the wild for generations.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-24 bg-emerald-600">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-4xl md:text-5xl font-serif text-white mb-8 font-bold">Ready for the Adventure of a Lifetime?</h2>
        <p class="text-emerald-100 text-xl max-w-2xl mx-auto mb-12">Contact our safari experts today and start planning your bespoke African experience.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
            <a href="/tours" class="px-12 py-5 bg-white text-emerald-600 font-bold rounded-full shadow-2xl hover:scale-105 transition-all">
                Book My Safari
            </a>
            <a href="https://wa.me/255683163219" class="flex items-center gap-3 text-white font-bold hover:scale-105 transition-all text-xl">
                <i class="ph-bold ph-whatsapp-logo text-3xl"></i> Chat on WhatsApp
            </a>
        </div>
    </div>
</section>
<!-- Testimonials -->
<section class="py-32 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-20">
            <span class="text-emerald-600 font-black text-xs uppercase tracking-[0.4em] mb-4 inline-block">Worldwide Recognition</span>
            <h2 class="text-4xl md:text-5xl font-serif text-slate-900 font-bold mb-6">Trusted by Adventurers</h2>
            <div class="flex items-center justify-center gap-8 opacity-60 grayscale hover:grayscale-0 transition-all duration-700">
                <img src="https://static.tacdn.com/img2/brand_refresh_2025/logos/wordmark.svg" alt="TripAdvisor" class="h-8">
                <img src="data:image/png;base64,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" alt="Google" class="h-8">
            </div>
        </div>

        <div class="swiper reviewsSwiper pb-16">
            <div class="swiper-wrapper">
                <!-- Review 1 -->
                <div class="swiper-slide">
                    <div class="bg-slate-50 rounded-[2.5rem] p-10 border border-slate-100 flex flex-col h-full">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex gap-1 text-yellow-400">
                                <i class="ph-fill ph-star"></i>
                                <i class="ph-fill ph-star"></i>
                                <i class="ph-fill ph-star"></i>
                                <i class="ph-fill ph-star"></i>
                                <i class="ph-fill ph-star"></i>
                            </div>
                            <img src="data:image/png;base64,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_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" alt="Google" class="h-6">
                        </div>
                        <p class="text-slate-600 text-lg leading-relaxed mb-10 italic">"Lau Paradise provided an exceptional 8-day Serengeti safari. Our guide, Emanuel, was incredibly knowledgeable about the wildlife. Every camp was perfectly chosen. 5 stars!"</p>
                        <div class="mt-auto flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-slate-200 overflow-hidden">
                                <img src="https://i.pravatar.cc/150?u=sarah" alt="Sarah Jenkins" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900">Sarah Jenkins</h4>
                                <p class="text-sm text-slate-500">United Kingdom</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review 2 -->
                <div class="swiper-slide">
                    <div class="bg-slate-50 rounded-[2.5rem] p-10 border border-slate-100 flex flex-col h-full">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex gap-1 text-emerald-500">
                                <i class="ph-fill ph-star"></i>
                                <i class="ph-fill ph-star"></i>
                                <i class="ph-fill ph-star"></i>
                                <i class="ph-fill ph-star"></i>
                                <i class="ph-fill ph-star"></i>
                            </div>
                            <img src="https://static.tacdn.com/img2/brand_refresh_2025/logos/wordmark.svg" alt="TripAdvisor" class="h-6">
                        </div>
                        <p class="text-slate-600 text-lg leading-relaxed mb-10 italic">"The Kilimanjaro trek via Lemosho was challenging but perfectly organized by the LAU team. The equipment was top-notch and the food on the mountain was surprisingly great!"</p>
                        <div class="mt-auto flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-slate-200 overflow-hidden">
                                <img src="https://i.pravatar.cc/150?u=marco" alt="Marco Rossi" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900">Marco Rossi</h4>
                                <p class="text-sm text-slate-500">Italy</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review 3 -->
                <div class="swiper-slide">
                    <div class="bg-slate-50 rounded-[2.5rem] p-10 border border-slate-100 flex flex-col h-full">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex gap-1 text-yellow-400">
                                <i class="ph-fill ph-star"></i>
                                <i class="ph-fill ph-star"></i>
                                <i class="ph-fill ph-star"></i>
                                <i class="ph-fill ph-star"></i>
                                <i class="ph-fill ph-star"></i>
                            </div>
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/2048px-Google_%22G%22_Logo.svg.png" alt="Google" class="h-6">
                        </div>
                        <p class="text-slate-600 text-lg leading-relaxed mb-10 italic">"Amazing cultural experience with the Hadzabe tribe. It felt authentic and respectful. Lau Paradise really understands how to provide ethical tourism in Tanzania."</p>
                        <div class="mt-auto flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-slate-200 overflow-hidden">
                                <img src="https://i.pravatar.cc/150?u=elena" alt="Elena Petrova" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900">Elena Petrova</h4>
                                <p class="text-sm text-slate-500">Germany</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review 4 -->
                <div class="swiper-slide">
                    <div class="bg-slate-50 rounded-[2.5rem] p-10 border border-slate-100 flex flex-col h-full">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex gap-1 text-emerald-500">
                                <i class="ph-fill ph-star"></i>
                                <i class="ph-fill ph-star"></i>
                                <i class="ph-fill ph-star"></i>
                                <i class="ph-fill ph-star"></i>
                                <i class="ph-fill ph-star"></i>
                            </div>
                            <img src="https://static.tacdn.com/img2/brand_refresh_2025/logos/wordmark.svg" alt="TripAdvisor" class="h-6">
                        </div>
                        <p class="text-slate-600 text-lg leading-relaxed mb-10 italic">"The best safari operator in Moshi. Their attention to detail and safety standards are unmatched. From pickup to drop-off, everything was professional."</p>
                        <div class="mt-auto flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-slate-200 overflow-hidden">
                                <img src="https://i.pravatar.cc/150?u=david" alt="David Thompson" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900">David Thompson</h4>
                                <p class="text-sm text-slate-500">USA</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination-reviews !bottom-0"></div>
        </div>
    </div>
</section>

<style>
    .swiper-pagination-reviews .swiper-pagination-bullet { width: 10px; height: 10px; background: #e2e8f0; opacity: 1; margin: 0 6px !important; }
    .swiper-pagination-reviews .swiper-pagination-bullet-active { background: #10b981; width: 24px; border-radius: 5px; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const reviewsSwiper = new Swiper('.reviewsSwiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination-reviews',
                clickable: true,
            },
            breakpoints: {
                640: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
            }
        });
    });
</script>

@endsection
