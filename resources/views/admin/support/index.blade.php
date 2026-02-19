@extends('layouts.admin')

@section('content')
<div class="h-[calc(100vh-10rem)] flex flex-col">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Support & Inbox</h1>
            <p class="text-slate-500 font-medium">Communicate with leads and existing travelers</p>
        </div>
        <div class="flex items-center gap-3">
             <div class="flex bg-slate-100 rounded-xl p-1">
                <button class="px-4 py-2 bg-white text-slate-900 font-bold text-xs rounded-lg shadow-sm">All</button>
                <button class="px-4 py-2 text-slate-500 font-bold text-xs rounded-lg">Unread</button>
                <button class="px-4 py-2 text-slate-500 font-bold text-xs rounded-lg">Archived</button>
            </div>
        </div>
    </div>

    <!-- Inbox Layout -->
    <div class="flex-grow flex bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <!-- Message List Side -->
        <div class="w-full md:w-80 border-r border-slate-50 flex flex-col">
            <div class="p-6">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <i class="ph ph-magnifying-glass"></i>
                    </span>
                    <input type="text" class="block w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-100 rounded-xl text-xs focus:outline-none" placeholder="Search threads...">
                </div>
            </div>
            <div class="flex-grow overflow-y-auto">
                @foreach([
                    ['name' => 'Alice Thompson', 'topic' => 'Question about Serengeti Migration', 'time' => '12m ago', 'unread' => true],
                    ['name' => 'Robert Wilson', 'topic' => 'Booking #BK-9282 - Kili Equipment', 'time' => '2h ago', 'unread' => false],
                    ['name' => 'Elena Rodriguez', 'topic' => 'Thank you for the amazing trip!', 'time' => '1d ago', 'unread' => false],
                    ['name' => 'Inquiry #991', 'topic' => 'Custom 14 days itinerary request', 'time' => '2d ago', 'unread' => true],
                ] as $msg)
                <div class="p-6 hover:bg-slate-50 cursor-pointer border-b border-slate-50 transition-colors {{ $msg['unread'] ? 'bg-emerald-50/30' : '' }}">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-black text-slate-900">{{ $msg['name'] }}</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase">{{ $msg['time'] }}</span>
                    </div>
                    <p class="text-[11px] font-bold text-slate-600 truncate mb-1">{{ $msg['topic'] }}</p>
                    @if($msg['unread'])
                        <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block shadow-lg shadow-emerald-500/40"></span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Conversation Window -->
        <div class="hidden md:flex flex-grow flex-col">
            <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center font-black text-slate-400">AT</div>
                    <div>
                        <h4 class="text-sm font-black text-slate-900">Alice Thompson</h4>
                        <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-widest">Regarding: Serengeti Classic Safari</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button class="p-2 text-slate-400 hover:text-red-500 rounded-xl transition-all"><i class="ph ph-trash text-xl"></i></button>
                    <button class="p-2 text-slate-400 hover:text-slate-900 rounded-xl transition-all"><i class="ph ph-archive-box text-xl"></i></button>
                </div>
            </div>
            
            <div class="flex-grow p-10 overflow-y-auto space-y-8 bg-slate-50/30">
                <div class="max-w-2xl mx-auto flex flex-col gap-6">
                    <div class="bg-white p-6 rounded-3xl rounded-tl-none border border-slate-100 shadow-sm max-w-lg self-start">
                        <p class="text-sm text-slate-700 leading-relaxed font-medium">Hello LAU team, I'm planning my honeymoon for October 2026. Is the Great Migration still active in Central Serengeti during that time, or should we look further North?</p>
                        <p class="text-[9px] text-slate-400 font-bold mt-4 uppercase">Received 10:24 AM</p>
                    </div>
                    
                    <div class="bg-emerald-600 p-6 rounded-3xl rounded-tr-none text-white shadow-xl shadow-emerald-600/20 max-w-lg self-end">
                        <p class="text-sm leading-relaxed font-bold">Congratulations on your upcoming honeymoon! In October, the migration is typically moving from the Northern Serengeti back towards the Central region. It's a fantastic time for predator sightings...</p>
                        <p class="text-[9px] text-emerald-100/60 font-bold mt-4 uppercase">Sent 11:05 AM</p>
                    </div>
                </div>
            </div>
            
            <div class="p-8 border-t border-slate-50 bg-white">
                <div class="relative">
                    <textarea rows="1" class="block w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all resize-none shadow-inner" placeholder="Type your reply here..."></textarea>
                    <button class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-emerald-600 text-white rounded-xl flex items-center justify-center hover:bg-emerald-700 transition-all">
                        <i class="ph-fill ph-paper-plane-right text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
