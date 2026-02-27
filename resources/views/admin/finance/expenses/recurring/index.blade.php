@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Recurring Expenses</h1>
            <p class="text-slate-500 font-medium">Track planned recurring costs (monthly, weekly, daily)</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.finance.expenses.categories.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Categories</a>
            <a href="{{ route('admin.finance.expenses.tracking') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Tracking</a>
            <a href="{{ route('admin.finance.expenses.recurring.create') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">New Recurring</a>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Name</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Category</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Frequency</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Active</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Amount</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recurring as $r)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="text-sm font-black text-slate-900">{{ $r->name }}</div>
                                <div class="text-[10px] font-bold text-slate-400">Next run: {{ $r->next_run_on?->format('d M Y') ?? '—' }}</div>
                            </td>
                            <td class="px-8 py-6 text-sm font-bold text-slate-700">{{ $r->category }}</td>
                            <td class="px-8 py-6 text-xs font-black uppercase tracking-widest text-slate-600">{{ $r->frequency }}</td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-[0.2em] border {{ $r->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-slate-50 text-slate-700 border-slate-100' }}">{{ $r->is_active ? 'active' : 'inactive' }}</span>
                            </td>
                            <td class="px-8 py-6 text-right text-sm font-black text-slate-900">${{ number_format((float) $r->amount, 2) }}</td>
                            <td class="px-8 py-6 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.finance.expenses.recurring.edit', $r) }}" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all"><i class="ph-bold ph-pencil-simple text-lg"></i></a>
                                    <form action="{{ route('admin.finance.expenses.recurring.destroy', $r) }}" method="POST" onsubmit="return confirm('Delete this recurring expense?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all"><i class="ph-bold ph-trash text-lg"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-10 text-center text-slate-400 font-bold">No recurring expenses found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-8 border-t border-slate-50">
            {{ $recurring->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>
@endsection
