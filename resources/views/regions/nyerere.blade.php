@extends('layouts.public')

@section('content')
<section class="relative pt-48 pb-32 overflow-hidden bg-slate-900">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1523805081730-614449379e70?auto=format&fit=crop&w=2000&q=80" alt="Nyerere National Park" class="w-full h-full object-cover blur-sm opacity-40">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900 to-slate-900"></div>
    </div>
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <span class="inline-block px-4 py-1.5 bg-emerald-600/20 text-emerald-400 rounded-full text-xs font-bold tracking-widest uppercase mb-6 border border-emerald-600/30">Nyerere NP</span>
        <h1 class="text-5xl md:text-7xl font-serif text-white mb-8 font-bold">Africa’s Largest <br> <span class="text-emerald-500">National Park</span></h1>
        <p class="text-xl text-slate-300 max-w-3xl mx-auto leading-relaxed">Boat safaris, vast wilderness, and fewer crowds—Nyerere is built for travelers who want exclusivity and space.</p>
    </div>
</section>

<section class="py-32 bg-white">
    @php
        $gallery = [
            'https://images.unsplash.com/photo-1523805081730-614449379e70?auto=format&fit=crop&w=1600&q=80',
            'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1600&q=80',
            'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=1600&q=80',
            'https://images.unsplash.com/photo-1500375592092-40eb2168fd21?auto=format&fit=crop&w=1600&q=80',
        ];
    @endphp
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            <div class="lg:col-span-7">
                <h2 class="text-4xl md:text-5xl font-serif text-slate-900 font-bold mb-8 italic">Nyerere National Park</h2>
                <div class="prose prose-lg max-w-none text-slate-600">
                    <p class="text-xl leading-relaxed">Formerly part of Selous Game Reserve, Nyerere National Park is one of the largest protected wildlife areas in Africa.</p>
                    <p class="text-xl leading-relaxed">It offers unique boat safaris along the Rufiji River, where visitors can see crocodiles, hippos, and elephants from the water.</p>
                    <p class="text-xl leading-relaxed">It is less crowded, making it ideal for travelers seeking exclusivity.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-14">
                    <div class="bg-emerald-50 p-8 rounded-3xl border border-emerald-100">
                        <h4 class="text-emerald-700 font-bold mb-4 flex items-center gap-2 italic"><i class="ph ph-boat text-2xl"></i> Signature experience</h4>
                        <ul class="space-y-3 text-emerald-800 font-medium">
                            <li>Boat safaris on the Rufiji River</li>
                            <li>Hippos, crocodiles, elephants</li>
                            <li>Big landscapes & wild feel</li>
                        </ul>
                    </div>
                    <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100">
                        <h4 class="text-slate-800 font-bold mb-4 flex items-center gap-2 italic"><i class="ph ph-crown text-2xl"></i> Ideal for</h4>
                        <ul class="space-y-3 text-slate-600 font-medium">
                            <li>Repeat safari travelers</li>
                            <li>Luxury & fly-in safaris</li>
                            <li>Low-crowd experiences</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                @include('regions.partials.gallery-slider', ['gallery' => $gallery, 'title' => 'Nyerere Gallery', 'eyebrow' => 'View more images'])
                <div class="h-10"></div>
                <div class="bg-slate-950 text-white rounded-[3.5rem] overflow-hidden p-12 relative">
                    <div class="absolute inset-0 opacity-30">
                        <img src="https://images.unsplash.com/photo-1523805081730-614449379e70?auto=format&fit=crop&w=1200&q=80" alt="Nyerere" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                    <div class="relative z-10">
                        <span class="text-emerald-500 font-black text-xs uppercase tracking-[0.4em] mb-6 block">Plan your safari</span>
                        <h3 class="text-3xl font-serif font-bold mb-6 italic">Explore Nyerere packages</h3>
                        <p class="text-slate-300 mb-10 leading-relaxed font-medium">Browse southern circuit tours that include Nyerere and add boat safari experiences.</p>
                        <a href="{{ route('tours.index', ['destination' => 'Nyerere']) }}" class="inline-flex items-center gap-3 px-10 py-4 bg-emerald-600 rounded-full font-bold shadow-xl shadow-emerald-600/30 hover:bg-emerald-700 transition-all">View Tours <i class="ph-bold ph-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-24 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-slate-50 p-10 rounded-[2.5rem] border border-slate-100">
                <h4 class="text-slate-900 font-black mb-3 flex items-center gap-2 italic"><i class="ph ph-calendar-check text-2xl"></i> Best time to visit</h4>
                <p class="text-slate-600 font-medium leading-relaxed">June–October for dry roads and strong wildlife viewing along the Rufiji River. November–March offers greener landscapes and good birding.</p>
            </div>
            <div class="bg-emerald-50 p-10 rounded-[2.5rem] border border-emerald-100">
                <h4 class="text-emerald-900 font-black mb-3 flex items-center gap-2 italic"><i class="ph ph-boat text-2xl"></i> Top experiences</h4>
                <p class="text-emerald-900/80 font-medium leading-relaxed">Boat safaris, classic game drives, and quiet wilderness camps—perfect for travelers who want space and exclusivity.</p>
            </div>
            <div class="bg-slate-900 p-10 rounded-[2.5rem] border border-slate-800 text-white">
                <h4 class="text-white font-black mb-3 flex items-center gap-2 italic"><i class="ph ph-airplane-tilt text-2xl"></i> Getting there</h4>
                <p class="text-slate-300 font-medium leading-relaxed">Fly in from Zanzibar/Dar es Salaam, or drive from Dar es Salaam. Many guests combine Nyerere with Ruaha for the Southern Circuit.</p>
            </div>
        </div>
    </div>
</section>
@endsection
