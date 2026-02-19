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
            <button class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <i class="ph ph-plus"></i>
                New Manual Booking
            </button>
        </div>
    </div>

    <!-- Quick Stats for Bookings -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @foreach([
            ['label' => 'Total Bookings', 'val' => '1,284', 'trend' => '+12%', 'icon' => 'list-checks', 'color' => 'blue'],
            ['label' => 'Active Trips', 'val' => '42', 'trend' => '8 Guides', 'icon' => 'jeep', 'color' => 'emerald'],
            ['label' => 'Revenue', 'val' => '$428.5k', 'trend' => '+18.2%', 'icon' => 'currency-dollar', 'color' => 'orange'],
            ['label' => 'Cancellations', 'val' => '3', 'trend' => '-2%', 'icon' => 'x-circle', 'color' => 'red'],
        ] as $stat)
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-{{ $stat['color'] }}-50 text-{{ $stat['color'] }}-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="ph ph-{{ $stat['icon'] }} text-2xl"></i>
                </div>
                <span class="text-[10px] font-black text-{{ $stat['color'] === 'red' ? 'red' : 'emerald' }}-500">{{ $stat['trend'] }}</span>
            </div>
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">{{ $stat['label'] }}</p>
            <h4 class="text-2xl font-black text-slate-900 tracking-tight">{{ $stat['val'] }}</h4>
        </div>
        @endforeach
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
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tour Package</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Travel Dates</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Payment</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach([
                        ['id' => 'BK-9281', 'client' => 'Michael Corleone', 'tour' => '8 Days Northern Circuit Premium', 'dates' => 'Oct 12 - Oct 20', 'val' => '$12,400', 'status' => 'Confirmed', 'paid' => 100, 'color' => 'emerald'],
                        ['id' => 'BK-9282', 'client' => 'Thomas Shelby', 'tour' => '3 Days Serengeti Sky Safari', 'dates' => 'Nov 05 - Nov 08', 'val' => '$4,200', 'status' => 'Pending', 'paid' => 30, 'color' => 'orange'],
                        ['id' => 'BK-9283', 'client' => 'Daenerys Targaryen', 'tour' => '14 Days Tanzanian Odyssey', 'dates' => 'Dec 22 - Jan 05', 'val' => '$32,500', 'status' => 'Paid', 'paid' => 100, 'color' => 'emerald'],
                        ['id' => 'BK-9284', 'client' => 'Jon Snow', 'tour' => '7 Days Kili Marangu Route', 'dates' => 'Mar 01 - Mar 08', 'val' => '$2,800', 'status' => 'Inquiry', 'paid' => 0, 'color' => 'slate'],
                        ['id' => 'BK-9285', 'client' => 'Arya Stark', 'tour' => '5 Days Zanzibar Beach Escape', 'dates' => 'Apr 10 - Apr 15', 'val' => '$1,950', 'status' => 'Cancelled', 'paid' => 100, 'color' => 'red'],
                    ] as $booking)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-slate-900">{{ $booking['client'] }}</span>
                                <span class="text-[10px] font-bold text-slate-400 mt-0.5 tracking-widest">{{ $booking['id'] }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-sm font-bold text-slate-700 leading-tight w-48">{{ $booking['tour'] }}</p>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="text-xs font-black text-slate-900 bg-slate-100 px-3 py-1.5 rounded-lg">{{ $booking['dates'] }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-1.5 min-w-[120px]">
                                <div class="flex justify-between text-[10px] font-black text-slate-900">
                                    <span>{{ $booking['val'] }}</span>
                                    <span>{{ $booking['paid'] }}%</span>
                                </div>
                                <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-{{ $booking['color'] === 'slate' ? 'slate-300' : $booking['color'].'-500' }} rounded-full" style="width: {{ $booking['paid'] }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="inline-flex px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-{{ $booking['color'] }}-50 text-{{ $booking['color'] }}-600 border border-{{ $booking['color'] }}-100">
                                {{ $booking['status'] }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all"><i class="ph-bold ph-eye text-lg"></i></button>
                                <button class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all"><i class="ph-bold ph-pencil-simple text-lg"></i></button>
                                <button class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all"><i class="ph-bold ph-trash text-lg"></i></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-8 border-t border-slate-50 flex items-center justify-between">
            <p class="text-xs font-bold text-slate-400">Showing <span class="text-slate-900">5</span> of <span class="text-slate-900">1,284</span> Bookings</p>
            <div class="flex items-center gap-2">
                <button class="w-10 h-10 rounded-xl border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-slate-50 transition-all"><i class="ph ph-caret-left"></i></button>
                <div class="flex items-center gap-1">
                    <button class="w-10 h-10 rounded-xl bg-emerald-600 text-white font-black text-xs shadow-lg shadow-emerald-500/20">1</button>
                    <button class="w-10 h-10 rounded-xl hover:bg-slate-50 text-slate-400 font-bold text-xs transition-all">2</button>
                    <button class="w-10 h-10 rounded-xl hover:bg-slate-50 text-slate-400 font-bold text-xs transition-all">3</button>
                </div>
                <button class="w-10 h-10 rounded-xl border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-slate-50 transition-all"><i class="ph ph-caret-right"></i></button>
            </div>
        </div>
    </div>
</div>
@endsection
