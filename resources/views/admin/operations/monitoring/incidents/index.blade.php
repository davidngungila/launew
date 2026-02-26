@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Incident Reports</h1>
            <p class="text-slate-500 font-medium">Log and manage operational incidents</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.operations.monitoring.status') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Trip Status</a>
            <a href="{{ route('admin.operations.monitoring.incidents.create') }}" class="px-5 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/10">New Incident</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-white">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Title</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Severity</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Booking</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($incidents as $incident)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5">
                                <div class="text-sm font-black text-slate-900">{{ $incident->title }}</div>
                                <div class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $incident->created_at?->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-[10px] font-black uppercase tracking-widest">{{ strtoupper($incident->severity) }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-[10px] font-black uppercase tracking-widest">{{ str_replace('_', ' ', strtoupper($incident->status)) }}</span>
                            </td>
                            <td class="px-6 py-5">
                                @if($incident->booking_id)
                                    <a href="{{ route('admin.bookings.show', $incident->booking_id) }}" class="text-xs font-black text-emerald-700 hover:underline">#BK-{{ str_pad($incident->booking_id, 4, '0', STR_PAD_LEFT) }}</a>
                                @else
                                    <span class="text-xs font-bold text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.operations.monitoring.incidents.edit', $incident) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all"><i class="ph-bold ph-pencil-simple text-lg"></i></a>
                                    <form action="{{ route('admin.operations.monitoring.incidents.destroy', $incident) }}" method="POST" onsubmit="return confirm('Delete this incident report?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all"><i class="ph-bold ph-trash text-lg"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center">
                                <p class="text-slate-400 font-medium">No incident reports found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-8 border-t border-slate-50 flex items-center justify-between">
            <p class="text-xs font-bold text-slate-400">Showing <span class="text-slate-900">{{ $incidents->firstItem() ?? 0 }}</span> to <span class="text-slate-900">{{ $incidents->lastItem() ?? 0 }}</span> of <span class="text-slate-900">{{ $incidents->total() }}</span> Incidents</p>
            <div class="flex items-center gap-2">{{ $incidents->links('vendor.pagination.tailwind') }}</div>
        </div>
    </div>
</div>
@endsection
