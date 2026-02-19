@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Customer CRM</h1>
            <p class="text-slate-500 font-medium">Manage your relationships and traveler profiles</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <i class="ph ph-user-plus"></i>
                Add Customer
            </button>
        </div>
    </div>

    <!-- Customer Directory List -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-50">
            <div class="relative max-w-md">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                    <i class="ph ph-magnifying-glass"></i>
                </span>
                <input type="text" class="block w-full pl-11 pr-4 py-3 border border-slate-200 rounded-2xl bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all shadow-inner" placeholder="Search customers by name or email...">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Customer</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Contact Info</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Country</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Total Trips</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">LTV (USD)</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach([
                        ['name' => 'John Smith', 'email' => 'john.smith@gmail.com', 'phone' => '+44 7700 900123', 'country' => 'United Kingdom', 'trips' => 3, 'ltv' => '$14,200', 'avatar' => 'JS'],
                        ['name' => 'Maria Garcia', 'email' => 'mgarcia@es-travel.es', 'phone' => '+34 600 123 456', 'country' => 'Spain', 'trips' => 1, 'ltv' => '$4,800', 'avatar' => 'MG'],
                        ['name' => 'Kenzo Tanaka', 'email' => 'kenzo.t@global.jp', 'phone' => '+81 90 1234 5678', 'country' => 'Japan', 'trips' => 2, 'ltv' => '$22,500', 'avatar' => 'KT'],
                        ['name' => 'Sarah Johnson', 'email' => 'sarah.j@outlook.com', 'phone' => '+1 212-555-0198', 'country' => 'USA', 'trips' => 5, 'ltv' => '$32,100', 'avatar' => 'SJ'],
                    ] as $customer)
                    <tr class="hover:bg-slate-50/50 transition-colors group cursor-pointer">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 font-black text-xs group-hover:bg-white group-hover:shadow-md transition-all">
                                    {{ $customer['avatar'] }}
                                </div>
                                <span class="text-sm font-bold text-slate-900">{{ $customer['name'] }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-700">{{ $customer['email'] }}</span>
                                <span class="text-[10px] text-slate-400 font-medium">{{ $customer['phone'] }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-3 bg-slate-200 rounded-sm"></div>
                                <span class="text-xs font-bold text-slate-600">{{ $customer['country'] }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="text-xs font-black text-emerald-600">{{ $customer['trips'] }}</span>
                        </td>
                        <td class="px-8 py-6 font-black text-slate-900 text-sm">{{ $customer['ltv'] }}</td>
                        <td class="px-8 py-6 text-right">
                            <button class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all">
                                <i class="ph-bold ph-eye text-lg"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
