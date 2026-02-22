@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Availability & Pricing</h1>
            <p class="text-slate-500 font-medium">Manage pricing rules and availability windows for each tour</p>
        </div>
        <a href="{{ route('admin.tours.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Back to tours</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-7 bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-6">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Current setup</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Base pricing</p>
                    <p class="text-sm font-bold text-slate-700">Uses `tours.base_price` as default</p>
                </div>
                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">International range</p>
                    <p class="text-sm font-bold text-slate-700">Uses `international_price_min/max` when set</p>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <p class="text-slate-500 font-medium">This page is working and accessible. Next step is to add database tables for seasonal rates, group discounts, and date-based availability.</p>
            </div>
        </div>

        <div class="lg:col-span-5 bg-slate-900 p-10 rounded-[2.5rem] shadow-2xl text-white space-y-6">
            <p class="text-[10px] font-black uppercase tracking-widest text-white/50">Quick actions</p>
            <div class="space-y-3">
                <a href="{{ route('admin.tours.create') }}" class="w-full inline-flex items-center justify-center gap-3 px-8 py-4 bg-emerald-600 text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-emerald-700 transition-all">
                    <i class="ph ph-plus"></i>
                    Add new tour
                </a>
                <a href="{{ route('admin.tours.destinations') }}" class="w-full inline-flex items-center justify-center gap-3 px-8 py-4 bg-white/5 border border-white/10 text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-white/10 transition-all">
                    <i class="ph ph-map-trifold"></i>
                    Manage destinations
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
