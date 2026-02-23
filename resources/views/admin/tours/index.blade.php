@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Safari Packages</h1>
            <p class="text-slate-500 font-medium">Create and manage your exclusive African adventures</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.tours.destinations') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                <i class="ph ph-map-trifold"></i>
                Destinations
            </a>
            <a href="{{ route('admin.tours.availability-pricing') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                <i class="ph ph-tag"></i>
                Availability & Pricing
            </a>
            <a href="{{ route('admin.tours.itinerary-builder') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                <i class="ph ph-list-checks"></i>
                Itinerary Builder
            </a>
            <a href="{{ route('admin.tours.create') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <i class="ph ph-plus"></i>
                Add New Tour
            </a>
        </div>
    </div>

    <!-- Tours Feed / Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        @forelse($tours as $tour)
        @php
            $images = $tour->images ?? [];
            $img = is_array($images) && !empty($images) ? $images[0] : 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=400&q=80';
            $status = ucfirst($tour->status ?? 'draft');
            $statusColor = match($status) {
                'Active' => 'emerald',
                'Draft' => 'orange',
                'Inactive' => 'red',
                default => 'slate',
            };
        @endphp
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden group hover:shadow-2xl transition-all duration-500">
            <div class="relative h-56 overflow-hidden">
                <img src="{{ $img }}" alt="{{ $tour->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-x-0 bottom-0 h-2/3 bg-gradient-to-t from-black/80 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2.5 py-1 rounded-lg bg-{{ $statusColor }}-500 text-white text-[9px] font-black uppercase tracking-widest shadow-lg shadow-{{ $statusColor }}-500/40">
                            {{ $status }}
                        </span>
                        <span class="px-2.5 py-1 rounded-lg bg-white/20 backdrop-blur-md text-white text-[9px] font-black uppercase tracking-widest">
                            {{ $tour->duration_days }} DAYS
                        </span>
                    </div>
                    <h3 class="text-lg font-black text-white leading-tight tracking-tight">{{ $tour->name }}</h3>
                </div>
                <div class="absolute top-6 right-6 flex items-center gap-2">
                    <a href="{{ route('admin.tours.show', $tour) }}" class="w-10 h-10 bg-white/10 backdrop-blur-md border border-white/20 text-white rounded-xl flex items-center justify-center hover:bg-white/20 transition-all">
                        <i class="ph-bold ph-eye text-lg"></i>
                    </a>
                    <a href="{{ route('admin.tours.itinerary-builder', ['tour_id' => $tour->id]) }}" class="w-10 h-10 bg-white/10 backdrop-blur-md border border-white/20 text-white rounded-xl flex items-center justify-center hover:bg-emerald-500 hover:border-emerald-400 transition-all group/btn" title="Itinerary Builder">
                        <i class="ph-bold ph-list-checks text-xl group-hover/btn:scale-110 transition-transform"></i>
                    </a>
                    <a href="{{ route('admin.tours.edit', $tour) }}" class="w-10 h-10 bg-white/10 backdrop-blur-md border border-white/20 text-white rounded-xl flex items-center justify-center hover:bg-emerald-500 hover:border-emerald-400 transition-all group/btn">
                        <i class="ph-bold ph-pencil-simple text-xl group-hover/btn:scale-110 transition-transform"></i>
                    </a>
                </div>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex flex-col">
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Starting From</span>
                        <span class="text-xl font-black text-slate-900">${{ number_format($tour->base_price) }}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Total Bookings</span>
                        <span class="text-sm font-black text-emerald-600 block">0</span>
                    </div>
                </div>
                
                <div class="pt-4 border-t border-slate-50 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-slate-500">
                        <i class="ph-bold ph-map-pin"></i>
                        <span class="text-xs font-bold truncate max-w-[150px]">{{ $tour->location }}</span>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">ID #{{ $tour->id }}</span>
                </div>
                
                <div class="grid grid-cols-2 gap-3 pt-2">
                    <a href="{{ route('admin.tours.show', $tour) }}" class="py-3 bg-slate-50 text-slate-600 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-slate-100 transition-all text-center">View</a>
                    <a href="{{ route('admin.tours.itinerary-builder', ['tour_id' => $tour->id]) }}" class="py-3 bg-white border border-slate-200 text-slate-700 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 transition-all text-center">Itinerary</a>
                    <form action="{{ route('admin.tours.destroy', $tour) }}" method="POST" onsubmit="return confirm('Delete this tour?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-3 bg-rose-50 text-rose-600 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-rose-100 transition-all">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
            <div class="col-span-full bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-10 text-center">
                <h3 class="text-xl font-black text-slate-900">No tours yet</h3>
                <p class="text-slate-500 font-medium mt-2">Create your first package to start selling safaris.</p>
                <a href="{{ route('admin.tours.create') }}" class="inline-flex items-center gap-2 mt-6 px-8 py-4 bg-emerald-600 text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-emerald-700 transition-all">
                    <i class="ph ph-plus"></i>
                    Add New Tour
                </a>
            </div>
        @endforelse
    </div>

    <!-- Empty State Fallback handled in grid if necessary -->
</div>
@endsection
