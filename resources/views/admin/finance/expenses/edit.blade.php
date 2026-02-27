@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Edit Expense</h1>
            <p class="text-slate-500 font-medium">Update expense details</p>
        </div>
        <a href="{{ route('admin.finance.expenses.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Back</a>
    </div>

    <form action="{{ route('admin.finance.expenses.update', $expense) }}" method="POST" class="space-y-8 pb-20">
        @csrf
        @method('PUT')

        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Amount (USD)</label>
                    <input type="number" step="0.01" name="amount" value="{{ old('amount', $expense->amount) }}" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Date</label>
                    <input type="date" name="transaction_date" value="{{ old('transaction_date', $expense->transaction_date) }}" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Category</label>
                    <select name="category" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->key }}" {{ old('category', $expense->category) === $cat->key ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-1 md:col-span-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Description</label>
                    <input type="text" name="description" value="{{ old('description', $expense->description) }}" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('admin.finance.expenses.index') }}" class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">Cancel</a>
            <button type="submit" class="px-10 py-4 bg-emerald-600 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-emerald-500/20 hover:bg-emerald-700 transition-all">Save Changes</button>
        </div>
    </form>

    <form action="{{ route('admin.finance.expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('Delete this expense?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-8 py-4 text-xs font-black text-rose-600 uppercase tracking-widest hover:text-rose-700 transition-colors">Delete</button>
    </form>
</div>
@endsection
