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
            <button class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                <i class="ph ph-folder-open"></i>
                Categories
            </button>
            <a href="{{ route('admin.tours.create') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <i class="ph ph-plus"></i>
                Add New Tour
            </a>
        </div>
    </div>

    <!-- Tours Feed / Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        @php
            $sampleTours = [
                ['name' => 'Serengeti Classic Migration', 'location' => 'Serengeti National Park', 'days' => 5, 'price' => '$1,480', 'status' => 'Active', 'bookings' => 124, 'img' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=400&q=80'],
                ['name' => 'Mount Kilimanjaro - Machame', 'location' => 'Mount Kilimanjaro', 'days' => 7, 'price' => '$2,250', 'status' => 'Active', 'bookings' => 86, 'img' => 'https://images.unsplash.com/photo-1589192339357-d18e9d290c0a?auto=format&fit=crop&w=400&q=80'],
                ['name' => 'Ngorongoro Crater Day Trip', 'location' => 'Ngorongoro Conservation Area', 'days' => 1, 'price' => '$450', 'status' => 'Draft', 'bookings' => 0, 'img' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&w=400&q=80'],
                ['name' => 'Zanzibar Spice & Beach', 'location' => 'Stone Town & Nungwi', 'days' => 4, 'price' => '$890', 'status' => 'Active', 'bookings' => 212, 'img' => 'https://images.unsplash.com/photo-1493612276216-ee3925520721?auto=format&fit=crop&w=400&q=80'],
                ['name' => 'Tarangire Elephant Safari', 'location' => 'Tarangire National Park', 'days' => 2, 'price' => '$680', 'status' => 'Inactive', 'bookings' => 45, 'img' => 'https://images.unsplash.com/photo-1523805081730-614449379e70?auto=format&fit=crop&w=400&q=80'],
                ['name' => 'Lake Manyara Bird Watching', 'location' => 'Lake Manyara', 'days' => 2, 'price' => '$520', 'status' => 'Active', 'bookings' => 38, 'img' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=400&q=80'],
            ];
            
            // If real tours exist, we could use them, but we'll use sample for "page implementation with sample data"
            $displayTours = (!empty($tours) && count($tours) > 0) ? $tours : $sampleTours;
        @endphp

        @foreach($displayTours as $tour)
        @php
            $isObj = is_object($tour);
            $name = $isObj ? $tour->name : $tour['name'];
            $loc = $isObj ? $tour->location : $tour['location'];
            $days = $isObj ? $tour->duration_days : $tour['days'];
            $price = $isObj ? '$'.number_format($tour->base_price) : $tour['price'];
            $status = $isObj ? ucfirst($tour->status) : $tour['status'];
            $img = $isObj ? 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=400&q=80' : $tour['img'];
            $bookingsCount = $isObj ? 0 : $tour['bookings'];
            
            $statusColor = match($status) {
                'Active' => 'emerald',
                'Draft' => 'orange',
                'Inactive' => 'red',
                default => 'slate',
            };
        @endphp
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden group hover:shadow-2xl transition-all duration-500">
            <div class="relative h-56 overflow-hidden">
                <img src="{{ $img }}" alt="{{ $name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-x-0 bottom-0 h-2/3 bg-gradient-to-t from-black/80 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2.5 py-1 rounded-lg bg-{{ $statusColor }}-500 text-white text-[9px] font-black uppercase tracking-widest shadow-lg shadow-{{ $statusColor }}-500/40">
                            {{ $status }}
                        </span>
                        <span class="px-2.5 py-1 rounded-lg bg-white/20 backdrop-blur-md text-white text-[9px] font-black uppercase tracking-widest">
                            {{ $days }} DAYS
                        </span>
                    </div>
                    <h3 class="text-lg font-black text-white leading-tight tracking-tight">{{ $name }}</h3>
                </div>
                <button class="absolute top-6 right-6 w-10 h-10 bg-white/10 backdrop-blur-md border border-white/20 text-white rounded-xl flex items-center justify-center hover:bg-emerald-500 hover:border-emerald-400 transition-all group/btn">
                    <i class="ph-bold ph-pencil-simple text-xl group-hover/btn:scale-110 transition-transform"></i>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex flex-col">
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Starting From</span>
                        <span class="text-xl font-black text-slate-900">{{ $price }}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Total Bookings</span>
                        <span class="text-sm font-black text-emerald-600 block">{{ $bookingsCount }}</span>
                    </div>
                </div>
                
                <div class="pt-4 border-t border-slate-50 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-slate-500">
                        <i class="ph-bold ph-map-pin"></i>
                        <span class="text-xs font-bold truncate max-w-[150px]">{{ $loc }}</span>
                    </div>
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center text-[10px] font-black">AD</div>
                        <div class="w-8 h-8 rounded-full border-2 border-white bg-emerald-100 flex items-center justify-center text-[10px] font-black text-emerald-600">JS</div>
                        <div class="w-8 h-8 rounded-full border-2 border-white bg-blue-500 flex items-center justify-center text-[10px] font-black text-white">+{{ rand(5,20) }}</div>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-3 pt-2">
                    <button class="py-3 bg-slate-50 text-slate-600 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-slate-100 transition-all">Duplicate</button>
                    <button class="py-3 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-100 transition-all">Manage Dates</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Empty State Fallback handled in grid if necessary -->
</div>
@endsection
