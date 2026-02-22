@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Itinerary Builder</h1>
            <p class="text-slate-500 font-medium">Build day-by-day itineraries for your tours (drag & drop coming next)</p>
        </div>
        <a href="{{ route('admin.tours.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Back to tours</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-5 bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-6">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Select a tour</p>
            <div class="space-y-3">
                @foreach(\App\Models\Tour::orderBy('name')->limit(12)->get() as $t)
                    <a href="{{ route('admin.tours.show', $t) }}" class="block p-4 rounded-2xl border border-slate-100 hover:bg-slate-50 transition-all">
                        <p class="text-sm font-black text-slate-900">{{ $t->name }}</p>
                        <p class="text-xs font-bold text-slate-500">{{ $t->location }} · {{ $t->duration_days }} days</p>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="lg:col-span-7 bg-slate-900 p-10 rounded-[2.5rem] shadow-2xl text-white space-y-6">
            <p class="text-[10px] font-black uppercase tracking-widest text-white/50">Builder status</p>
            <h2 class="text-2xl font-black">Ready</h2>
            <p class="text-slate-300 font-medium leading-relaxed">This page is connected and working. Next step is to store itineraries in the database (e.g. `tour_itineraries` table) and provide a full drag-and-drop editor.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <p class="text-[10px] font-black uppercase tracking-widest text-white/50 mb-2">Coming next</p>
                    <ul class="text-sm font-bold text-slate-200 space-y-2">
                        <li>Day-by-day blocks</li>
                        <li>Hotel/lodge assignment</li>
                        <li>Meal plan & activities</li>
                        <li>PDF itinerary export</li>
                    </ul>
                </div>
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <p class="text-[10px] font-black uppercase tracking-widest text-white/50 mb-2">Quick links</p>
                    <div class="space-y-2">
                        <a class="block text-sm font-black text-emerald-300 hover:text-emerald-200" href="{{ route('admin.tours.availability-pricing') }}">Availability & Pricing</a>
                        <a class="block text-sm font-black text-emerald-300 hover:text-emerald-200" href="{{ route('admin.tours.destinations') }}">Destinations</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
