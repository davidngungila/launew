@extends('layouts.public')

@section('content')
<section class="relative pt-48 pb-32 overflow-hidden bg-slate-900">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1474511320723-9a56873867b5?auto=format&fit=crop&w=2000&q=80" alt="Lake Manyara National Park" class="w-full h-full object-cover blur-sm opacity-40">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900 to-slate-900"></div>
    </div>
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <span class="inline-block px-4 py-1.5 bg-emerald-600/20 text-emerald-400 rounded-full text-xs font-bold tracking-widest uppercase mb-6 border border-emerald-600/30">Lake Manyara</span>
        <h1 class="text-5xl md:text-7xl font-serif text-white mb-8 font-bold">Tree‑Climbing Lions <br> <span class="text-emerald-500">& Rift Valley Views</span></h1>
        <p class="text-xl text-slate-300 max-w-3xl mx-auto leading-relaxed">A smaller but incredibly scenic park known for unique wildlife moments, birdlife, and lush forest landscapes.</p>
    </div>
</section>

<section class="py-32 bg-white">
    @php
        $gallery = [
            'https://images.unsplash.com/photo-1474511320723-9a56873867b5?auto=format&fit=crop&w=1600&q=80',
            'https://images.unsplash.com/photo-1528277342758-f1d7613953a2?auto=format&fit=crop&w=1600&q=80',
            'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=1600&q=80',
            'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&w=1600&q=80',
        ];
    @endphp
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            <div class="lg:col-span-7">
                <h2 class="text-4xl md:text-5xl font-serif text-slate-900 font-bold mb-8 italic">Lake Manyara National Park</h2>
                <div class="prose prose-lg max-w-none text-slate-600">
                    <p class="text-xl leading-relaxed">Lake Manyara National Park is known for its rare tree-climbing lions.</p>
                    <p class="text-xl leading-relaxed">The park also features flamingos, hippos, and lush forest scenery along the Great Rift Valley escarpment.</p>
                    <p class="text-xl leading-relaxed">It is a smaller park but very scenic and ideal for short safari visits.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-14">
                    <div class="bg-emerald-50 p-8 rounded-3xl border border-emerald-100">
                        <h4 class="text-emerald-700 font-bold mb-4 flex items-center gap-2 italic"><i class="ph ph-bird text-2xl"></i> Highlights</h4>
                        <ul class="space-y-3 text-emerald-800 font-medium">
                            <li>Birdlife & flamingos</li>
                            <li>Hippos & forest scenery</li>
                            <li>Rift Valley escarpment views</li>
                        </ul>
                    </div>
                    <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100">
                        <h4 class="text-slate-800 font-bold mb-4 flex items-center gap-2 italic"><i class="ph ph-compass text-2xl"></i> Ideal for</h4>
                        <ul class="space-y-3 text-slate-600 font-medium">
                            <li>Short safaris (1–2 days)</li>
                            <li>Nature & scenery lovers</li>
                            <li>Northern Circuit add-ons</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                @include('regions.partials.gallery-slider', ['gallery' => $gallery, 'title' => 'Lake Manyara Gallery', 'eyebrow' => 'View more images'])
                <div class="h-10"></div>
                <div class="bg-slate-950 text-white rounded-[3.5rem] overflow-hidden p-12 relative">
                    <div class="absolute inset-0 opacity-30">
                        <img src="https://images.unsplash.com/photo-1474511320723-9a56873867b5?auto=format&fit=crop&w=1200&q=80" alt="Lake Manyara" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                    <div class="relative z-10">
                        <span class="text-emerald-500 font-black text-xs uppercase tracking-[0.4em] mb-6 block">Plan your safari</span>
                        <h3 class="text-3xl font-serif font-bold mb-6 italic">Explore Lake Manyara packages</h3>
                        <p class="text-slate-300 mb-10 leading-relaxed font-medium">Find short scenic safaris that include Lake Manyara as part of the Northern Circuit.</p>
                        <a href="{{ route('tours.index', ['destination' => 'Manyara']) }}" class="inline-flex items-center gap-3 px-10 py-4 bg-emerald-600 rounded-full font-bold shadow-xl shadow-emerald-600/30 hover:bg-emerald-700 transition-all">View Tours <i class="ph-bold ph-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-24 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-slate-50 p-10 rounded-[2.5rem] border border-slate-100">
                <h4 class="text-slate-900 font-black mb-3 flex items-center gap-2 italic"><i class="ph ph-calendar-check text-2xl"></i> Best time to visit</h4>
                <p class="text-slate-600 font-medium leading-relaxed">June–October for concentrated wildlife and clear views. November–May is greener with excellent birding and dramatic scenery.</p>
            </div>
            <div class="bg-emerald-50 p-10 rounded-[2.5rem] border border-emerald-100">
                <h4 class="text-emerald-900 font-black mb-3 flex items-center gap-2 italic"><i class="ph ph-bird text-2xl"></i> Top activities</h4>
                <p class="text-emerald-900/80 font-medium leading-relaxed">Scenic game drives, bird watching, hippo pool viewing, and combining Manyara with Tarangire/Ngorongoro for short trips.</p>
            </div>
            <div class="bg-slate-900 p-10 rounded-[2.5rem] border border-slate-800 text-white">
                <h4 class="text-white font-black mb-3 flex items-center gap-2 italic"><i class="ph ph-road-horizon text-2xl"></i> Getting there</h4>
                <p class="text-slate-300 font-medium leading-relaxed">A short drive from Arusha to the park gate (Northern Circuit). Easy to visit as a day trip or 1-night add-on.</p>
            </div>
        </div>
    </div>
</section>
@endsection
