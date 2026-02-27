@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Expense Tracking</h1>
            <p class="text-slate-500 font-medium">Record and monitor operational expenses (fuel, hotels, park fees)</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.finance.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Financial Overview</a>
            <a href="{{ route('admin.finance.expenses.categories.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Categories</a>
            <a href="{{ route('admin.finance.expenses.recurring.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Recurring</a>
            <a href="{{ route('admin.finance.expenses.create') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <i class="ph ph-plus"></i>
                Add Expense
            </a>
            <a href="{{ route('admin.finance.expenses.tracking.export-pdf') }}" target="_blank" class="px-5 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all shadow-sm flex items-center gap-2">
                <i class="ph ph-printer"></i>
                Export PDF
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-slate-900 p-8 rounded-[2.5rem] text-white shadow-2xl">
            <p class="text-[10px] font-black uppercase tracking-widest text-white/50">Total expenses</p>
            <p class="text-4xl font-black mt-2">${{ number_format((float) ($stats['totalExpenses'] ?? 0), 2) }}</p>
            <p class="text-[10px] font-bold text-white/50 uppercase tracking-widest mt-3">All categories</p>
        </div>
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Fuel</p>
            <p class="text-2xl font-black text-slate-900 mt-2">${{ number_format((float) ($stats['fuel'] ?? 0), 2) }}</p>
        </div>
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Accommodation payouts</p>
            <p class="text-2xl font-black text-slate-900 mt-2">${{ number_format((float) ($stats['accommodation'] ?? 0), 2) }}</p>
        </div>
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Park fees</p>
            <p class="text-2xl font-black text-slate-900 mt-2">${{ number_format((float) ($stats['parkFees'] ?? 0), 2) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex items-center justify-between">
            <div>
                <h3 class="text-xl font-black text-slate-900">Recent Expenses</h3>
                <p class="text-slate-500 font-medium text-sm mt-1">Latest operational expenses recorded</p>
            </div>
            <a href="{{ route('admin.finance.expenses.index') }}" class="px-5 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all">Manage all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Date</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Category</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Description</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Amount</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recent as $e)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-6 text-sm font-black text-slate-900">{{ date('d M, Y', strtotime($e->transaction_date)) }}</td>
                        <td class="px-8 py-6"><span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-slate-100 text-slate-600">{{ $e->category }}</span></td>
                        <td class="px-8 py-6 text-sm font-bold text-slate-700">{{ $e->description }}</td>
                        <td class="px-8 py-6 text-right text-sm font-black text-rose-600">-${{ number_format($e->amount, 2) }}</td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('admin.finance.expenses.edit', $e) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-100 transition-all">
                                <i class="ph ph-pencil-simple"></i>
                                Edit
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="px-8 py-10 text-center text-slate-400 font-bold" colspan="5">No expenses recorded yet. Click “Add Expense” to create one.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
