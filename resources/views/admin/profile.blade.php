@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Admin Profile</h1>
            <p class="text-slate-500 font-medium">Personal account overview and activity</p>
        </div>
        <a href="{{ route('admin.account-settings') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
            <i class="ph ph-pencil"></i>
            Edit Profile
        </a>
    </div>

    <!-- Profile Overview Card -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="h-48 bg-emerald-900 relative">
            <div class="absolute inset-0 opacity-20 bg-[url('https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=1000&q=80')] bg-cover bg-center"></div>
        </div>
        <div class="px-12 pb-12 relative">
            <div class="flex flex-col md:flex-row items-end gap-6 -mt-16 mb-8">
                <div class="w-32 h-32 rounded-[2rem] bg-white p-2 shadow-2xl">
                    @php
                        $u = auth()->user();
                        $avatarUrl = $u && $u->profile_image
                            ? asset('storage/' . ltrim($u->profile_image, '/'))
                            : null;
                    @endphp
                    @if($avatarUrl)
                        <img src="{{ $avatarUrl }}" alt="Avatar" class="w-full h-full rounded-[1.5rem] object-cover shadow-inner" />
                    @else
                        <div class="w-full h-full rounded-[1.5rem] bg-emerald-500 flex items-center justify-center text-4xl font-black text-white shadow-inner">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="flex-grow pb-2">
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">{{ auth()->user()->name }}</h2>
                    <p class="text-emerald-600 font-bold uppercase tracking-[0.2em] text-xs">System Administrator</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 pt-8 border-t border-slate-50">
                <div class="space-y-6">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Personal Details</h4>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 text-slate-600">
                            <i class="ph ph-envelope text-xl text-slate-400"></i>
                            <span class="text-sm font-bold">{{ auth()->user()->email }}</span>
                        </div>
                        <div class="flex items-center gap-4 text-slate-600">
                            <i class="ph ph-phone text-xl text-slate-400"></i>
                            <span class="text-sm font-bold">+255 683 163 219</span>
                        </div>
                        <div class="flex items-center gap-4 text-slate-600">
                            <i class="ph ph-map-pin text-xl text-slate-400"></i>
                            <span class="text-sm font-bold">Moshi, Tanzania</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">System Usage</h4>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-500">Security Level</span>
                            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-600 text-[9px] font-black rounded-lg uppercase tracking-widest">Level 10</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-500">Last Login</span>
                            <span class="text-xs font-black text-slate-900">2 mins ago</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-500">Account Age</span>
                            <span class="text-xs font-black text-slate-900">42 Days</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 text-center md:text-left">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Badge & Certifications</h4>
                    <div class="flex flex-wrap gap-2">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:text-emerald-500 hover:bg-emerald-50 transition-all cursor-help" title="Authentic Guide">
                            <i class="ph-fill ph-certificate text-xl"></i>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400">
                            <i class="ph-fill ph-shield-check text-xl"></i>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400">
                            <i class="ph-fill ph-lightning text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-12">
        <h3 class="text-xl font-black text-slate-900 mb-8">Recent Activity Log</h3>
        <div class="space-y-8">
            @foreach([
                ['action' => 'Updated Tour Package', 'desc' => 'Modified Serengeti Classic Migration 5 Days', 'time' => '10:45 AM', 'icon' => 'compass'],
                ['action' => 'Approved Booking', 'desc' => 'Confirmed Alice Thompson (#BK-9281)', 'time' => 'Yesterday', 'icon' => 'check-circle'],
                ['action' => 'System Export', 'desc' => 'Generated February Financial Report', 'time' => '2 days ago', 'icon' => 'file-pdf'],
            ] as $act)
            <div class="flex items-start gap-6 group">
                <div class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-emerald-50 group-hover:text-emerald-500 transition-all">
                    <i class="ph ph-{{ $act['icon'] }} text-2xl"></i>
                </div>
                <div class="flex-grow">
                    <div class="flex items-center justify-between mb-1">
                        <h4 class="text-sm font-black text-slate-900">{{ $act['action'] }}</h4>
                        <span class="text-[10px] font-bold text-slate-400 uppercase">{{ $act['time'] }}</span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium">{{ $act['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
