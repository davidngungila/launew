@extends('layouts.public')

@section('content')
<section class="relative pt-48 pb-32 overflow-hidden bg-slate-100">
    <div class="max-w-4xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 bg-emerald-600/10 text-emerald-600 rounded-full text-[10px] font-black tracking-[0.3em] uppercase mb-6 border border-emerald-600/20">Our Commitment</span>
            <h1 class="text-4xl md:text-6xl font-serif text-slate-900 mb-6 font-bold italic">Sustainability Policy</h1>
            <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Preserving Paradise for Generations</p>
        </div>

        <div class="bg-white rounded-[3rem] p-8 md:p-16 shadow-2xl border border-slate-100 prose prose-slate max-w-none prose-headings:font-serif prose-headings:italic prose-a:text-emerald-600">
            <h3>1. Eco-Friendly Operations</h3>
            <p>We are dedicated to minimizing our carbon footprint. This includes maintaining fuel-efficient vehicles, reducing single-use plastics on safaris, and utilizing solar power where possible.</p>

            <h3>2. Community Support</h3>
            <p>We prioritize hiring local guides and staff from the communities we visit, ensuring that tourism benefits the people of Tanzania directly.</p>

            <h3>3. Wildlife Conservation</h3>
            <p>A portion of our proceeds is donated to local wildlife conservation projects. We strictly adhere to national park rules to avoid disturbing natural habitats.</p>
        </div>
    </div>
</section>
@endsection
