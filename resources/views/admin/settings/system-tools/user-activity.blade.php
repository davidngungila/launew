@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-20">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">User Activity</h1>
            <p class="text-slate-500 font-medium">Filterable audit trail (exportable)</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.system-tools.logs') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">System Logs</a>
            <a href="{{ route('admin.settings.system-tools.user-activity.export-csv', request()->query()) }}" class="px-5 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all">Export CSV</a>
        </div>
    </div>

    <form method="GET" class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="space-y-1.5">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">User</label>
                <select name="user_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900">
                    <option value="">All</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ (string) $userId === (string) $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="space-y-1.5">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Action contains</label>
                <input type="text" name="action" value="{{ $action }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" placeholder="settings.updated" />
            </div>
            <div class="space-y-1.5">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Start</label>
                <input type="date" name="start" value="{{ $start }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" />
            </div>
            <div class="space-y-1.5">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">End</label>
                <input type="date" name="end" value="{{ $end }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" />
            </div>
        </div>
        <div class="pt-4 flex items-center justify-end gap-4">
            <a href="{{ route('admin.settings.system-tools.user-activity') }}" class="px-8 py-3 text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">Reset</a>
            <button type="submit" class="px-8 py-3 bg-emerald-600 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl hover:bg-emerald-700 transition-all">Apply</button>
        </div>
    </form>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="text-left px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Time</th>
                        <th class="text-left px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">User</th>
                        <th class="text-left px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Action</th>
                        <th class="text-left px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Route</th>
                        <th class="text-left px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                        <th class="text-left px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Duration</th>
                        <th class="text-left px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Subject</th>
                        <th class="text-right px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">More</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                        <tr class="border-t border-slate-50">
                            <td class="px-8 py-5 text-sm font-bold text-slate-700">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-8 py-5 text-sm font-bold text-slate-700">{{ $log->user->name ?? 'System' }}</td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-2 bg-slate-50 border border-slate-100 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-700">{{ $log->action }}</span>
                            </td>
                            <td class="px-8 py-5 text-xs font-bold text-slate-600">
                                @php($routeName = data_get($log->properties, 'route_name'))
                                @php($method = data_get($log->properties, 'method'))
                                <div class="font-black">{{ $routeName ?: 'N/A' }}</div>
                                <div class="text-[10px] text-slate-400 font-black uppercase tracking-widest">{{ $method ?: '' }}</div>
                            </td>
                            <td class="px-8 py-5 text-xs font-black text-slate-700">
                                {{ data_get($log->properties, 'status_code') ?? 'N/A' }}
                            </td>
                            <td class="px-8 py-5 text-xs font-black text-slate-700">
                                {{ data_get($log->properties, 'duration_ms') ? data_get($log->properties, 'duration_ms') . 'ms' : 'N/A' }}
                            </td>
                            <td class="px-8 py-5 text-xs font-bold text-slate-500">
                                {{ $log->subject_type ? class_basename($log->subject_type) : 'N/A' }}{{ $log->subject_id ? ' #' . $log->subject_id : '' }}
                            </td>
                            <td class="px-8 py-5 text-right">
                                <a href="{{ route('admin.settings.activity-logs.show', $log->id) }}" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-600 hover:bg-slate-50 transition-all">View More</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-8 py-6 border-t border-slate-50">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
