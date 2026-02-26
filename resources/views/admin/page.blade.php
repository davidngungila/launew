@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">{{ $title ?? 'Page' }}</h1>
            <p class="text-slate-500 font-medium">Coming soon</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Dashboard</a>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-10">
        <div class="text-sm text-slate-600 font-medium">This module is part of the enterprise ERP navigation and will be implemented in the next phase.</div>
    </div>
</div>
@endsection
