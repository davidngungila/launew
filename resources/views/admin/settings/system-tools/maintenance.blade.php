@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 pb-20">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Maintenance Mode</h1>
            <p class="text-slate-500 font-medium">Safely take the site offline for maintenance</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.system-tools.logs') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">System Logs</a>
            <a href="{{ route('admin.settings.system-tools.backup') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Backup</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Status</div>
            <div class="mt-3 text-2xl font-black {{ $down ? 'text-rose-600' : 'text-emerald-600' }}">{{ $down ? 'DOWN' : 'UP' }}</div>
            <div class="mt-2 text-xs font-bold text-slate-400">{{ $down ? 'Site is in maintenance mode' : 'Site is live' }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 md:col-span-2">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Current payload</div>
            <pre class="mt-3 text-xs bg-slate-50 border border-slate-100 rounded-2xl p-4 overflow-auto">{{ json_encode($payload ?? [], JSON_PRETTY_PRINT) }}</pre>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 space-y-6">
            <div>
                <h3 class="text-lg font-black text-slate-900 tracking-tight">Enable Maintenance</h3>
                <p class="text-slate-500 text-sm font-medium">Set a message, retry time and optional secret bypass.</p>
            </div>

            <form action="{{ route('admin.settings.system-tools.maintenance.enable') }}" method="POST" class="space-y-4">
                @csrf
                <div class="space-y-1.5">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Message</label>
                    <input type="text" name="message" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" placeholder="We are upgrading. Please try again shortly." />
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Retry (seconds)</label>
                        <input type="number" name="retry" min="0" max="3600" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" placeholder="60" />
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Secret (optional)</label>
                        <input type="text" name="secret" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" placeholder="secret-token" />
                    </div>
                </div>

                <button type="submit" class="w-full px-8 py-3 bg-rose-600 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl hover:bg-rose-700 transition-all" {{ $down ? 'disabled' : '' }}>Enable</button>
                <div class="text-xs font-bold text-slate-400">When secret is set, users can access via <span class="text-slate-900">/secret-token</span> (Laravel maintenance bypass).</div>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 space-y-6">
            <div>
                <h3 class="text-lg font-black text-slate-900 tracking-tight">Disable Maintenance</h3>
                <p class="text-slate-500 text-sm font-medium">Bring the site back online.</p>
            </div>

            <form action="{{ route('admin.settings.system-tools.maintenance.disable') }}" method="POST" onsubmit="return confirm('Disable maintenance mode?')">
                @csrf
                <button type="submit" class="w-full px-8 py-3 bg-emerald-600 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl hover:bg-emerald-700 transition-all" {{ $down ? '' : 'disabled' }}>Disable</button>
            </form>

            <div class="bg-slate-900 rounded-2xl p-6 text-white">
                <div class="text-[10px] font-black uppercase tracking-[0.2em] text-white/50">Recommended</div>
                <div class="mt-2 text-sm font-bold text-white/70">Run backup before deployment and monitor logs while maintenance is enabled.</div>
                <div class="mt-4 flex items-center gap-3">
                    <a href="{{ route('admin.settings.system-tools.backup') }}" class="px-5 py-2.5 bg-white/10 text-white font-bold rounded-xl hover:bg-white/15 transition-all">Backup</a>
                    <a href="{{ route('admin.settings.system-tools.logs') }}" class="px-5 py-2.5 bg-white/10 text-white font-bold rounded-xl hover:bg-white/15 transition-all">Logs</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
