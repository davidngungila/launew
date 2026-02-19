@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Pending Approvals</h1>
            <p class="text-slate-500 font-medium">Review and confirm new safari booking requests</p>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-white">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Client / ID</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tour Package</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Travel Date</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Price</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-slate-900">{{ $booking->customer_name }}</span>
                                <span class="text-[10px] font-bold text-slate-400 mt-0.5 tracking-widest">BK-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-sm font-bold text-slate-700 leading-tight w-48">{{ $booking->tour->name ?? 'Custom Safari' }}</p>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="text-xs font-black text-slate-900 bg-slate-100 px-3 py-1.5 rounded-lg">{{ $booking->start_date ? date('M d, Y', strtotime($booking->start_date)) : 'TBD' }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-xs font-black text-slate-900">${{ number_format($booking->total_price) }}</span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="px-4 py-2 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-600 hover:text-white transition-all">Review</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center text-slate-400 font-medium">No pending approvals</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-8 border-t border-slate-50 flex items-center justify-between">
            <p class="text-xs font-bold text-slate-400">Showing <span class="text-slate-900">{{ $bookings->firstItem() ?? 0 }}</span> to <span class="text-slate-900">{{ $bookings->lastItem() ?? 0 }}</span> of <span class="text-slate-900">{{ $bookings->total() }}</span> Bookings</p>
            <div>{{ $bookings->links('vendor.pagination.tailwind') }}</div>
        </div>
    </div>
</div>
@endsection
