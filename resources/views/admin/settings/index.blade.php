@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">System Settings</h1>
            <p class="text-slate-500 font-medium">Configure core business rules and user access</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <i class="ph ph-check"></i>
                Apply Changes
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Settings -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                <h3 class="text-xl font-black text-slate-900 mb-8 flex items-center gap-3">
                    <i class="ph ph-laptop text-emerald-500"></i> General Configuration
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Business Name</label>
                        <input type="text" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500" value="LAU Paradise Adventure">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Default Currency</label>
                        <select class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none">
                            <option>USD - US Dollar</option>
                            <option>TZS - Tanzanian Shilling</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Primary Email</label>
                        <input type="email" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" value="lauparadiseadventure@gmail.com">
                    </div>
                    <div class="space-y-1">
                         <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Timezone</label>
                         <input type="text" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" value="(GMT+3) East African Time">
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                <h3 class="text-xl font-black text-slate-900 mb-8 flex items-center gap-3">
                    <i class="ph ph-shield-check text-emerald-500"></i> User Management
                </h3>
                <div class="space-y-4">
                    @foreach([
                        ['name' => 'Lau Administrator', 'role' => 'System Administrator', 'email' => 'admin@lauparadise.com', 'status' => 'Active'],
                        ['name' => 'Peter Mabula', 'role' => 'Travel Consultant', 'email' => 'mabula@lauparadise.com', 'status' => 'Active'],
                    ] as $user)
                    <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 flex items-center justify-between">
                         <div class="flex items-center gap-4">
                             <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center font-black text-xs text-slate-400">
                                {{ substr($user['name'], 0, 1) }}
                             </div>
                             <div>
                                 <h4 class="text-sm font-black text-slate-900 leading-tight">{{ $user['name'] }}</h4>
                                 <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $user['role'] }}</p>
                             </div>
                         </div>
                         <button class="px-4 py-2 border border-slate-200 text-[10px] font-black text-slate-400 uppercase tracking-widest rounded-xl hover:bg-white transition-all">Edit Rights</button>
                    </div>
                    @endforeach
                    <button class="w-full py-4 border-2 border-dashed border-slate-200 rounded-3xl text-slate-300 text-[10px] font-black uppercase tracking-widest hover:border-emerald-500 hover:text-emerald-500 transition-all">
                        Invite New User
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Options -->
        <div class="space-y-8">
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                <h3 class="text-lg font-black text-slate-900 tracking-tight mb-8">System Health</h3>
                <div class="space-y-8">
                    @foreach([
                        ['label' => 'SSL Certificate', 'status' => 'Valid', 'color' => 'emerald'],
                        ['label' => 'Database Sync', 'status' => 'Optimal', 'color' => 'emerald'],
                        ['label' => 'Email Server', 'status' => 'Connected', 'color' => 'emerald'],
                        ['label' => 'Storage Usage', 'status' => '35% Full', 'color' => 'blue'],
                    ] as $health)
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest">{{ $health['label'] }}</span>
                        <div class="flex items-center gap-2">
                             <div class="w-2 h-2 rounded-full bg-{{ $health['color'] }}-500"></div>
                             <span class="text-xs font-black text-slate-900">{{ $health['status'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <div class="bg-red-950 p-8 rounded-[2.5rem] text-white shadow-xl shadow-red-950/20">
                <i class="ph ph-warning-octagon text-3xl mb-4 text-red-400"></i>
                <h3 class="text-xl font-black mb-3">Zone of Danger</h3>
                <p class="text-red-100/60 text-sm font-medium leading-relaxed mb-8">Perform critical actions like database resets or complete system exports.</p>
                <div class="space-y-3">
                    <button class="w-full py-4 bg-red-600 hover:bg-red-500 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl transition-all">Clear All Caches</button>
                    <button class="w-full py-4 border border-white/20 text-white/60 font-black text-xs uppercase tracking-[0.2em] rounded-2xl">Download Full Backup</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
