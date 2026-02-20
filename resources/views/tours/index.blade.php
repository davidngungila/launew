@extends('layouts.public')

@section('content')
<!-- Page Header -->
<section class="relative pt-40 pb-20 bg-slate-900 overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1549366021-9f761d450615?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" alt="Tours" class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/40 to-slate-900"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-6 text-center">
        <h1 class="text-5xl md:text-6xl font-serif text-white mb-6 font-bold">Discover Our Safaris</h1>
        <p class="text-slate-300 max-w-2xl mx-auto">Explore a range of safari packages designed to bring you closer to nature. From luxury lodges to camping under the stars.</p>
    </div>
</section>

<!-- Tours Section -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Filters -->
        <div class="flex flex-col lg:flex-row items-center justify-between mb-16 gap-8 bg-slate-50 p-6 rounded-3xl border border-slate-100">
            <div class="flex flex-wrap items-center gap-4">
                <div class="relative">
                    <select class="appearance-none bg-white border border-slate-200 rounded-2xl px-6 py-3 pr-12 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                        <option>Destination: All</option>
                        <option>Serengeti</option>
                        <option>Ngorongoro</option>
                        <option>Kilimanjaro</option>
                        <option>Tarangire</option>
                    </select>
                    <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                </div>
                
                <div class="relative">
                    <select class="appearance-none bg-white border border-slate-200 rounded-2xl px-6 py-3 pr-12 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                    </select>
                    <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                </div>
                
                <div class="relative">
                    <select class="appearance-none bg-white border border-slate-200 rounded-2xl px-6 py-3 pr-12 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                        <option>Duration: Any</option>
                        <option>1-3 Days</option>
                        <option>4-7 Days</option>
                        <option>8+ Days</option>
                    </select>
                    <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                </div>
            </div>
            
            <div class="text-slate-500 text-sm">
                Showing <span class="text-slate-900 font-bold font-serif">{{ $tours->count() }}</span> safari packages
            </div>
        </div>
        
        <!-- Tours Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse ($tours as $tour)
            <div class="group bg-white rounded-[2rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100">
                <div class="relative h-64 overflow-hidden">
                    @php $images = json_decode($tour->images, true) ?? []; @endphp
                    <img src="{{ $images[0] ?? 'https://images.unsplash.com/photo-1516426122078-c23e76319801' }}?auto=format&fit=crop&w=800&q=80" alt="{{ $tour->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md p-2 rounded-full text-emerald-500 shadow-sm">
                        <i class="ph-bold ph-heart text-xl"></i>
                    </div>
                </div>
                <div class="p-8">
                    <div class="flex items-center gap-3 text-xs font-bold text-emerald-600 uppercase tracking-widest mb-4">
                        <span class="flex items-center gap-1"><i class="ph ph-map-pin"></i> {{ Str::before($tour->location, ',') }}</span>
                        <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                        <span class="flex items-center gap-1"><i class="ph ph-clock"></i> {{ $tour->duration_days }} Days</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4 group-hover:text-emerald-600 transition-colors line-clamp-1">{{ $tour->name }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-8 line-clamp-2">{{ $tour->description }}</p>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-widest block mb-1">Per Person</span>
                            <span class="text-2xl font-bold text-slate-900">${{ number_format($tour->base_price) }}</span>
                        </div>
                        <a href="{{ route('tours.show', $tour->id) }}" class="inline-flex items-center gap-2 bg-slate-900 text-white px-6 py-3 rounded-2xl font-bold hover:bg-emerald-600 transition-colors">
                            Details <i class="ph ph-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-20 bg-slate-50 rounded-[3rem] text-center border-2 border-dashed border-slate-200">
                <p class="text-slate-400 font-bold uppercase tracking-[0.2em] mb-2">No Expeditions Found</p>
                <p class="text-slate-500">We are currently preparing more amazing adventures for you. Please check back later.</p>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="mt-20 flex justify-center">
            <nav class="flex items-center gap-2">
                <button class="w-12 h-12 rounded-2xl border border-slate-200 flex items-center justify-center text-slate-400 hover:border-emerald-500 hover:text-emerald-500 transition-all">
                    <i class="ph ph-caret-left"></i>
                </button>
                <button class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-bold">1</button>
                <button class="w-12 h-12 rounded-2xl border border-slate-200 flex items-center justify-center font-bold text-slate-600 hover:border-emerald-500 hover:text-emerald-500 transition-all">2</button>
                <button class="w-12 h-12 rounded-2xl border border-slate-200 flex items-center justify-center font-bold text-slate-600 hover:border-emerald-500 hover:text-emerald-500 transition-all">3</button>
                <button class="w-12 h-12 rounded-2xl border border-slate-200 flex items-center justify-center text-slate-400 hover:border-emerald-500 hover:text-emerald-500 transition-all">
                    <i class="ph ph-caret-right"></i>
                </button>
            </nav>
        </div>
    </div>
</section>
@endsection
