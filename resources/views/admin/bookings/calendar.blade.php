@extends('layouts.admin')

@section('content')
<div class="h-[calc(100vh-10rem)] flex flex-col space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Booking Calendar</h1>
            <p class="text-slate-500 font-medium">Visual availability and scheduling timeline</p>
        </div>
        <div class="flex items-center gap-3">
             <div class="flex bg-white rounded-2xl p-1 border border-slate-200">
                <button class="px-5 py-2 hover:bg-slate-50 text-slate-400 font-bold text-xs rounded-xl transition-all">Day</button>
                <button class="px-5 py-2 hover:bg-slate-50 text-slate-400 font-bold text-xs rounded-xl transition-all">Week</button>
                <button class="px-5 py-2 bg-emerald-600 text-white font-black text-xs rounded-xl shadow-lg shadow-emerald-500/20">Month</button>
            </div>
            <div class="flex items-center gap-2">
                <button class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 hover:bg-slate-50 transition-all"><i class="ph ph-caret-left"></i></button>
                <span class="text-sm font-black text-slate-900 px-4">October 2026</span>
                <button class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 hover:bg-slate-50 transition-all"><i class="ph ph-caret-right"></i></button>
            </div>
        </div>
    </div>

    <!-- Calendar Grid -->
    <div class="flex-grow bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col">
        <!-- Weekdays Header -->
        <div class="grid grid-cols-7 border-b border-slate-100 bg-slate-50/50">
            @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
            <div class="py-4 text-center">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">{{ $day }}</span>
            </div>
            @endforeach
        </div>

        <!-- Days Grid -->
        <div class="flex-grow grid grid-cols-7 divide-x divide-y divide-slate-50 overflow-y-auto">
            @for ($i = 1; $i <= 35; $i++)
                @php
                    $dayNum = $i - 3; // Shift to start month correctly
                    $isCurrentMonth = $dayNum > 0 && $dayNum <= 31;
                    $hasBooking = $dayNum == 12 || $dayNum == 15 || $dayNum == 22;
                @endphp
                <div class="min-h-[140px] p-4 bg-{{ $isCurrentMonth ? 'white' : 'slate-50/30 opacity-50' }} transition-colors hover:bg-emerald-50/20">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm font-black {{ $dayNum == 19 ? 'text-emerald-600' : 'text-slate-900' }}">{{ $isCurrentMonth ? $dayNum : '' }}</span>
                        @if($isCurrentMonth && $dayNum == 19)
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-lg shadow-emerald-500/40"></span>
                        @endif
                    </div>

                    @if($hasBooking)
                        @foreach([1] as $b)
                        <div class="p-2 bg-emerald-900 text-white rounded-lg shadow-sm mb-2 cursor-pointer hover:scale-105 transition-transform">
                            <p class="text-[9px] font-black truncate">Michael C.</p>
                            <p class="text-[8px] font-bold opacity-70 truncate tracking-tight">8 Days Northern...</p>
                        </div>
                        @endforeach
                    @endif
                    
                    @if($dayNum == 22)
                         <div class="p-2 bg-indigo-600 text-white rounded-lg shadow-sm cursor-pointer hover:scale-105 transition-transform">
                            <p class="text-[9px] font-black truncate">Sarah J.</p>
                            <p class="text-[8px] font-bold opacity-70 truncate tracking-tight">Kili Trek...</p>
                        </div>
                    @endif
                </div>
            @endfor
        </div>
    </div>
</div>
@endsection
