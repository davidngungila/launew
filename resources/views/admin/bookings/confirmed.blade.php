@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Confirmed Trips</h1>
            <p class="text-slate-500 font-medium">Logistics and execution status of your upcoming safaris</p>
        </div>
        <div class="flex items-center gap-3">
             <button class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                <i class="ph ph-printer"></i>
                Manifests
            </button>
        </div>
    </div>

    <!-- Timeline Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach([
            ['id' => 'BK-9281', 'client' => 'Michael Corleone', 'tour' => '8 Days Northern Circuit', 'start' => 'Oct 12', 'guide' => 'Elias Mwita', 'vehicle' => 'T-821-LAU', 'status' => 'Preparing', 'color' => 'blue'],
            ['id' => 'BK-9283', 'client' => 'Daenerys Targaryen', 'tour' => '14 Days Odyssey', 'start' => 'Dec 22', 'guide' => 'Peter Mabula', 'vehicle' => 'T-505-LAU', 'status' => 'Ready', 'color' => 'emerald'],
            ['id' => 'BK-9290', 'client' => 'Tyrion Lannister', 'tour' => '5 Days Tarangire', 'start' => 'Oct 15', 'guide' => 'John Doe', 'vehicle' => 'T-101-LAU', 'status' => 'In Prep', 'color' => 'indigo'],
        ] as $trip)
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden group hover:shadow-2xl transition-all duration-500 border-l-8 border-{{ $trip['color'] }}-500">
            <div class="p-8">
                <div class="flex items-center justify-between mb-6">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Scheduled: {{ $trip['start'] }}</span>
                    <span class="px-2.5 py-1 bg-{{ $trip['color'] }}-50 text-{{ $trip['color'] }}-600 text-[9px] font-black rounded-lg uppercase tracking-widest">{{ $trip['status'] }}</span>
                </div>
                
                <h3 class="text-xl font-black text-slate-900 tracking-tight mb-1">{{ $trip['client'] }}</h3>
                <p class="text-sm font-bold text-slate-500 mb-8">{{ $trip['tour'] }}</p>

                <div class="space-y-4 pt-6 border-t border-slate-50">
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400">
                            <i class="ph-bold ph-user"></i>
                        </div>
                        <div>
                             <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Lead Guide</p>
                             <p class="text-xs font-black text-slate-900">{{ $trip['guide'] }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400">
                            <i class="ph-bold ph-jeep"></i>
                        </div>
                        <div>
                             <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Assigned Fleet</p>
                             <p class="text-xs font-black text-slate-900">{{ $trip['vehicle'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-50 flex gap-2">
                    <button class="flex-grow py-3 bg-slate-50 hover:bg-emerald-50 text-slate-400 hover:text-emerald-600 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Manage Docs</button>
                    <button class="w-12 h-12 bg-slate-50 hover:bg-blue-50 text-slate-400 hover:text-blue-600 rounded-xl flex items-center justify-center transition-all"><i class="ph-bold ph-dots-three-outline text-xl"></i></button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
