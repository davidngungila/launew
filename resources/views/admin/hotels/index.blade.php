@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Hotels & Lodges</h1>
            <p class="text-slate-500 font-medium">Manage your partner accommodations and contracts</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <i class="ph ph-plus"></i>
                Register Hotel
            </button>
        </div>
    </div>

    <!-- Inventory Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        @foreach([
            ['name' => 'Serengeti Serene Lodge', 'loc' => 'Central Serengeti', 'type' => 'Luxury Lodge', 'rooms' => 12, 'price' => '$450/nt', 'rating' => '5.0', 'img' => 'https://images.unsplash.com/photo-1493612276216-ee3925520721?auto=format&fit=crop&w=400&q=80'],
            ['name' => 'Ngorongoro Farm House', 'loc' => 'Karatu Area', 'type' => 'Eco Lodge', 'rooms' => 24, 'price' => '$280/nt', 'rating' => '4.8', 'img' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=400&q=80'],
            ['name' => 'Tarangire Treetops', 'loc' => 'Tarangire NP', 'type' => 'Adventure Lodge', 'rooms' => 8, 'price' => '$520/nt', 'rating' => '5.0', 'img' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=400&q=80'],
            ['name' => 'Zanzibar Pearl Resort', 'loc' => 'Matemwe Beach', 'type' => 'Beachfront', 'rooms' => 30, 'price' => '$320/nt', 'rating' => '4.7', 'img' => 'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?auto=format&fit=crop&w=400&q=80'],
        ] as $hotel)
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden group hover:shadow-2xl transition-all duration-500">
            <div class="relative h-48 overflow-hidden">
                <img src="{{ $hotel['img'] }}" alt="{{ $hotel['name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6">
                    <span class="px-2 py-0.5 rounded-lg bg-emerald-500 text-white text-[9px] font-black uppercase tracking-widest mb-2 inline-block shadow-lg shadow-emerald-500/20">{{ $hotel['type'] }}</span>
                    <h3 class="text-lg font-black text-white leading-tight tracking-tight">{{ $hotel['name'] }}</h3>
                </div>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1 text-orange-500">
                        <i class="ph-fill ph-star text-sm"></i>
                        <span class="text-xs font-black text-slate-900">{{ $hotel['rating'] }}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest block">Contracted Rate</span>
                        <span class="text-sm font-black text-emerald-600 block">{{ $hotel['price'] }}</span>
                    </div>
                </div>
                <div class="pt-4 border-t border-slate-50 flex items-center justify-between text-slate-500">
                    <div class="flex items-center gap-2">
                        <i class="ph ph-map-pin"></i>
                        <span class="text-xs font-bold">{{ $hotel['loc'] }}</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <i class="ph ph-bed"></i>
                        <span class="text-xs font-bold">{{ $hotel['rooms'] }} Units</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
