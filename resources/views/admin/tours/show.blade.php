@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">{{ $tour->name }}</h1>
            <p class="text-slate-500 font-medium">{{ $tour->location }} · {{ $tour->duration_days }} days</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.tours.itinerary-builder', ['tour_id' => $tour->id]) }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                <i class="ph ph-list-checks"></i>
                Itinerary Builder
            </a>
            <a href="{{ route('admin.tours.edit', $tour) }}" class="px-5 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/10 flex items-center gap-2">
                <i class="ph ph-pencil-simple"></i>
                Edit
            </a>
            <form action="{{ route('admin.tours.destroy', $tour) }}" method="POST" onsubmit="return confirm('Delete this tour?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-5 py-2.5 bg-white border border-red-200 text-red-600 font-bold rounded-xl hover:bg-red-50 transition-all shadow-sm flex items-center gap-2">
                    <i class="ph ph-trash"></i>
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Description</p>
                <p class="text-slate-700 font-medium leading-relaxed">{{ $tour->description ?: 'No description provided.' }}</p>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-6">Package Includes</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Price</p>
                        <p class="text-xl font-black text-slate-900">${{ number_format($tour->base_price) }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Status</p>
                        <p class="text-sm font-black text-emerald-700">{{ ucfirst($tour->status) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-5 space-y-6">
            <div class="bg-slate-900 p-8 rounded-[2.5rem] shadow-2xl text-white">
                <p class="text-[10px] font-black uppercase tracking-widest text-white/50 mb-3">Tour meta</p>
                <div class="space-y-3 text-sm font-bold">
                    <div class="flex items-center justify-between"><span class="text-white/60">Featured</span><span>{{ $tour->featured ? 'Yes' : 'No' }}</span></div>
                    <div class="flex items-center justify-between"><span class="text-white/60">Slug</span><span class="font-mono text-xs">{{ $tour->slug }}</span></div>
                </div>
            </div>

            <a href="{{ route('admin.tours.index') }}" class="block text-center px-8 py-4 bg-white border border-slate-200 text-slate-700 font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-slate-50 transition-all">Back to tours</a>
        </div>
    </div>
</div>
@endsection
