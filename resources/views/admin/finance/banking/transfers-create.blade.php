@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 pb-20">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.finance.banking.transfers') }}" class="w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-all">
            <i class="ph ph-caret-left-bold"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">New Transfer</h1>
            <p class="text-slate-500 font-medium">Move funds between accounts</p>
        </div>
    </div>

    <form action="{{ route('admin.finance.banking.transfers.store') }}" method="POST" class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-10 space-y-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-1.5">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">From Account</label>
                <select name="from_account_id" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900">
                    @foreach($accounts as $a)
                        <option value="{{ $a->id }}">{{ strtoupper($a->type) }} · {{ $a->name }} ({{ $a->currency }})</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">To Account</label>
                <select name="to_account_id" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900">
                    @foreach($accounts as $a)
                        <option value="{{ $a->id }}">{{ strtoupper($a->type) }} · {{ $a->name }} ({{ $a->currency }})</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Amount</label>
                <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" />
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Transfer Date</label>
                <input type="date" name="transfer_date" value="{{ old('transfer_date', date('Y-m-d')) }}" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" />
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Reference</label>
                <input type="text" name="reference" value="{{ old('reference') }}" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" />
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-1">Notes</label>
                <input type="text" name="notes" value="{{ old('notes') }}" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" />
            </div>
        </div>

        <div class="pt-4 flex items-center justify-end gap-4">
            <a href="{{ route('admin.finance.banking.transfers') }}" class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">Cancel</a>
            <button type="submit" class="px-10 py-4 bg-emerald-600 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-emerald-500/20 hover:bg-emerald-700 transition-all">Save Transfer</button>
        </div>
    </form>
</div>
@endsection
