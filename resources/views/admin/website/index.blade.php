@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Website Manager</h1>
            <p class="text-slate-500 font-medium">Control your public storefront and branding</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ url('/') }}" target="_blank" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                <i class="ph ph-arrow-square-out"></i>
                Preview Site
            </a>
            <button class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <i class="ph ph-floppy-disk"></i>
                Save All Changes
            </button>
        </div>
    </div>

    <!-- Management Sections -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        @foreach([
            ['label' => 'Homepage Layout', 'btn' => 'Manage Blocks', 'icon' => 'squares-four'],
            ['label' => 'Hero Slider', 'btn' => 'Edit Slides', 'icon' => 'image'],
            ['label' => 'About Our Story', 'btn' => 'Edit Content', 'icon' => 'book-open'],
            ['label' => 'SEO & Meta Tags', 'btn' => 'Manage SEO', 'icon' => 'google-logo'],
            ['label' => 'Testimonials', 'btn' => 'Approve Reviews', 'icon' => 'star'],
            ['label' => 'Contact Info', 'btn' => 'Update Details', 'icon' => 'phone'],
            ['label' => 'Legal & Privacy', 'btn' => 'Edit Pages', 'icon' => 'file-text'],
            ['label' => 'Social Links', 'btn' => 'Manage Feed', 'icon' => 'instagram-logo'],
        ] as $sec)
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
            <div class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-400 group-hover:bg-emerald-50 group-hover:text-emerald-500 flex items-center justify-center mb-6 transition-colors">
                <i class="ph-bold ph-{{ $sec['icon'] }} text-2xl"></i>
            </div>
            <h4 class="text-sm font-black text-slate-900 mb-6">{{ $sec['label'] }}</h4>
            <button class="text-[10px] font-black uppercase tracking-widest text-emerald-600 hover:text-emerald-700">{{ $sec['btn'] }}</button>
        </div>
        @endforeach
    </div>
    
    <!-- Hero Slider Editor Preview -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
        <h3 class="text-xl font-black text-slate-900 tracking-tight mb-8">Homepage Hero Previews</h3>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            @foreach([
                ['title' => 'Unveil the magic of Wild Africa', 'bg' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=400&q=80'],
                ['title' => 'Conquer the Roof of Africa', 'bg' => 'https://images.unsplash.com/photo-1589192339357-d18e9d290c0a?auto=format&fit=crop&w=400&q=80'],
                ['title' => 'Discover Zanzibar Paradises', 'bg' => 'https://images.unsplash.com/photo-1493612276216-ee3925520721?auto=format&fit=crop&w=400&q=80'],
            ] as $slide)
            <div class="relative h-40 rounded-3xl overflow-hidden group">
                <img src="{{ $slide['bg'] }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40 flex items-center justify-center p-6 text-center">
                    <p class="text-white text-xs font-black">{{ $slide['title'] }}</p>
                </div>
                <div class="absolute top-2 right-2 flex gap-1">
                    <button class="w-8 h-8 bg-white/20 backdrop-blur rounded-lg flex items-center justify-center hover:bg-emerald-500 text-white"><i class="ph ph-pencil"></i></button>
                    <button class="w-8 h-8 bg-white/20 backdrop-blur rounded-lg flex items-center justify-center hover:bg-red-500 text-white"><i class="ph ph-trash"></i></button>
                </div>
            </div>
            @endforeach
            <button class="h-40 rounded-3xl border-2 border-dashed border-slate-100 flex flex-col items-center justify-center gap-2 text-slate-300 hover:border-emerald-300 hover:text-emerald-300 transition-all">
                <i class="ph ph-plus text-3xl"></i>
                <span class="text-[10px] font-black uppercase tracking-widest">Add New Slide</span>
            </button>
        </div>
    </div>
</div>
@endsection
