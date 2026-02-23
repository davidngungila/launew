@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 pb-20">
    <div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">System Health</h1>
        <p class="text-slate-500 font-medium">Operational status checks</p>
    </div>

    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-8">
        <div class="space-y-4">
            @foreach($checks as $c)
                <div class="flex items-center justify-between px-6 py-4 bg-slate-50 border border-slate-100 rounded-xl">
                    <div>
                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $c['label'] }}</div>
                        <div class="text-sm font-black text-slate-900 mt-1">{{ $c['status'] }}</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded {{ $c['ok'] ? 'bg-emerald-500' : 'bg-red-500' }}"></div>
                        <div class="text-xs font-black {{ $c['ok'] ? 'text-emerald-700' : 'text-red-600' }}">{{ $c['ok'] ? 'OK' : 'FAIL' }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
