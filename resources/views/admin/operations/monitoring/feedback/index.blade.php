@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Customer Feedback</h1>
            <p class="text-slate-500 font-medium">Track customer satisfaction, ratings, and follow-up</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.operations.monitoring.status') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Trip Status</a>
            <a href="{{ route('admin.operations.monitoring.feedback.create') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">New Feedback</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-white">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Customer</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Rating</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Booking</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($feedback as $row)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5">
                                <div class="text-sm font-black text-slate-900">{{ $row->customer_name ?? ($row->customer_email ?? 'Customer') }}</div>
                                <div class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $row->created_at?->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-[10px] font-black uppercase tracking-widest">{{ is_null($row->rating) ? '—' : ($row->rating . '/5') }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-[10px] font-black uppercase tracking-widest">{{ strtoupper($row->status) }}</span>
                            </td>
                            <td class="px-6 py-5">
                                @if($row->booking_id)
                                    <a href="{{ route('admin.bookings.show', $row->booking_id) }}" class="text-xs font-black text-emerald-700 hover:underline">#BK-{{ str_pad($row->booking_id, 4, '0', STR_PAD_LEFT) }}</a>
                                @else
                                    <span class="text-xs font-bold text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.operations.monitoring.feedback.edit', $row) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all"><i class="ph-bold ph-pencil-simple text-lg"></i></a>
                                    <form action="{{ route('admin.operations.monitoring.feedback.destroy', $row) }}" method="POST" onsubmit="return confirm('Delete this feedback entry?');">
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
                                <p class="text-slate-400 font-medium">No feedback entries found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-8 border-t border-slate-50 flex items-center justify-between">
            <p class="text-xs font-bold text-slate-400">Showing <span class="text-slate-900">{{ $feedback->firstItem() ?? 0 }}</span> to <span class="text-slate-900">{{ $feedback->lastItem() ?? 0 }}</span> of <span class="text-slate-900">{{ $feedback->total() }}</span> Feedback</p>
            <div class="flex items-center gap-2">{{ $feedback->links('vendor.pagination.tailwind') }}</div>
        </div>
    </div>
</div>
@endsection
