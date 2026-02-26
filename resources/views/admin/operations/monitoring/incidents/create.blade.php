@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 pb-20">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.operations.monitoring.incidents') }}" class="w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-all">
            <i class="ph ph-caret-left-bold"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">New Incident Report</h1>
            <p class="text-slate-500 font-medium">Capture an operational incident and track resolution</p>
        </div>
    </div>

    <form action="{{ route('admin.operations.monitoring.incidents.store') }}" method="POST" class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-10 space-y-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-1.5 md:col-span-2">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Title</label>
                <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Severity</label>
                <select name="severity" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none cursor-pointer">
                    @foreach(['low','medium','high','critical'] as $s)
                        <option value="{{ $s }}" {{ old('severity','medium') === $s ? 'selected' : '' }}>{{ strtoupper($s) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Status</label>
                <select name="status" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none cursor-pointer">
                    @foreach(['open','in_progress','resolved','closed'] as $st)
                        <option value="{{ $st }}" {{ old('status','open') === $st ? 'selected' : '' }}>{{ str_replace('_',' ', strtoupper($st)) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Occurred At</label>
                <input type="datetime-local" name="occurred_at" value="{{ old('occurred_at') }}" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Booking (optional)</label>
                <select name="booking_id" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none cursor-pointer">
                    <option value="">None</option>
                    @foreach($bookings as $b)
                        <option value="{{ $b->id }}" {{ (string) old('booking_id') === (string) $b->id ? 'selected' : '' }}>BK-{{ str_pad($b->id, 4, '0', STR_PAD_LEFT) }} · {{ $b->customer_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1.5 md:col-span-2">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Description</label>
                <textarea name="description" rows="5" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">{{ old('description') }}</textarea>
            </div>

            <div class="space-y-1.5 md:col-span-2">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Resolution (optional)</label>
                <textarea name="resolution" rows="3" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">{{ old('resolution') }}</textarea>
            </div>
        </div>

        <div class="pt-4 flex items-center justify-end gap-4">
            <a href="{{ route('admin.operations.monitoring.incidents') }}" class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">Cancel</a>
            <button type="submit" class="px-10 py-4 bg-slate-900 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-slate-900/10 hover:bg-slate-800 transition-all">Save Incident</button>
        </div>
    </form>
</div>
@endsection
