@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8" x-data="itineraryBuilder()" x-init="init()">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Itinerary Builder</h1>
            <p class="text-slate-500 font-medium">Create, reorder and save day-by-day itineraries for your tours</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.tours.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Back to tours</a>
            <button type="button" @click="save()" :disabled="!selectedTourId || saving" class="px-5 py-2.5 bg-slate-900 text-white font-black rounded-xl hover:bg-slate-800 transition-all shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                <span x-show="!saving">Save Itinerary</span>
                <span x-show="saving">Saving…</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-4 bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-6">
            <div class="space-y-2">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Select a tour</p>
                <select class="w-full border border-slate-200 rounded-2xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-300" x-model="selectedTourId" @change="loadTour()">
                    <option value="">Choose a tour…</option>
                    @foreach(($tours ?? []) as $t)
                        <option value="{{ $t->id }}">{{ $t->name }} ({{ $t->duration_days }} days)</option>
                    @endforeach
                </select>
            </div>

            <div class="bg-slate-50 border border-slate-100 rounded-[2rem] p-6 space-y-3">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Tour summary</p>
                <template x-if="tour">
                    <div class="space-y-1">
                        <p class="text-sm font-black text-slate-900" x-text="tour.name"></p>
                        <p class="text-xs font-bold text-slate-500" x-text="tour.location + ' · ' + tour.duration_days + ' days'"></p>
                        <a class="inline-flex items-center gap-2 mt-2 text-xs font-black text-emerald-700 hover:text-emerald-600" :href="tour ? ('{{ url('/admin/tours') }}/' + tour.id) : '#'">
                            <i class="ph ph-arrow-square-out"></i>
                            Open tour
                        </a>
                    </div>
                </template>
                <template x-if="!tour">
                    <p class="text-xs font-bold text-slate-500">Select a tour to start editing.</p>
                </template>
            </div>

            <div class="space-y-3">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Actions</p>
                <div class="grid grid-cols-1 gap-2">
                    <button type="button" @click="addDay()" :disabled="!selectedTourId" class="w-full px-5 py-3 bg-emerald-600 text-white font-black rounded-2xl hover:bg-emerald-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        Add day
                    </button>
                    <button type="button" @click="normalizeDayNumbers()" :disabled="items.length === 0" class="w-full px-5 py-3 bg-white border border-slate-200 text-slate-700 font-black rounded-2xl hover:bg-slate-50 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        Normalize day numbers
                    </button>
                </div>
            </div>

            <template x-if="message">
                <div class="rounded-2xl px-4 py-3 text-xs font-black" :class="messageType === 'success' ? 'bg-emerald-50 text-emerald-800 border border-emerald-100' : 'bg-rose-50 text-rose-800 border border-rose-100'" x-text="message"></div>
            </template>
        </div>

        <div class="lg:col-span-8 space-y-6">
            <template x-if="loading">
                <div class="bg-white border border-slate-100 rounded-[2.5rem] p-10 shadow-sm">
                    <p class="text-sm font-black text-slate-500">Loading itinerary…</p>
                </div>
            </template>

            <template x-if="!loading && selectedTourId && items.length === 0">
                <div class="bg-white border border-slate-100 rounded-[2.5rem] p-10 shadow-sm space-y-3">
                    <p class="text-sm font-black text-slate-900">No itinerary saved yet</p>
                    <p class="text-sm font-bold text-slate-500">Click “Add day” to start building the itinerary.</p>
                </div>
            </template>

            <template x-for="(item, idx) in items" :key="item._key">
                <div class="bg-white border border-slate-100 rounded-[2.5rem] p-8 shadow-sm">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-black" x-text="'D' + item.day_number"></div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Day</p>
                                <input type="number" min="1" class="mt-1 w-24 border border-slate-200 rounded-xl px-3 py-2 font-black text-slate-900" x-model.number="item.day_number">
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-2 justify-end">
                            <button type="button" @click="moveUp(idx)" :disabled="idx === 0" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-black rounded-xl hover:bg-slate-50 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                Up
                            </button>
                            <button type="button" @click="moveDown(idx)" :disabled="idx === items.length - 1" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-black rounded-xl hover:bg-slate-50 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                Down
                            </button>
                            <button type="button" @click="removeDay(idx)" class="px-4 py-2 bg-rose-600 text-white font-black rounded-xl hover:bg-rose-700 transition-all">
                                Remove
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Title</p>
                            <input type="text" class="w-full border border-slate-200 rounded-2xl px-4 py-3 font-bold text-slate-900" x-model="item.title" placeholder="e.g. Arusha to Tarangire">
                        </div>

                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Description</p>
                            <textarea rows="5" class="w-full border border-slate-200 rounded-2xl px-4 py-3 font-bold text-slate-900" x-model="item.description" placeholder="Describe the day schedule, highlights, and notes..."></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Accommodation</p>
                                <input type="text" class="w-full border border-slate-200 rounded-2xl px-4 py-3 font-bold text-slate-900" x-model="item.accommodation" placeholder="e.g. Gran Melia Arusha">
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Meals</p>
                                <input type="text" class="w-full border border-slate-200 rounded-2xl px-4 py-3 font-bold text-slate-900" x-model="item.meals" placeholder="e.g. B, L, D">
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <script>
        function itineraryBuilder() {
            return {
                selectedTourId: '{{ (int) (request('tour_id') ?? 0) }}' || '',
                tour: null,
                items: [],
                loading: false,
                saving: false,
                message: '',
                messageType: 'success',

                init() {
                    if (this.selectedTourId) {
                        this.loadTour();
                    }
                },

                csrf() {
                    const el = document.querySelector('meta[name="csrf-token"]');
                    return el ? el.getAttribute('content') : '';
                },

                setMessage(type, text) {
                    this.messageType = type;
                    this.message = text;
                    window.setTimeout(() => {
                        if (this.message === text) {
                            this.message = '';
                        }
                    }, 6000);
                },

                async loadTour() {
                    if (!this.selectedTourId) {
                        this.tour = null;
                        this.items = [];
                        return;
                    }

                    this.loading = true;
                    this.message = '';

                    try {
                        const url = `{{ url('/admin/tours/itinerary-builder') }}/${this.selectedTourId}`;
                        const res = await fetch(url, {
                            headers: {
                                'Accept': 'application/json',
                            },
                        });

                        const json = await res.json();
                        if (!res.ok || !(json && json.success)) {
                            throw new Error((json && json.message) ? json.message : 'Failed to load itinerary');
                        }

                        this.tour = json.data.tour;
                        const raw = (json.data.itineraries || []).slice().sort((a, b) => (a.day_number || 0) - (b.day_number || 0));
                        this.items = raw.map((r) => ({
                            _key: (r.id ? String(r.id) : (String(Date.now()) + Math.random())),
                            day_number: r.day_number || 1,
                            title: r.title || '',
                            description: r.description || '',
                            accommodation: r.accommodation || '',
                            meals: r.meals || '',
                        }));

                        if (this.items.length === 0) {
                            this.setMessage('success', 'Tour loaded. Start by adding days.');
                        }
                    } catch (e) {
                        this.tour = null;
                        this.items = [];
                        this.setMessage('error', e.message || 'Failed to load itinerary');
                    } finally {
                        this.loading = false;
                    }
                },

                addDay() {
                    const maxDay = this.items.reduce((m, i) => Math.max(m, Number(i.day_number) || 0), 0);
                    const nextDay = maxDay + 1;
                    this.items.push({
                        _key: String(Date.now()) + Math.random(),
                        day_number: nextDay,
                        title: '',
                        description: '',
                        accommodation: '',
                        meals: '',
                    });
                },

                removeDay(idx) {
                    this.items.splice(idx, 1);
                },

                moveUp(idx) {
                    if (idx <= 0) return;
                    const tmp = this.items[idx - 1];
                    this.items[idx - 1] = this.items[idx];
                    this.items[idx] = tmp;
                },

                moveDown(idx) {
                    if (idx >= this.items.length - 1) return;
                    const tmp = this.items[idx + 1];
                    this.items[idx + 1] = this.items[idx];
                    this.items[idx] = tmp;
                },

                normalizeDayNumbers() {
                    const sorted = this.items.slice().sort((a, b) => (a.day_number || 0) - (b.day_number || 0));
                    sorted.forEach((it, i) => {
                        it.day_number = i + 1;
                    });
                    this.items = sorted;
                },

                async save() {
                    if (!this.selectedTourId) return;
                    if (this.items.length === 0) {
                        this.setMessage('error', 'Add at least one day before saving');
                        return;
                    }

                    this.saving = true;
                    this.message = '';

                    try {
                        const url = `{{ url('/admin/tours/itinerary-builder') }}/${this.selectedTourId}`;
                        const payload = {
                            itineraries: this.items.map((it) => ({
                                day_number: Number(it.day_number) || 1,
                                title: (it.title || '').trim(),
                                description: (it.description || '').trim(),
                                accommodation: (it.accommodation || '').trim() || null,
                                meals: (it.meals || '').trim() || null,
                            })),
                        };

                        const res = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': this.csrf(),
                            },
                            body: JSON.stringify(payload),
                        });

                        const json = await res.json();
                        if (!res.ok || !(json && json.success)) {
                            const msg = (json && json.message) ? json.message : 'Failed to save itinerary';
                            throw new Error(msg);
                        }

                        this.setMessage('success', json.message || 'Saved');
                        await this.loadTour();
                    } catch (e) {
                        this.setMessage('error', e.message || 'Failed to save itinerary');
                    } finally {
                        this.saving = false;
                    }
                },
            }
        }
    </script>
</div>
@endsection
