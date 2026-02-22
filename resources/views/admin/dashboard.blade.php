@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Dashboard Overview</h1>
            <p class="text-slate-500 font-medium">Welcome back, <span class="text-emerald-600">{{ auth()->user()->name }}</span>. Here's your business at a glance.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                <i class="ph ph-calendar"></i>
                Feb 19 - Feb 26
            </button>
            <a href="{{ route('admin.bookings.create') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <i class="ph ph-plus"></i>
                Create Booking
            </a>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 group">
            <div class="flex items-center justify-between mb-6">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center transition-transform group-hover:scale-110">
                    <i class="ph-bold ph-calendar-check text-2xl"></i>
                </div>
                <div class="flex items-center gap-1 text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider">
                    <i class="ph-bold ph-trend-up"></i> +12%
                </div>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-[0.15em] mb-1">Total Bookings</p>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ number_format($stats['total_bookings'] ?? 0) }}</h3>
            <div class="mt-4 w-full h-1 bg-slate-50 rounded-full overflow-hidden">
                <div class="h-full bg-emerald-500 w-[70%]"></div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 group">
            <div class="flex items-center justify-between mb-6">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center transition-transform group-hover:scale-110">
                    <i class="ph-bold ph-currency-dollar text-2xl"></i>
                </div>
                <div class="flex items-center gap-1 text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider">
                    <i class="ph-bold ph-trend-up"></i> +24%
                </div>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-[0.15em] mb-1">Revenue (USD)</p>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight">${{ number_format($stats['revenue_total'] ?? 0) }}</h3>
            <div class="mt-4 w-full h-1 bg-slate-50 rounded-full overflow-hidden">
                <div class="h-full bg-blue-500 w-[85%]"></div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 group">
            <div class="flex items-center justify-between mb-6">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center transition-transform group-hover:scale-110">
                    <i class="ph-bold ph-users text-2xl"></i>
                </div>
                <div class="flex items-center gap-1 text-red-500 bg-red-50 px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider">
                    <i class="ph-bold ph-trend-down"></i> -2%
                </div>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-[0.15em] mb-1">Active Customers</p>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ number_format($stats['active_customers'] ?? 0) }}</h3>
            <div class="mt-4 w-full h-1 bg-slate-50 rounded-full overflow-hidden">
                <div class="h-full bg-purple-500 w-[60%]"></div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 group">
            <div class="flex items-center justify-between mb-6">
                <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center transition-transform group-hover:scale-110">
                    <i class="ph-bold ph-compass text-2xl"></i>
                </div>
                <div class="flex items-center gap-1 text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider">
                    <i class="ph-bold ph-plus"></i> 5 New
                </div>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-[0.15em] mb-1">Active Packages</p>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ number_format($stats['active_packages'] ?? 0) }}</h3>
            <div class="mt-4 w-full h-1 bg-slate-50 rounded-full overflow-hidden">
                <div class="h-full bg-orange-500 w-[45%]"></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Bookings Table -->
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">Recent Bookings</h3>
                        <p class="text-xs text-slate-500 font-medium mt-1">Showing latest activity from your customers</p>
                    </div>
                    <a href="{{ route('admin.bookings.index') }}" class="text-xs font-black text-emerald-600 uppercase tracking-widest hover:text-emerald-700">View All Bookings</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Customer</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tour Details</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Amount</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @php
                                $statusColor = fn($s) => match(strtolower((string) $s)) {
                                    'confirmed' => 'emerald',
                                    'pending' => 'orange',
                                    'cancelled' => 'red',
                                    'completed' => 'blue',
                                    default => 'slate',
                                };
                            @endphp

                            @forelse(($recentBookings ?? []) as $b)
                            @php
                                $initials = collect(explode(' ', trim((string) $b->customer_name)))->filter()->map(fn($p) => strtoupper(mb_substr($p, 0, 1)))->take(2)->implode('');
                                $tourName = $b->tour->name ?? 'Safari';
                                $color = $statusColor($b->status);
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors group cursor-pointer" onclick="window.location='{{ route('admin.bookings.show', $b->id) }}'">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 font-black text-xs group-hover:bg-white group-hover:shadow-md transition-all">
                                            {{ $initials ?: 'BK' }}
                                        </div>
                                        <span class="text-sm font-bold text-slate-900">{{ $b->customer_name }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <p class="text-sm font-bold text-slate-800">{{ $tourName }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">{{ $b->start_date ? date('M d, Y', strtotime($b->start_date)) : 'N/A' }}</p>
                                </td>
                                <td class="px-8 py-5 font-black text-slate-900 text-sm">${{ number_format($b->total_price ?? 0, 0) }}</td>
                                <td class="px-8 py-5 text-right">
                                    <span class="inline-block px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-{{ $color }}-100 text-{{ $color }}-600">
                                        {{ ucfirst($b->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="px-8 py-8 text-center text-slate-400 font-bold" colspan="4">No bookings found yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar Widgets -->
        <div class="space-y-8">
            <!-- Upcoming Trips Widget -->
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-lg font-black text-slate-900 tracking-tight">Upcoming Trips</h3>
                    <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest bg-emerald-50 px-2 py-1 rounded-lg">Next 7 Days</span>
                </div>
                <div class="space-y-6">
                    @forelse(($upcomingBookings ?? []) as $trip)
                    <div class="flex items-center gap-4 group cursor-pointer">
                        <div class="w-14 h-14 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col items-center justify-center transition-colors group-hover:bg-emerald-50 group-hover:border-emerald-100">
                            <span class="text-[10px] font-black text-slate-400 uppercase leading-none group-hover:text-emerald-400">{{ $trip->start_date ? date('M', strtotime($trip->start_date)) : 'N/A' }}</span>
                            <span class="text-xl font-black text-slate-900 leading-none mt-1 group-hover:text-emerald-600">{{ $trip->start_date ? date('d', strtotime($trip->start_date)) : '--' }}</span>
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-slate-900 leading-tight">{{ $trip->tour->name ?? 'Safari' }}</h4>
                            <p class="text-xs text-slate-500 font-medium mt-1 inline-flex items-center gap-1">
                                <i class="ph ph-user-circle"></i> Customer: {{ $trip->customer_name }}
                            </p>
                        </div>
                        <i class="ph ph-caret-right text-slate-300 ml-auto group-hover:text-emerald-500 transition-colors"></i>
                    </div>
                    @empty
                    <div class="text-sm font-bold text-slate-400">No upcoming trips yet.</div>
                    @endforelse
                </div>
                <button class="w-full mt-10 py-4 border border-slate-200 text-xs font-black text-slate-500 uppercase tracking-widest rounded-2xl hover:bg-slate-50 transition-all">
                    View Full Schedule
                </button>
            </div>

            <!-- Promotion / Action Box -->
            <div class="bg-emerald-950 rounded-[2.5rem] p-8 text-white relative overflow-hidden group shadow-2xl shadow-emerald-950/20 text-center">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-800/30 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                        <i class="ph-fill ph-rocket-launch text-3xl text-emerald-400"></i>
                    </div>
                    <h3 class="text-xl font-black mb-3">Maximize Sales</h3>
                    <p class="text-emerald-100/60 text-sm font-medium leading-relaxed mb-8">Launch a new marketing campaign to reach 5,000+ potential safari travelers.</p>
                    <button class="w-full py-4 bg-emerald-500 hover:bg-emerald-400 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl transition-all shadow-lg shadow-emerald-500/20">
                        Launch Campaign
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
