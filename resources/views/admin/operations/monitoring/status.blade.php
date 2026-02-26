@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Trip Status</h1>
            <p class="text-slate-500 font-medium">Live monitoring for trips, incidents, and customer feedback</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.operations.monitoring.incidents') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Incident Reports</a>
            <a href="{{ route('admin.operations.monitoring.feedback') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">Customer Feedback</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Active Trips</p>
            <h4 class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($stats['active_trips'] ?? 0) }}</h4>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Pending Incidents</p>
            <h4 class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($stats['pending_incidents'] ?? 0) }}</h4>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">New Feedback</p>
            <h4 class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($stats['new_feedback'] ?? 0) }}</h4>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-black text-slate-900 tracking-tight">Recent Incidents</h3>
                    <p class="text-slate-500 font-medium text-sm">Latest operational issues reported</p>
                </div>
                <a href="{{ route('admin.operations.monitoring.incidents.create') }}" class="px-5 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/10">New</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($recentIncidents as $i)
                    <div class="px-8 py-5 flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <div class="text-sm font-black text-slate-900 truncate">{{ $i->title }}</div>
                            <div class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                Severity: {{ strtoupper($i->severity) }} · Status: {{ str_replace('_', ' ', strtoupper($i->status)) }}
                                @if($i->booking_id)
                                    · Booking #BK-{{ str_pad($i->booking_id, 4, '0', STR_PAD_LEFT) }}
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('admin.operations.monitoring.incidents.edit', $i) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all"><i class="ph-bold ph-pencil-simple text-lg"></i></a>
                    </div>
                @empty
                    <div class="px-8 py-10 text-center text-slate-400 font-medium">No incidents yet</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-black text-slate-900 tracking-tight">Recent Feedback</h3>
                    <p class="text-slate-500 font-medium text-sm">Latest customer messages and ratings</p>
                </div>
                <a href="{{ route('admin.operations.monitoring.feedback.create') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">New</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($recentFeedback as $f)
                    <div class="px-8 py-5 flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <div class="text-sm font-black text-slate-900 truncate">{{ $f->customer_name ?? ($f->customer_email ?? 'Customer') }}</div>
                            <div class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                Status: {{ strtoupper($f->status) }}
                                @if(!is_null($f->rating))
                                    · Rating: {{ $f->rating }}/5
                                @endif
                                @if($f->booking_id)
                                    · Booking #BK-{{ str_pad($f->booking_id, 4, '0', STR_PAD_LEFT) }}
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('admin.operations.monitoring.feedback.edit', $f) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all"><i class="ph-bold ph-pencil-simple text-lg"></i></a>
                    </div>
                @empty
                    <div class="px-8 py-10 text-center text-slate-400 font-medium">No feedback yet</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
