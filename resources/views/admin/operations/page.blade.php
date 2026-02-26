@extends('layouts.admin')

@section('content')
@php
    $links = $links ?? [];
@endphp

<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">{{ $title ?? 'Operations' }}</h1>
            <p class="text-slate-500 font-medium">{{ $subtitle ?? 'Operations module' }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.operations.dashboard') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Operations</a>
            <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">Admin Dashboard</a>
        </div>
    </div>

    @if(count($links))
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                @foreach($links as $l)
                    <a href="{{ $l['href'] ?? '#' }}" class="group p-5 rounded-2xl border border-slate-100 hover:border-emerald-200 hover:bg-emerald-50/30 transition-all">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">{{ $l['section'] ?? 'Operations' }}</div>
                                <div class="mt-2 text-lg font-black text-slate-900 group-hover:text-emerald-700">{{ $l['label'] ?? 'Open' }}</div>
                                @if(!empty($l['description']))
                                    <div class="mt-1 text-sm font-medium text-slate-500">{{ $l['description'] }}</div>
                                @endif
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-500 group-hover:bg-emerald-100 group-hover:text-emerald-700 flex items-center justify-center transition-all">
                                <i class="ph-bold ph-arrow-up-right"></i>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-10">
        <div class="text-sm text-slate-600 font-medium">{{ $body ?? 'This page is ready. Next step is to connect it to live data and workflow actions.' }}</div>
    </div>
</div>
@endsection
