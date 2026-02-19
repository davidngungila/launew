@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Booking Master List</h1>
            <p class="text-slate-500 font-medium">Manage all safari reservations and customer travel plans</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                <i class="ph ph-funnel"></i>
                Advanced Filter
            </button>
            <a href="{{ route('admin.bookings.create') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <i class="ph ph-plus"></i>
                New Manual Booking
            </a>
        </div>
    </div>

    <!-- Quick Stats for Bookings -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <!-- Quick Stats for Bookings -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="ph ph-list-checks text-2xl"></i>
                </div>
                <span class="text-[10px] font-black text-emerald-500">+100%</span>
            </div>
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Total Bookings</p>
            <h4 class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($stats['total']) }}</h4>
        </div>
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="ph ph-shield-check text-2xl"></i>
                </div>
                <span class="text-[10px] font-black text-emerald-500">Live</span>
            </div>
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Pending Approvals</p>
            <h4 class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($stats['pending']) }}</h4>
        </div>
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="ph ph-currency-dollar text-2xl"></i>
                </div>
                <span class="text-[10px] font-black text-emerald-500">Total</span>
            </div>
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Total Revenue</p>
            <h4 class="text-2xl font-black text-slate-900 tracking-tight">${{ number_format($stats['revenue'] / 1000, 1) }}k</h4>
        </div>
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="ph ph-check-circle text-2xl"></i>
                </div>
                <span class="text-[10px] font-black text-emerald-500">Active</span>
            </div>
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Confirmed Trips</p>
            <h4 class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($stats['confirmed']) }}</h4>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <!-- Filter Bar -->
        <div class="p-8 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/30">
            <div class="relative w-full max-w-sm">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                    <i class="ph ph-magnifying-glass"></i>
                </span>
                <input type="text" class="block w-full pl-11 pr-4 py-3 border border-slate-200 rounded-2xl bg-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all shadow-sm" placeholder="Search by name, trip ID or tour...">
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-400 mr-2 uppercase tracking-widest">Sort By:</span>
                <select class="bg-transparent text-sm font-black text-slate-900 focus:outline-none cursor-pointer">
                    <option>Travel Date (Newest)</option>
                    <option>Travel Date (Oldest)</option>
                    <option>Total Value</option>
                    <option>Payment Status</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-white">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Client / ID</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Booked On</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tour Package</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Pax</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Travel Dates</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Payment</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
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
                        <td class="px-8 py-6 text-center">
                            <span class="text-[10px] font-bold text-slate-500">{{ $booking->created_at->format('M d, Y') }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-sm font-bold text-slate-700 leading-tight w-48">{{ $booking->tour->name ?? 'Custom Safari' }}</p>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="text-xs font-black text-slate-900 bg-blue-50 text-blue-600 px-3 py-1 rounded-lg">{{ $booking->adults + $booking->children }} Pax</span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="text-xs font-black text-slate-900 bg-slate-100 px-3 py-1.5 rounded-lg">{{ $booking->start_date ? date('M d, Y', strtotime($booking->start_date)) : 'TBD' }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-1.5 min-w-[120px]">
                                <div class="flex justify-between text-[10px] font-black text-slate-900">
                                    <span>${{ number_format($booking->total_price) }}</span>
                                    <span>{{ $booking->payment_status === 'paid' ? '100%' : '30%' }}</span>
                                </div>
                                <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-{{ $booking->payment_status === 'paid' ? 'emerald' : 'orange' }}-500 rounded-full" style="width: {{ $booking->payment_status === 'paid' ? '100%' : '30%' }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            @php
                                $color = match($booking->status) {
                                    'confirmed' => 'emerald',
                                    'pending' => 'orange',
                                    'cancelled' => 'red',
                                    default => 'slate'
                                };
                            @endphp
                            <span class="inline-flex px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-{{ $color }}-50 text-{{ $color }}-600 border border-{{ $color }}-100">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all"><i class="ph-bold ph-eye text-lg"></i></a>
                                <button class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all"><i class="ph-bold ph-pencil-simple text-lg"></i></button>
                                <button class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all"><i class="ph-bold ph-trash text-lg"></i></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-12 text-center">
                            <p class="text-slate-400 font-medium">No bookings found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-8 border-t border-slate-50 flex items-center justify-between">
            <p class="text-xs font-bold text-slate-400">Showing <span class="text-slate-900">{{ $bookings->firstItem() ?? 0 }}</span> to <span class="text-slate-900">{{ $bookings->lastItem() ?? 0 }}</span> of <span class="text-slate-900">{{ $bookings->total() }}</span> Bookings</p>
            <div class="flex items-center gap-2">
                {{ $bookings->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</div>
@endsection
