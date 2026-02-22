@extends('layouts.public')

@section('content')
<section class="relative pt-48 pb-32 overflow-hidden bg-slate-900">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1589192339357-d18e9d290c0a?auto=format&fit=crop&w=2000&q=80" alt="Ruaha National Park" class="w-full h-full object-cover blur-sm opacity-40">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900 to-slate-900"></div>
    </div>
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <span class="inline-block px-4 py-1.5 bg-emerald-600/20 text-emerald-400 rounded-full text-xs font-bold tracking-widest uppercase mb-6 border border-emerald-600/30">Ruaha NP</span>
        <h1 class="text-5xl md:text-7xl font-serif text-white mb-8 font-bold">Remote & Wild <br> <span class="text-emerald-500">Authentic Safari</span></h1>
        <p class="text-xl text-slate-300 max-w-3xl mx-auto leading-relaxed">Ruaha is one of Tanzania’s most remote parks—fewer visitors, bigger landscapes, and an untamed feel.</p>
    </div>
</section>

<section class="py-32 bg-white">
    @php
        $gallery = [
            'https://images.unsplash.com/photo-1589192339357-d18e9d290c0a?auto=format&fit=crop&w=1600&q=80',
            'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=1600&q=80',
            'https://images.unsplash.com/photo-1516632664305-eda5d8b9b525?auto=format&fit=crop&w=1600&q=80',
            'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&w=1600&q=80',
        ];
    @endphp
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            <div class="lg:col-span-7">
                <h2 class="text-4xl md:text-5xl font-serif text-slate-900 font-bold mb-8 italic">Ruaha National Park</h2>
                <div class="prose prose-lg max-w-none text-slate-600">
                    <p class="text-xl leading-relaxed">Ruaha National Park is one of Tanzania’s most remote safari destinations.</p>
                    <p class="text-xl leading-relaxed">It is known for large lion prides and dramatic landscapes with rocky hills and baobab trees.</p>
                    <p class="text-xl leading-relaxed">Because it receives fewer visitors, it offers an authentic and untouched safari experience.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-14">
                    <div class="bg-emerald-50 p-8 rounded-3xl border border-emerald-100">
                        <h4 class="text-emerald-700 font-bold mb-4 flex items-center gap-2 italic"><i class="ph ph-paw-print text-2xl"></i> Wildlife focus</h4>
                        <ul class="space-y-3 text-emerald-800 font-medium">
                            <li>Large lion prides</li>
                            <li>Elephants & predators</li>
                            <li>Dramatic, rugged scenery</li>
                        </ul>
                    </div>
                    <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100">
                        <h4 class="text-slate-800 font-bold mb-4 flex items-center gap-2 italic"><i class="ph ph-users text-2xl"></i> Ideal for</h4>
                        <ul class="space-y-3 text-slate-600 font-medium">
                            <li>Repeat safari travelers</li>
                            <li>Off-the-beaten-path trips</li>
                            <li>Wild, low-crowd experiences</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                @include('regions.partials.gallery-slider', ['gallery' => $gallery, 'title' => 'Ruaha Gallery', 'eyebrow' => 'View more images'])
                <div class="h-10"></div>
                <div class="bg-slate-950 text-white rounded-[3.5rem] overflow-hidden p-12 relative">
                    <div class="absolute inset-0 opacity-30">
                        <img src="https://images.unsplash.com/photo-1589192339357-d18e9d290c0a?auto=format&fit=crop&w=1200&q=80" alt="Ruaha" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                    <div class="relative z-10">
                        <span class="text-emerald-500 font-black text-xs uppercase tracking-[0.4em] mb-6 block">Plan your safari</span>
                        <h3 class="text-3xl font-serif font-bold mb-6 italic">Explore Ruaha packages</h3>
                        <p class="text-slate-300 mb-10 leading-relaxed font-medium">Browse southern circuit tours that include Ruaha and prioritize wilderness.</p>
                        <a href="{{ route('tours.index', ['destination' => 'Ruaha']) }}" class="inline-flex items-center gap-3 px-10 py-4 bg-emerald-600 rounded-full font-bold shadow-xl shadow-emerald-600/30 hover:bg-emerald-700 transition-all">View Tours <i class="ph-bold ph-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-24 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-slate-50 p-10 rounded-[2.5rem] border border-slate-100">
                <h4 class="text-slate-900 font-black mb-3 flex items-center gap-2 italic"><i class="ph ph-calendar-check text-2xl"></i> Best time to visit</h4>
                <p class="text-slate-600 font-medium leading-relaxed">June–October for peak wildlife along the river and easy roads. November–March is greener and great for bird watching.</p>
            </div>
            <div class="bg-emerald-50 p-10 rounded-[2.5rem] border border-emerald-100">
                <h4 class="text-emerald-900 font-black mb-3 flex items-center gap-2 italic"><i class="ph ph-paw-print text-2xl"></i> Top experiences</h4>
                <p class="text-emerald-900/80 font-medium leading-relaxed">Big cats, elephant herds, dramatic baobab scenery, and quiet game drives with very few vehicles.</p>
            </div>
            <div class="bg-slate-900 p-10 rounded-[2.5rem] border border-slate-800 text-white">
                <h4 class="text-white font-black mb-3 flex items-center gap-2 italic"><i class="ph ph-airplane-tilt text-2xl"></i> Getting there</h4>
                <p class="text-slate-300 font-medium leading-relaxed">Best reached by flight from Dar es Salaam or Zanzibar. Often combined with Nyerere for a complete Southern Circuit safari.</p>
            </div>
        </div>
    </div>
</section>
@endsection
