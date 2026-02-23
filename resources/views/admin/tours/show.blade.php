@extends('layouts.admin')

@section('content')
@php
    $images = is_array($tour->images ?? null) ? ($tour->images ?? []) : [];
    $hero = !empty($images) ? $images[0] : 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=1600&q=80';
    $inclusions = is_array($tour->inclusions ?? null) ? ($tour->inclusions ?? []) : [];
    $exclusions = is_array($tour->exclusions ?? null) ? ($tour->exclusions ?? []) : [];
    $packageDestinations = is_array($tour->package_destinations ?? null) ? ($tour->package_destinations ?? []) : [];
    $targetMarkets = is_array($tour->target_markets ?? null) ? ($tour->target_markets ?? []) : [];
    $interactiveFeatures = is_array($tour->interactive_features ?? null) ? ($tour->interactive_features ?? []) : [];
    $addons = is_array($tour->addons ?? null) ? ($tour->addons ?? []) : [];
    $conversionTriggers = is_array($tour->conversion_triggers ?? null) ? ($tour->conversion_triggers ?? []) : [];
    $status = ucfirst($tour->status ?? 'draft');
    $statusColor = match($status) {
        'Active' => 'emerald',
        'Draft' => 'orange',
        'Inactive' => 'red',
        default => 'slate',
    };
@endphp

