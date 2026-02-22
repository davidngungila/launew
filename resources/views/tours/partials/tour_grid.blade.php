<div id="tour-grid-container">
    <!-- Tours Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @forelse ($tours as $tour)
        <div class="group bg-white rounded-[2rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100">
            <div class="relative h-64 overflow-hidden">
                @php $images = $tour->images ?? []; @endphp
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
    <div class="mt-20 flex justify-center pagination-premium">
        {{ $tours->appends(request()->query())->links() }}
    </div>
    
    <div class="mt-8 text-center text-slate-500 text-sm">
        Showing <span class="text-slate-900 font-bold font-serif">{{ $tours->firstItem() }}</span> to <span class="text-slate-900 font-bold font-serif">{{ $tours->lastItem() }}</span> of <span class="text-slate-900 font-bold font-serif">{{ $tours->total() }}</span> safari packages
    </div>
</div>
