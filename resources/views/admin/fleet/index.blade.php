@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Fleet & Team</h1>
            <p class="text-slate-500 font-medium">Manage your 4x4 Safari vehicles and professional guides</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                <i class="ph ph-user-plus"></i>
                Add Guide
            </button>
            <button class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <i class="ph ph-plus"></i>
                Register Vehicle
            </button>
        </div>
    </div>

    <!-- Stats Top Row -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @foreach([
            ['label' => 'Registered Fleet', 'val' => '12 Vehicles', 'icon' => 'jeep', 'color' => 'emerald'],
            ['label' => 'Total Guides', 'val' => '18 Professional', 'icon' => 'users-four', 'color' => 'blue'],
            ['label' => 'Currently on Road', 'val' => '5 Tours', 'icon' => 'map-trifold', 'color' => 'orange'],
            ['label' => 'Under Maintenance', 'val' => '2 Vehicles', 'icon' => 'wrench', 'color' => 'red'],
        ] as $stat)
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-{{ $stat['color'] }}-50 text-{{ $stat['color'] }}-600 flex items-center justify-center mb-4">
                <i class="ph-bold ph-{{ $stat['icon'] }} text-xl"></i>
            </div>
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">{{ $stat['label'] }}</p>
            <h4 class="text-xl font-black text-slate-900 leading-tight">{{ $stat['val'] }}</h4>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Vehicle Status -->
        <div class="space-y-4">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-xl font-black text-slate-900 tracking-tight">Vehicle Management</h3>
                <a href="#" class="text-xs font-black text-emerald-600 uppercase tracking-widest">Manage Fleet</a>
            </div>
            <div class="grid grid-cols-1 gap-4">
                @foreach([
                    ['name' => 'Safari Land Cruiser (Extended)', 'plate' => 'T 992 ACZ', 'status' => 'Available', 'color' => 'emerald'],
                    ['name' => 'Toyota Land Cruiser 70', 'plate' => 'T 114 DFG', 'status' => 'On Safari', 'color' => 'orange'],
                    ['name' => 'Safari Cruiser Premium', 'plate' => 'T 556 KLH', 'status' => 'Maintenance', 'color' => 'red'],
                ] as $vehicle)
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-6 group hover:border-emerald-200 transition-all">
                    <div class="w-20 h-20 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-300 relative overflow-hidden flex-shrink-0">
                        <i class="ph-bold ph-jeep text-4xl relative z-10"></i>
                    </div>
                    <div class="flex-grow">
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="text-sm font-black text-slate-900">{{ $vehicle['name'] }}</h4>
                            <span class="text-[10px] font-black px-2 py-0.5 rounded-md bg-{{ $vehicle['color'] }}-100 text-{{ $vehicle['color'] }}-600 uppercase tracking-widest">{{ $vehicle['status'] }}</span>
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ $vehicle['plate'] }}</p>
                        <div class="mt-3 flex items-center gap-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                            <span class="flex items-center gap-1.5"><i class="ph-fill ph-gas-can text-slate-300"></i> Full Tank</span>
                            <span class="flex items-center gap-1.5"><i class="ph-fill ph-gauge text-slate-300"></i> 12,400 KM</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Driver / Guide Management -->
        <div class="space-y-4">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-xl font-black text-slate-900 tracking-tight">Our Elite Guides</h3>
                <a href="#" class="text-xs font-black text-emerald-600 uppercase tracking-widest">View All Staff</a>
            </div>
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="divide-y divide-slate-50">
                    @foreach([
                        ['name' => 'Peter Mabula', 'role' => 'Senior Naturalist', 'exp' => '12 Years', 'rating' => 5.0, 'status' => 'Leading Tour'],
                        ['name' => 'David Kileo', 'role' => 'Kili Head Guide', 'exp' => '15 Years', 'rating' => 4.9, 'status' => 'Off Duty'],
                        ['name' => 'Sarah Mwakitosi', 'role' => 'Zanzibar Specialist', 'exp' => '6 Years', 'rating' => 4.8, 'status' => 'Available'],
                        ['name' => 'Emmanuel Richard', 'role' => 'Wildlife Photographer', 'exp' => '8 Years', 'rating' => 5.0, 'status' => 'Available'],
                    ] as $guide)
                    <div class="p-6 flex items-center gap-4 hover:bg-slate-50 transition-colors cursor-pointer group">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-black text-sm uppercase tracking-tighter">
                            {{ substr($guide['name'], 0, 1) }}{{ substr(strrchr($guide['name'], " "), 1, 1) }}
                        </div>
                        <div class="flex-grow">
                            <h4 class="text-sm font-black text-slate-900 leading-tight">{{ $guide['name'] }}</h4>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ $guide['role'] }} • {{ $guide['exp'] }} Exp</p>
                        </div>
                        <div class="text-right">
                           <div class="flex items-center gap-1 text-orange-500 mb-1 justify-end">
                               <i class="ph-fill ph-star text-xs"></i>
                               <span class="text-xs font-black text-slate-900">{{ number_format($guide['rating'], 1) }}</span>
                           </div>
                           <p class="text-[9px] font-black uppercase tracking-widest {{ $guide['status'] == 'Leading Tour' ? 'text-emerald-500' : 'text-slate-400' }}">{{ $guide['status'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