<div class="max-w-7xl mx-auto space-y-10 pb-24">
    <div class="relative overflow-hidden rounded-[3rem] border border-slate-100 shadow-2xl">
        <div class="h-64 md:h-80 bg-slate-900">
            <img src="{{ $hero }}" alt="{{ $tour->name }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
        </div>

        <div class="absolute top-6 left-6 right-6 flex items-start justify-between gap-4">
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.tours.index') }}" class="px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 text-white font-black text-[10px] uppercase tracking-widest rounded-2xl hover:bg-white/20 transition-all">
                    <i class="ph ph-arrow-left"></i>
                    Back
                </a>
                <span class="px-3 py-1 rounded-2xl bg-{{ $statusColor }}-500 text-white text-[10px] font-black uppercase tracking-widest border border-white/10">{{ $status }}</span>
                @if($tour->featured)
                    <span class="px-3 py-1 rounded-2xl bg-white/10 text-white text-[10px] font-black uppercase tracking-widest border border-white/20">Featured</span>
                @endif
            </div>

            <div class="flex flex-wrap items-center gap-2 justify-end">
                <a href="{{ route('admin.tours.itinerary-builder', ['tour_id' => $tour->id]) }}" class="px-5 py-2.5 bg-white text-slate-900 font-black rounded-2xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                    <i class="ph ph-list-checks"></i>
                    Itinerary Builder
                </a>
                <a href="{{ route('admin.tours.edit', $tour) }}" class="px-5 py-2.5 bg-emerald-600 text-white font-black rounded-2xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/20 flex items-center gap-2">
                    <i class="ph ph-pencil-simple"></i>
                    Edit
                </a>
                <form action="{{ route('admin.tours.destroy', $tour) }}" method="POST" onsubmit="return confirm('Delete this tour?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-5 py-2.5 bg-white/10 border border-white/20 text-white font-black rounded-2xl hover:bg-rose-600 hover:border-rose-500 transition-all flex items-center gap-2">
                        <i class="ph ph-trash"></i>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="absolute bottom-6 left-6 right-6">
            <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">{{ $tour->name }}</h1>
            <div class="mt-2 flex flex-wrap items-center gap-3 text-white/80">
                <span class="inline-flex items-center gap-2 text-sm font-bold"><i class="ph ph-map-pin"></i>{{ $tour->location }}</span>
                <span class="text-white/40">·</span>
                <span class="inline-flex items-center gap-2 text-sm font-bold"><i class="ph ph-clock"></i>{{ $tour->duration_days }} days</span>
                <span class="text-white/40">·</span>
                <span class="inline-flex items-center gap-2 text-sm font-bold"><i class="ph ph-hash"></i>ID #{{ $tour->id }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Overview</p>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Description</h2>
                    </div>
                    <span class="px-3 py-1 rounded-2xl bg-slate-50 border border-slate-100 text-[10px] font-black uppercase tracking-widest text-slate-500">Slug: {{ $tour->slug }}</span>
                </div>
                <p class="text-slate-700 font-medium leading-relaxed">{{ $tour->description ?: 'No description provided.' }}</p>
            </div>

            @if(count($images) > 1)
            <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Media</p>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-6">Gallery</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach(array_slice($images, 0, 9) as $img)
                        <div class="overflow-hidden rounded-2xl border border-slate-100 bg-slate-50">
                            <img src="{{ $img }}" class="w-full h-32 md:h-36 object-cover" alt="{{ $tour->name }}">
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Schedule</p>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Itinerary</h2>
                    </div>
                    <a href="{{ route('admin.tours.itinerary-builder', ['tour_id' => $tour->id]) }}" class="px-5 py-2.5 bg-slate-900 text-white font-black rounded-2xl hover:bg-slate-800 transition-all flex items-center gap-2">
                        <i class="ph ph-pencil-simple"></i>
                        Edit itinerary
                    </a>
                </div>

                @if(($tour->itineraries ?? collect())->count() === 0)
                    <div class="p-8 rounded-2xl bg-slate-50 border border-slate-100">
                        <p class="text-sm font-black text-slate-900">No itinerary saved</p>
                        <p class="text-sm font-bold text-slate-500 mt-1">Create the day-by-day plan in Itinerary Builder.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($tour->itineraries as $day)
                            <div class="p-6 rounded-2xl border border-slate-100 bg-slate-50">
                                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                                    <div class="flex items-start gap-4">
                                        <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-black">D{{ $day->day_number }}</div>
                                        <div>
                                            <p class="text-lg font-black text-slate-900 leading-tight">{{ $day->title }}</p>
                                            <p class="text-sm font-medium text-slate-600 mt-2 leading-relaxed">{{ $day->description }}</p>
                                        </div>
                                    </div>
                                    <div class="shrink-0 grid grid-cols-1 gap-2 text-xs font-black text-slate-500">
                                        @if($day->accommodation)
                                            <div class="px-4 py-2 rounded-xl bg-white border border-slate-100">Stay: <span class="text-slate-900">{{ $day->accommodation }}</span></div>
                                        @endif
                                        @if($day->meals)
                                            <div class="px-4 py-2 rounded-xl bg-white border border-slate-100">Meals: <span class="text-slate-900">{{ $day->meals }}</span></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Includes</p>
                    <h2 class="text-xl font-black text-slate-900 tracking-tight mb-6">What’s Included</h2>
                    @if(count($inclusions) === 0)
                        <p class="text-sm font-bold text-slate-500">No inclusions set.</p>
                    @else
                        <div class="space-y-2">
                            @foreach($inclusions as $inc)
                                <div class="flex items-start gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-100">
                                    <i class="ph ph-check-circle text-emerald-600 text-lg"></i>
                                    <p class="text-sm font-bold text-slate-800">{{ is_string($inc) ? $inc : json_encode($inc) }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Excludes</p>
                    <h2 class="text-xl font-black text-slate-900 tracking-tight mb-6">Not Included</h2>
                    @if(count($exclusions) === 0)
                        <p class="text-sm font-bold text-slate-500">No exclusions set.</p>
                    @else
                        <div class="space-y-2">
                            @foreach($exclusions as $exc)
                                <div class="flex items-start gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-100">
                                    <i class="ph ph-x-circle text-rose-600 text-lg"></i>
                                    <p class="text-sm font-bold text-slate-800">{{ is_string($exc) ? $exc : json_encode($exc) }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 space-y-8">
            <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Pricing</p>
                <h2 class="text-xl font-black text-slate-900 tracking-tight mb-6">Rates</h2>

                <div class="space-y-3">
                    <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Base price</span>
                        <span class="text-sm font-black text-slate-900">${{ number_format($tour->base_price ?? 0) }}</span>
                    </div>

                    <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">International min</span>
                        <span class="text-sm font-black text-slate-900">{{ $tour->international_price_min ? ('$' . number_format($tour->international_price_min)) : 'N/A' }}</span>
                    </div>

                    <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">International max</span>
                        <span class="text-sm font-black text-slate-900">{{ $tour->international_price_max ? ('$' . number_format($tour->international_price_max)) : 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 p-10 rounded-[2.5rem] shadow-2xl text-white">
                <p class="text-[10px] font-black uppercase tracking-widest text-white/50 mb-2">Package meta</p>
                <h2 class="text-xl font-black mb-6">Details</h2>
                <div class="space-y-3 text-sm font-bold">
                    <div class="flex items-center justify-between"><span class="text-white/60">Best season</span><span>{{ $tour->best_season ?: 'N/A' }}</span></div>
                    <div class="flex items-center justify-between"><span class="text-white/60">Featured</span><span>{{ $tour->featured ? 'Yes' : 'No' }}</span></div>
                    <div class="flex items-center justify-between"><span class="text-white/60">Status</span><span>{{ $status }}</span></div>
                    <div class="flex items-center justify-between"><span class="text-white/60">Itinerary days</span><span>{{ ($tour->itineraries ?? collect())->count() }}</span></div>
                </div>
            </div>

            <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-6">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Destinations</p>
                    <div class="flex flex-wrap gap-2">
                        @if(count($packageDestinations) === 0)
                            <span class="text-sm font-bold text-slate-500">N/A</span>
                        @else
                            @foreach($packageDestinations as $d)
                                <span class="px-3 py-1 rounded-2xl bg-slate-50 border border-slate-100 text-[10px] font-black uppercase tracking-widest text-slate-600">{{ is_string($d) ? $d : json_encode($d) }}</span>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Target markets</p>
                    <div class="flex flex-wrap gap-2">
                        @if(count($targetMarkets) === 0)
                            <span class="text-sm font-bold text-slate-500">N/A</span>
                        @else
                            @foreach($targetMarkets as $m)
                                <span class="px-3 py-1 rounded-2xl bg-slate-50 border border-slate-100 text-[10px] font-black uppercase tracking-widest text-slate-600">{{ is_string($m) ? $m : json_encode($m) }}</span>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-6">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Interactive features</p>
                    <div class="space-y-2">
                        @if(count($interactiveFeatures) === 0)
                            <p class="text-sm font-bold text-slate-500">N/A</p>
                        @else
                            @foreach($interactiveFeatures as $f)
                                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 text-sm font-bold text-slate-800">{{ is_string($f) ? $f : json_encode($f) }}</div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Add-ons</p>
                    <div class="space-y-2">
                        @if(count($addons) === 0)
                            <p class="text-sm font-bold text-slate-500">N/A</p>
                        @else
                            @foreach($addons as $a)
                                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 text-sm font-bold text-slate-800">{{ is_string($a) ? $a : json_encode($a) }}</div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Conversion triggers</p>
                    <div class="space-y-2">
                        @if(count($conversionTriggers) === 0)
                            <p class="text-sm font-bold text-slate-500">N/A</p>
                        @else
                            @foreach($conversionTriggers as $c)
                                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 text-sm font-bold text-slate-800">{{ is_string($c) ? $c : json_encode($c) }}</div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
