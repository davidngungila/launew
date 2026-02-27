@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-20">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">System Logs</h1>
            <p class="text-slate-500 font-medium">Tail and filter application logs</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.system-tools.logs.download') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Download</a>
            <a href="{{ route('admin.settings.system-tools.user-activity') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">User Activity</a>
            <a href="{{ route('admin.settings.system-tools.maintenance') }}" class="px-5 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all">Maintenance</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">File</div>
            <div class="mt-2 text-xs font-bold text-slate-700 break-all">{{ $stats['path'] ?? '' }}</div>
            <div class="mt-3 text-sm font-black text-slate-900">{{ ($stats['file_exists'] ?? false) ? 'Available' : 'Missing' }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">File Size</div>
            <div class="mt-3 text-3xl font-black text-slate-900">{{ number_format((float) (($stats['file_size'] ?? 0) / 1024 / 1024), 2) }}MB</div>
            <div class="mt-2 text-xs font-bold text-slate-400">Tail limit: {{ $limit }}</div>
        </div>
        <div class="bg-slate-900 rounded-2xl p-6 text-white shadow-xl">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-white/50">Lines</div>
            <div class="mt-3 text-3xl font-black">{{ $stats['shown'] ?? 0 }}</div>
            <div class="mt-2 text-xs font-bold text-white/60">Filtered from {{ $stats['total_lines'] ?? 0 }}</div>
        </div>
    </div>

    <form method="GET" class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="space-y-1.5">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Level</label>
                <select name="level" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900">
                    @php($levels = ['', 'DEBUG', 'INFO', 'NOTICE', 'WARNING', 'ERROR', 'CRITICAL', 'ALERT', 'EMERGENCY'])
                    @foreach($levels as $lv)
                        <option value="{{ $lv }}" {{ strtoupper((string) $level) === $lv ? 'selected' : '' }}>{{ $lv === '' ? 'Any' : $lv }}</option>
                    @endforeach
                </select>
            </div>
            <div class="space-y-1.5 md:col-span-2">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Search</label>
                <input type="text" name="q" value="{{ $q }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" placeholder="Exception, booking, payment..." />
            </div>
            <div class="space-y-1.5">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Tail lines</label>
                <input type="number" name="limit" value="{{ $limit }}" min="50" max="2000" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" />
            </div>
        </div>
        <div class="pt-4 flex items-center justify-end gap-4">
            <a href="{{ route('admin.settings.system-tools.logs') }}" class="px-8 py-3 text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">Reset</a>
            <button type="submit" class="px-8 py-3 bg-emerald-600 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl hover:bg-emerald-700 transition-all">Apply</button>
        </div>
    </form>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
            <div class="text-xs font-black uppercase tracking-widest text-slate-400">Tail output</div>
            <div class="text-xs font-bold text-slate-500">Refresh page to re-tail</div>
        </div>
        <div class="overflow-x-auto">
            <pre class="p-6 text-[11px] leading-relaxed whitespace-pre-wrap break-words font-mono text-slate-800">@forelse($lines as $ln){{ $ln }}
@empty(No lines)
@endforelse</pre>
        </div>
    </div>
</div>
@endsection
