@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Operator Payments</h1>
            <p class="text-slate-500 font-medium">Commission forecast based on operator-linked bookings</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.finance.ap.supplier-bills') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Supplier Bills</a>
            <a href="{{ route('admin.finance.ap.pending-payments') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Pending Payments</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">Start Date</label>
                <input type="date" name="start" value="{{ $start ?? '' }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 font-bold text-slate-700" />
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">End Date</label>
                <input type="date" name="end" value="{{ $end ?? '' }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 font-bold text-slate-700" />
            </div>
            <div class="md:col-span-3 flex items-center gap-3">
                <button type="submit" class="px-5 py-2.5 bg-slate-900 text-white font-black rounded-xl hover:bg-slate-800 transition-all">Apply Filter</button>
                <a href="{{ route('admin.finance.ap.operator-payments') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Reset</a>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Operators</div>
            <div class="mt-3 text-3xl font-black text-slate-900">{{ $stats['operators'] ?? 0 }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Gross Booking Value</div>
            <div class="mt-3 text-3xl font-black text-slate-900">${{ number_format((float) ($stats['gross'] ?? 0), 2) }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Commission Forecast</div>
            <div class="mt-3 text-3xl font-black text-emerald-600">${{ number_format((float) ($stats['commission'] ?? 0), 2) }}</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Commission Summary</div>
            <div class="mt-2 text-sm font-bold text-slate-600">Grouped by operator (Agent model commission rate)</div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-white">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest min-w-[260px]">Operator</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Bookings</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Rate</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Gross</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Commission</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($rows as $r)
                        @php $agent = $r['agent']; @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5">
                                <div class="text-sm font-black text-slate-900">{{ $agent->company_name ?? 'Operator' }}</div>
                                <div class="text-[10px] font-bold text-slate-400">{{ $agent->user->email ?? '' }}</div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div class="text-sm font-black text-slate-900">{{ $r['count'] }}</div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div class="text-sm font-black text-slate-900">{{ number_format((float) $r['rate'], 2) }}%</div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="text-sm font-black text-slate-900">${{ number_format((float) $r['gross'], 2) }}</div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="text-sm font-black text-emerald-700">${{ number_format((float) $r['commission'], 2) }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center">
                                <p class="text-slate-400 font-medium">No operator-linked bookings found for the selected range</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
