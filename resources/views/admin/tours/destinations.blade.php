@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Destinations</h1>
            <p class="text-slate-500 font-medium">Manage destination labels used across tours and region pages</p>
        </div>
        <a href="{{ route('admin.tours.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Back to tours</a>
    </div>

    @php
        $destinations = \App\Models\Tour::query()
            ->select('location')
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->distinct()
            ->orderBy('location')
            ->pluck('location');
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-7 bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Found destinations</p>
                    <h3 class="text-xl font-black text-slate-900 mt-2">{{ $destinations->count() }}</h3>
                </div>
                <a href="{{ route('tours.index') }}" target="_blank" class="px-5 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/10">View public tours</a>
            </div>

            @if($destinations->count() === 0)
                <p class="text-slate-500 font-medium">No destinations yet. Create a tour with a destination in the Location field.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($destinations as $d)
                        <div class="p-5 rounded-2xl border border-slate-100 bg-slate-50">
                            <p class="text-sm font-black text-slate-900">{{ $d }}</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Used in tours</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="lg:col-span-5 bg-slate-900 p-10 rounded-[2.5rem] shadow-2xl text-white space-y-6">
            <p class="text-[10px] font-black uppercase tracking-widest text-white/50">Notes</p>
            <p class="text-slate-300 font-medium leading-relaxed">Right now destinations are derived from the `tours.location` field. If you want a full Destinations module (with icons, images, slugs, and SEO), we can add a `destinations` table and relate tours to destinations.</p>

            <div class="space-y-3">
                <a href="{{ route('admin.tours.create') }}" class="w-full inline-flex items-center justify-center gap-3 px-8 py-4 bg-emerald-600 text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-emerald-700 transition-all">
                    <i class="ph ph-plus"></i>
                    Add tour
                </a>
                <a href="{{ route('admin.tours.itinerary-builder') }}" class="w-full inline-flex items-center justify-center gap-3 px-8 py-4 bg-white/5 border border-white/10 text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-white/10 transition-all">
                    <i class="ph ph-list-checks"></i>
                    Itinerary builder
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
