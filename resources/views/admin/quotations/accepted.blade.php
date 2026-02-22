@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Accepted Quotations</h1>
            <p class="text-slate-500 font-medium">Quotations that clients have accepted (ready to convert to bookings)</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.quotations.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">All Quotations</a>
            <a href="{{ route('admin.quotations.create') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <i class="ph ph-plus"></i>
                Create New
            </a>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-50">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Status</p>
            <h3 class="text-xl font-black text-slate-900 mt-2">No accepted quotations yet</h3>
            <p class="text-slate-500 font-medium mt-2">This page is ready. Once quotations are stored in the database, accepted records will appear here.</p>
        </div>
        <div class="p-8">
            <a href="{{ route('admin.quotations.create') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-slate-900 text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-slate-800 transition-all">
                Start a quotation
                <i class="ph ph-arrow-right"></i>
            </a>
        </div>
    </div>
</div>
@endsection
