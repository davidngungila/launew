@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 pb-20">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-all">
            <i class="ph ph-caret-left-bold"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Modify Assignments</h1>
            <p class="text-slate-500 font-medium">Assign crew and vehicle for booking #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-10 space-y-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Lead Guide</p>
                <p class="text-lg font-black text-slate-900 mt-2">{{ $booking->guide->name ?? 'Unassigned' }}</p>
            </div>
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Lead Driver</p>
                <p class="text-lg font-black text-slate-900 mt-2">{{ $booking->driver->name ?? 'Unassigned' }}</p>
            </div>
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Expedition 4x4</p>
                <p class="text-lg font-black text-slate-900 mt-2">{{ $booking->vehicle->plate_number ?? 'Unassigned' }}</p>
                <p class="text-[10px] font-black text-slate-400 mt-1 uppercase tracking-widest">{{ $booking->vehicle->model ?? 'L-Series' }}</p>
            </div>
        </div>

        <form action="{{ route('admin.bookings.assignments.update', $booking->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-1.5">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Lead Guide</label>
                    <select name="guide_id" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none cursor-pointer">
                        <option value="">Unassigned</option>
                        @foreach($guides as $g)
                            <option value="{{ $g->id }}" {{ (string) old('guide_id', $booking->guide_id) === (string) $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Lead Driver</label>
                    <select name="driver_id" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none cursor-pointer">
                        <option value="">Unassigned</option>
                        @foreach($drivers as $d)
                            <option value="{{ $d->id }}" {{ (string) old('driver_id', $booking->driver_id) === (string) $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Vehicle</label>
                    <select name="vehicle_id" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none cursor-pointer">
                        <option value="">Unassigned</option>
                        @foreach($vehicles as $v)
                            <option value="{{ $v->id }}" {{ (string) old('vehicle_id', $booking->vehicle_id) === (string) $v->id ? 'selected' : '' }}>{{ $v->plate_number }} · {{ $v->model }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-4">
                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">Cancel</a>
                <button type="submit" class="px-10 py-4 bg-emerald-600 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-emerald-500/20 hover:bg-emerald-700 transition-all">Save Assignments</button>
            </div>
        </form>
    </div>
</div>
@endsection
