@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Multi-Currency</h1>
            <p class="text-slate-500 font-medium">Totals per currency (requires transactions table)</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.finance.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Dashboard</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        @if($rows->isEmpty())
            <div class="text-sm font-bold text-slate-500">
                Multi-currency reporting is not yet available because the `transactions` table is not detected.
            </div>
            <div class="mt-2 text-xs font-bold text-slate-400">
                Next phase will add proper gateway transaction recording + currency conversion support.
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($rows as $r)
                    <div class="bg-slate-900 rounded-2xl p-6 text-white shadow-xl">
                        <div class="text-[10px] font-black uppercase tracking-[0.2em] text-white/50">{{ $r->currency }}</div>
                        <div class="mt-3 text-3xl font-black">{{ number_format((float) $r->total, 2) }}</div>
                        <div class="mt-2 text-xs font-bold text-white/60">{{ (int) $r->cnt }} transactions</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
