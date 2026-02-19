@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Business Analytics</h1>
            <p class="text-slate-500 font-medium">Deep dive into your sales performance and search trends</p>
        </div>
        <div class="flex items-center gap-3">
            <select class="px-6 py-3 border border-slate-200 rounded-2xl bg-white text-sm font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all shadow-sm">
                <option>Last 30 Days</option>
                <option>Last Quarter</option>
                <option>Annual View</option>
            </select>
        </div>
    </div>

    <!-- Analytics Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Revenue Growth -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <h3 class="text-lg font-black text-slate-900 tracking-tight mb-8">Monthly Revenue Growth</h3>
            <div class="h-64 flex items-end justify-between gap-2">
                @foreach([
                    ['m' => 'Sep', 'v' => 40],
                    ['m' => 'Oct', 'v' => 65],
                    ['m' => 'Nov', 'v' => 55],
                    ['m' => 'Dec', 'v' => 90],
                    ['m' => 'Jan', 'v' => 75],
                    ['m' => 'Feb', 'v' => 85]
                ] as $data)
                <div class="flex-grow flex flex-col items-center gap-4 group">
                    <div class="relative w-full">
                         <div class="w-full bg-emerald-100 rounded-xl group-hover:bg-emerald-500 transition-all duration-500" style="height: {{ $data['v'] * 2 }}px"></div>
                         <div class="absolute -top-8 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity bg-slate-900 text-white text-[10px] font-black px-2 py-1 rounded shadow-xl">{{ $data['v'] }}k</div>
                    </div>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $data['m'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Booking Sources -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <h3 class="text-lg font-black text-slate-900 tracking-tight mb-8">Booking Sources</h3>
            <div class="space-y-6">
                @foreach([
                    ['src' => 'Direct Website', 'p' => 58, 'c' => 'emerald'],
                    ['src' => 'WhatsApp / Social', 'p' => 24, 'c' => 'blue'],
                    ['src' => 'Partner Agencies', 'p' => 12, 'c' => 'purple'],
                    ['src' => 'Referrals', 'p' => 6, 'c' => 'slate']
                ] as $src)
                <div>
                    <div class="flex justify-between text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">
                        <span>{{ $src['src'] }}</span>
                        <span>{{ $src['p'] }}%</span>
                    </div>
                    <div class="w-full h-2 bg-slate-50 rounded-full overflow-hidden">
                        <div class="h-full bg-{{ $src['c'] }}-500 rounded-full" style="width: {{ $src['p'] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-12 pt-8 border-t border-slate-50 flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Top Selling Package</p>
                    <p class="text-sm font-black text-slate-900 mt-1">Serengeti Classic Migration</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Avg. Booking Value</p>
                    <p class="text-sm font-black text-emerald-600 mt-1">$4,820.00</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
