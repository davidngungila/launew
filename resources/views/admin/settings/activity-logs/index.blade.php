@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-20">
    <div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Activity Logs</h1>
        <p class="text-slate-500 font-medium">Audit trail of system actions</p>
    </div>

    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
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
