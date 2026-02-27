@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 pb-20">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Backup</h1>
            <p class="text-slate-500 font-medium">Run backups and download artifacts</p>
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ route('admin.settings.system-tools.backup.run') }}" method="POST" onsubmit="return confirm('Run backup now? This may take some time.')">
                @csrf
                <button type="submit" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">Run Backup</button>
            </form>
            <a href="{{ route('admin.settings.system-tools.maintenance') }}" class="px-5 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all">Maintenance</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 bg-slate-50/50 border-b border-slate-100">
            <div class="text-xs font-black uppercase tracking-widest text-slate-400">Backup files</div>
            <div class="text-xs font-bold text-slate-500 mt-1">Storage path: <span class="text-slate-900">backups/</span></div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-white">
                        <th class="text-left px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Path</th>
                        <th class="text-right px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Download</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($paths as $p)
                        <tr>
                            <td class="px-8 py-5 text-sm font-bold text-slate-700">{{ $p }}</td>
                            <td class="px-8 py-5 text-right">
                                <a href="{{ route('admin.settings.system-tools.backup.download', ['path' => $p]) }}" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-600 hover:bg-slate-50 transition-all">Download</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="px-8 py-10 text-center text-slate-400 font-bold">No backup files found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-slate-900 rounded-2xl p-8 text-white shadow-xl shadow-slate-900/10">
        <h3 class="text-lg font-black mb-2">Notes</h3>
        <div class="text-sm font-medium text-white/70 leading-relaxed">
            This feature calls <span class="font-black">backup:run</span>. Ensure the backup package is installed and configured.
        </div>
    </div>
</div>
@endsection
