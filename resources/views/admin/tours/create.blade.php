@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Create New Safari</h1>
            <p class="text-slate-500 font-medium">Define your next unforgettable adventure package</p>
        </div>
        <a href="{{ route('admin.tours.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">
            Cancel
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8 pb-20">
        @csrf
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-8">
             <h3 class="text-xl font-black text-slate-900 flex items-center gap-3">
                <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm">1</span>
                Basic Information
             </h3>
             
             <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                 <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Tour Name</label>
                    <input type="text" name="name" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g. Serengeti Classic Safari">
                 </div>
                 <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Main Destination</label>
                    <input type="text" name="location" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" placeholder="e.g. Serengeti National Park">
                 </div>
                 <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Duration (Days)</label>
                    <input type="number" name="duration_days" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" placeholder="e.g. 5">
                 </div>
                 <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Base Price ($)</label>
                    <input type="number" name="base_price" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" placeholder="e.g. 1500">
                 </div>
             </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-8">
             <h3 class="text-xl font-black text-slate-900 flex items-center gap-3">
                <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm">2</span>
                Inclusions & Content
             </h3>
             <div class="space-y-1">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Brief Description</label>
                <textarea name="description" rows="4" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Describe the adventure..."></textarea>
             </div>
             
             <div class="space-y-4">
                 <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1 block">Hero Images</label>
                 <div class="border-2 border-dashed border-slate-100 rounded-3xl p-12 flex flex-col items-center justify-center text-slate-300 hover:border-emerald-300 hover:text-emerald-500 transition-all cursor-pointer group">
                    <i class="ph ph-cloud-arrow-up text-5xl mb-4 group-hover:scale-110 transition-transform"></i>
                    <p class="text-xs font-black uppercase tracking-widest">Click to upload images</p>
                    <p class="text-[9px] mt-2 font-bold opacity-60">PNG, JPG or WEBP (Max 5MB)</p>
                 </div>
             </div>
        </div>

        <div class="flex items-center justify-end gap-4">
            <button type="reset" class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">Discard Draft</button>
            <button type="submit" class="px-10 py-4 bg-emerald-600 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-emerald-500/20 hover:bg-emerald-700 transition-all">Publish Live Package</button>
        </div>
    </form>
</div>
@endsection
