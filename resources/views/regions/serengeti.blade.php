@extends('layouts.public')

@section('content')
<section class="relative pt-48 pb-32 overflow-hidden bg-slate-900">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=2000&q=80" alt="Serengeti National Park" class="w-full h-full object-cover blur-sm opacity-40">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900 to-slate-900"></div>
    </div>
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <span class="inline-block px-4 py-1.5 bg-emerald-600/20 text-emerald-400 rounded-full text-xs font-bold tracking-widest uppercase mb-6 border border-emerald-600/30">Serengeti NP</span>
        <h1 class="text-5xl md:text-7xl font-serif text-white mb-8 font-bold">The Great Migration <br> <span class="text-emerald-500">Starts Here</span></h1>
        <p class="text-xl text-slate-300 max-w-3xl mx-auto leading-relaxed">Serengeti National Park is Tanzania’s iconic safari destination, famous for endless plains, dramatic sunsets, and world-class wildlife viewing.</p>
    </div>
</section>

<section class="py-32 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            <div class="lg:col-span-7">
                <h2 class="text-4xl md:text-5xl font-serif text-slate-900 font-bold mb-8 italic">Home of The Great Migration</h2>
                <div class="prose prose-lg max-w-none text-slate-600">
                    <p class="text-xl leading-relaxed">Serengeti National Park is one of the most famous wildlife destinations in the world. It is best known for the Great Wildebeest Migration, where over 1.5 million wildebeest and thousands of zebras move across the plains in search of fresh grazing.</p>
                    <p class="text-xl leading-relaxed">The park offers classic African safari landscapes — endless golden plains, dramatic sunsets, and exceptional wildlife viewing including lions, cheetahs, elephants, leopards, and buffalo.</p>
                    <p class="text-xl leading-relaxed">It is ideal for travelers seeking a true “National Geographic” safari experience.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-14">
                    <div class="bg-emerald-50 p-8 rounded-3xl border border-emerald-100">
                        <h4 class="text-emerald-700 font-bold mb-4 flex items-center gap-2 italic"><i class="ph ph-binoculars text-2xl"></i> Signature wildlife</h4>
                        <ul class="space-y-3 text-emerald-800 font-medium">
                            <li>Lions, cheetahs, leopards</li>
                            <li>Elephants & buffalo</li>
                            <li>Massive wildebeest & zebra herds</li>
                        </ul>
                    </div>
                    <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100">
                        <h4 class="text-slate-800 font-bold mb-4 flex items-center gap-2 italic"><i class="ph ph-map-trifold text-2xl"></i> Best for</h4>
                        <ul class="space-y-3 text-slate-600 font-medium">
                            <li>First-time safari travelers</li>
                            <li>Great Migration seekers</li>
                            <li>Photography-focused trips</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="bg-slate-950 text-white rounded-[3.5rem] overflow-hidden p-12 relative">
                    <div class="absolute inset-0 opacity-30">
                        <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&w=1200&q=80" alt="Serengeti" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                    <div class="relative z-10">
                        <span class="text-emerald-500 font-black text-xs uppercase tracking-[0.4em] mb-6 block">Plan your safari</span>
                        <h3 class="text-3xl font-serif font-bold mb-6 italic">Explore Serengeti packages</h3>
                        <p class="text-slate-300 mb-10 leading-relaxed font-medium">Browse safari itineraries that include Serengeti National Park and match your ideal budget, comfort level, and travel season.</p>
                        <a href="{{ route('tours.index', ['destination' => 'Serengeti']) }}" class="inline-flex items-center gap-3 px-10 py-4 bg-emerald-600 rounded-full font-bold shadow-xl shadow-emerald-600/30 hover:bg-emerald-700 transition-all">View Tours <i class="ph-bold ph-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
