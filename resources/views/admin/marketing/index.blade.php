@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Marketing Center</h1>
            <p class="text-slate-500 font-medium">Drive more traffic and convert safari dreamers</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <i class="ph ph-plus"></i>
                New Campaign
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Promo Codes -->
        <div class="lg:col-span-2 space-y-4">
             <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-50">
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">Active Promo Codes</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Code</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Discount</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Usage</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Expiry</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach([
                                ['code' => 'SAFARI2026', 'disc' => '10%', 'usage' => '124 / 500', 'exp' => 'Dec 31, 2026', 'status' => 'Active', 'color' => 'emerald'],
                                ['code' => 'EARLYBIRD', 'disc' => '$200', 'usage' => '45 / Unlimited', 'exp' => 'Jun 30, 2026', 'status' => 'Active', 'color' => 'emerald'],
                                ['code' => 'ZANZIBAR15', 'disc' => '15%', 'usage' => '89 / 100', 'exp' => 'Jan 15, 2026', 'status' => 'Expired', 'color' => 'red'],
                            ] as $promo)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-6">
                                    <span class="px-3 py-1 bg-slate-100 rounded-lg text-xs font-black text-slate-700 font-mono">{{ $promo['code'] }}</span>
                                </td>
                                <td class="px-8 py-6 font-bold text-slate-900">{{ $promo['disc'] }}</td>
                                <td class="px-8 py-6 text-xs text-slate-500 font-bold uppercase tracking-widest">{{ $promo['usage'] }}</td>
                                <td class="px-8 py-6 text-xs text-slate-400 font-medium">{{ $promo['exp'] }}</td>
                                <td class="px-8 py-6 text-right">
                                    <span class="px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-{{ $promo['color'] }}-100 text-{{ $promo['color'] }}-600">{{ $promo['status'] }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Marketing Actions -->
        <div class="space-y-8">
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                 <h3 class="text-lg font-black text-slate-900 tracking-tight mb-6">Email Newsletter</h3>
                 <p class="text-xs text-slate-500 font-medium leading-relaxed mb-6">You have <span class="bg-emerald-50 text-emerald-600 px-1 rounded font-bold">1,842</span> subscribers in your list.</p>
                 <button class="w-full py-4 border-2 border-dashed border-slate-200 text-slate-400 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:border-emerald-500 hover:text-emerald-500 transition-all">
                    Create Campaign
                 </button>
            </div>
            
            <div class="bg-indigo-600 p-8 rounded-[2.5rem] text-white shadow-xl shadow-indigo-600/20">
                <i class="ph-fill ph-google-logo text-3xl mb-4"></i>
                <h3 class="text-xl font-black mb-3">Google Ads Audit</h3>
                <p class="text-indigo-100/70 text-sm font-medium leading-relaxed mb-8">Manage your search engine presence and track conversion pixels.</p>
                <button class="w-full py-4 bg-white text-indigo-600 font-black text-xs uppercase tracking-[0.2em] rounded-2xl">
                    Open Dashboard
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
