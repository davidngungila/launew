@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Aging Report</h1>
            <p class="text-slate-500 font-medium">Outstanding balances grouped into aging buckets</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.finance.ar.customer-balances') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Customer Balances</a>
            <a href="{{ route('admin.finance.ar.aging-report.export-pdf', ['basis' => $basis ?? 'created_at']) }}" target="_blank" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">Export PDF</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <form method="GET" class="flex flex-col md:flex-row md:items-end gap-4">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">Aging Basis</label>
                <select name="basis" class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 font-bold text-slate-700">
                    <option value="created_at" {{ ($basis ?? 'created_at') === 'created_at' ? 'selected' : '' }}>Booking Created Date</option>
                    <option value="start_date" {{ ($basis ?? 'created_at') === 'start_date' ? 'selected' : '' }}>Start Date</option>
                </select>
            </div>
            <button type="submit" class="px-5 py-2.5 bg-slate-900 text-white font-black rounded-xl hover:bg-slate-800 transition-all">Apply</button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">0-7 Days</div>
            <div class="mt-3 text-2xl font-black text-slate-900">${{ number_format((float) ($buckets['0_7'] ?? 0), 2) }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">8-14 Days</div>
            <div class="mt-3 text-2xl font-black text-slate-900">${{ number_format((float) ($buckets['8_14'] ?? 0), 2) }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">15-30 Days</div>
            <div class="mt-3 text-2xl font-black text-slate-900">${{ number_format((float) ($buckets['15_30'] ?? 0), 2) }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">31+ Days</div>
            <div class="mt-3 text-2xl font-black text-slate-900">${{ number_format((float) ($buckets['31_plus'] ?? 0), 2) }}</div>
        </div>
        <div class="bg-slate-900 rounded-2xl p-6 text-white shadow-xl">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-white/50">Total Outstanding</div>
            <div class="mt-3 text-2xl font-black">${{ number_format((float) ($stats['outstanding_total'] ?? 0), 2) }}</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Outstanding Bookings</div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Booking</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Customer</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tour</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Payment</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Total</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($rows as $b)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5 text-sm font-black text-slate-900">BK-{{ str_pad($b->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-5 text-sm font-bold text-slate-700">{{ $b->customer_name }}</td>
                            <td class="px-6 py-5 text-sm font-bold text-slate-700">{{ $b->tour->name ?? 'Safari' }}</td>
                            <td class="px-6 py-5 text-xs font-black uppercase tracking-widest text-slate-600">{{ $b->payment_status }}</td>
                            <td class="px-6 py-5 text-right text-sm font-black text-slate-900">${{ number_format((float) $b->total_price, 2) }}</td>
                            <td class="px-6 py-5 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.bookings.show', $b->id) }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all">Open</a>
                                    <form action="{{ route('admin.bookings.verify-payment', $b->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all">Verify</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-400 font-bold">No outstanding bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-8 border-t border-slate-50 flex items-center justify-between">
            <p class="text-xs font-bold text-slate-400">Showing <span class="text-slate-900">{{ $rows->firstItem() ?? 0 }}</span> to <span class="text-slate-900">{{ $rows->lastItem() ?? 0 }}</span> of <span class="text-slate-900">{{ $rows->total() }}</span></p>
            {{ $rows->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>
@endsection
