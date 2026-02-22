@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Create New Quotation</h1>
            <p class="text-slate-500 font-medium">Capture client details and draft an itinerary proposal</p>
        </div>
        <a href="{{ route('admin.quotations.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Back</a>
    </div>

    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-6">
        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Setup</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-1">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Client Name</label>
                <input type="text" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" placeholder="Client full name">
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Client Email</label>
                <input type="email" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" placeholder="client@email.com">
            </div>
            <div class="space-y-1 md:col-span-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Itinerary Brief</label>
                <textarea rows="4" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" placeholder="e.g. 7 days Serengeti + Ngorongoro, mid-range lodges"></textarea>
            </div>
        </div>
        <div class="flex items-center justify-end gap-4 pt-2">
            <a href="{{ route('admin.quotations.index') }}" class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">Cancel</a>
            <button type="button" class="px-10 py-4 bg-emerald-600 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-emerald-500/20 hover:bg-emerald-700 transition-all">Save Draft</button>
        </div>
    </div>
</div>
@endsection
