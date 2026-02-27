@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 pb-20">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.finance.expenses.categories.index') }}" class="w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-all">
            <i class="ph ph-caret-left-bold"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">New Expense Category</h1>
            <p class="text-slate-500 font-medium">Define an expense classification key</p>
        </div>
    </div>

    <form action="{{ route('admin.finance.expenses.categories.store') }}" method="POST" class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-10 space-y-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-1.5">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Key</label>
                <input type="text" name="key" value="{{ old('key') }}" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" placeholder="e.g. fuel" />
            </div>
            <div class="space-y-1.5">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" placeholder="Fuel" />
            </div>
            <div class="space-y-1.5">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" />
            </div>
            <div class="flex items-center gap-3 pt-8">
                <input id="is_active" type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} />
                <label for="is_active" class="text-sm font-bold text-slate-700">Active</label>
            </div>
        </div>

        <div class="pt-4 flex items-center justify-end gap-4">
            <a href="{{ route('admin.finance.expenses.categories.index') }}" class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">Cancel</a>
            <button type="submit" class="px-10 py-4 bg-emerald-600 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-emerald-500/20 hover:bg-emerald-700 transition-all">Save</button>
        </div>
    </form>
</div>
@endsection
