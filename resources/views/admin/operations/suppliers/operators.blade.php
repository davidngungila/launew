@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Operator List</h1>
            <p class="text-slate-500 font-medium">Registered operators (agents) linked to bookings and commissions</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.operations.suppliers.contracts') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Contracts</a>
            <a href="{{ route('admin.operations.suppliers.payments') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">Payments</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Operators</div>
            <div class="mt-3 text-3xl font-black text-slate-900">{{ $stats['operators'] ?? 0 }}</div>
            <div class="mt-1 text-sm font-medium text-slate-500">Active agents in the system</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Bookings With Operator</div>
            <div class="mt-3 text-3xl font-black text-emerald-600">{{ $stats['bookings_with_operator'] ?? 0 }}</div>
            <div class="mt-1 text-sm font-medium text-slate-500">Commission-linked bookings</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Operator Directory</div>
            <div class="mt-2 text-sm font-bold text-slate-600">Review company details, commission rate, and booking volume</div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-white">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest min-w-[240px]">Company</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Account</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Commission</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Bookings</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($agents as $agent)
                        @php
                            $count = (int) ($bookingCounts[$agent->id] ?? 0);
                            $rate = $agent->commission_rate;
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-900">{{ $agent->company_name ?? 'Operator' }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 mt-0.5 tracking-widest uppercase">OP-{{ str_pad($agent->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-bold text-slate-700">{{ $agent->user->name ?? 'N/A' }}</div>
                                <div class="text-[10px] font-bold text-slate-400">{{ $agent->user->email ?? '' }}</div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                @if($rate === null)
                                    <span class="inline-flex px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-[0.2em] border bg-amber-50 text-amber-700 border-amber-100">missing</span>
                                @else
                                    <span class="text-sm font-black text-slate-900">{{ number_format((float) $rate, 2) }}%</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-sm font-black text-slate-900">{{ $count }}</span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <a href="{{ route('admin.operations.suppliers.contracts') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Open</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center">
                                <p class="text-slate-400 font-medium">No operators found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-8 border-t border-slate-50 flex items-center justify-between">
            <p class="text-xs font-bold text-slate-400">Showing <span class="text-slate-900">{{ $agents->firstItem() ?? 0 }}</span> to <span class="text-slate-900">{{ $agents->lastItem() ?? 0 }}</span> of <span class="text-slate-900">{{ $agents->total() }}</span> Operators</p>
            <div class="flex items-center gap-2">
                {{ $agents->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</div>
@endsection
