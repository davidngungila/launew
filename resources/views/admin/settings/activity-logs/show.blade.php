@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 pb-20">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.settings.activity-logs.index') }}" class="w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-all">
            <i class="ph ph-caret-left-bold"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Activity Log Details</h1>
            <p class="text-slate-500 font-medium">{{ $log->created_at->format('Y-m-d H:i:s') }} · {{ $log->user->name ?? 'System' }}</p>
        </div>
    </div>

    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-8 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="px-6 py-4 bg-slate-50 border border-slate-100 rounded-xl">
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Action</div>
                <div class="text-sm font-black text-slate-900 mt-1">{{ $log->action }}</div>
            </div>
            <div class="px-6 py-4 bg-slate-50 border border-slate-100 rounded-xl">
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Subject</div>
                <div class="text-sm font-black text-slate-900 mt-1">{{ $log->subject_type ? class_basename($log->subject_type) : 'N/A' }}{{ $log->subject_id ? ' #' . $log->subject_id : '' }}</div>
            </div>
            <div class="px-6 py-4 bg-slate-50 border border-slate-100 rounded-xl">
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">IP Address</div>
                <div class="text-sm font-black text-slate-900 mt-1">{{ $log->ip_address ?? 'N/A' }}</div>
            </div>
            <div class="px-6 py-4 bg-slate-50 border border-slate-100 rounded-xl">
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">User Agent</div>
                <div class="text-xs font-bold text-slate-700 mt-1 break-words">{{ $log->user_agent ?? 'N/A' }}</div>
            </div>
        </div>

        <div>
            <div class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-4">Properties</div>
            <pre class="w-full p-6 bg-slate-950 text-slate-100 rounded-2xl text-xs overflow-auto">{{ json_encode($log->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
        </div>
    </div>
</div>
@endsection
