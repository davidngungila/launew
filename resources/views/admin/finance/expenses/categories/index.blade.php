@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Expense Categories</h1>
            <p class="text-slate-500 font-medium">Manage category keys used for expense classification</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.finance.expenses.tracking') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Tracking</a>
            <a href="{{ route('admin.finance.expenses.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Expenses</a>
            <a href="{{ route('admin.finance.expenses.categories.create') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">New Category</a>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Key</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Name</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Active</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Sort</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($categories as $c)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6 text-sm font-black text-slate-900">{{ $c->key }}</td>
                            <td class="px-8 py-6 text-sm font-bold text-slate-700">{{ $c->name }}</td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-[0.2em] border {{ $c->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-slate-50 text-slate-700 border-slate-100' }}">{{ $c->is_active ? 'active' : 'inactive' }}</span>
                            </td>
                            <td class="px-8 py-6 text-sm font-black text-slate-900">{{ $c->sort_order }}</td>
                            <td class="px-8 py-6 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.finance.expenses.categories.edit', $c) }}" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all"><i class="ph-bold ph-pencil-simple text-lg"></i></a>
                                    <form action="{{ route('admin.finance.expenses.categories.destroy', $c) }}" method="POST" onsubmit="return confirm('Delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all"><i class="ph-bold ph-trash text-lg"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-10 text-center text-slate-400 font-bold">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-8 border-t border-slate-50">
            {{ $categories->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>
@endsection
