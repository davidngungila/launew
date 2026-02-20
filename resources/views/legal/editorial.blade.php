@extends('layouts.public')

@section('content')
<section class="relative pt-48 pb-32 overflow-hidden bg-slate-100">
    <div class="max-w-4xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 bg-emerald-600/10 text-emerald-600 rounded-full text-[10px] font-black tracking-[0.3em] uppercase mb-6 border border-emerald-600/20">Information Integrity</span>
            <h1 class="text-4xl md:text-6xl font-serif text-slate-900 mb-6 font-bold italic">Editorial Policy</h1>
            <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Commitment to Accurate African Storytelling</p>
        </div>

        <div class="bg-white rounded-[3rem] p-8 md:p-16 shadow-2xl border border-slate-100 prose prose-slate max-w-none prose-headings:font-serif prose-headings:italic prose-a:text-emerald-600">
            <h3>1. Accuracy and Fact-Checking</h3>
            <p>All content on our website, from tour descriptions to blog posts, is rigorously fact-checked by our safari experts and local guides to ensure accurate wildlife and cultural information.</p>

            <h3>2. Transparency</h3>
            <p>We clearly distinguish between informational content and promotional offers. Our goal is to provide honest expectations for your safari experience.</p>

            <h3>3. Modern Imagery</h3>
            <p>We use authentic photography from our own expeditions to represent the true beauty of Tanzania, avoiding misleading or overly staged visuals.</p>
        </div>
    </div>
</section>
@endsection
