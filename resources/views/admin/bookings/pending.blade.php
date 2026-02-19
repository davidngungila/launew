@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Pending Approvals</h1>
            <p class="text-slate-500 font-medium">Review and verify new booking requests and payments</p>
        </div>
        <div class="flex items-center gap-2 px-4 py-2 bg-orange-50 text-orange-600 rounded-xl border border-orange-100">
            <i class="ph-fill ph-warning-circle"></i>
            <span class="text-xs font-black uppercase tracking-widest">12 Actions Needed</span>
        </div>
    </div>

    <!-- Stats for context -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach([
            ['label' => 'New Inquiries', 'val' => '8', 'icon' => 'chat-circle-dots', 'color' => 'blue'],
            ['label' => 'Payment Verification', 'val' => '14', 'icon' => 'currency-dollar', 'color' => 'orange'],
            ['label' => 'Itinerary Review', 'val' => '4', 'icon' => 'file-text', 'color' => 'purple'],
        ] as $stat)
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-{{ $stat['color'] }}-50 text-{{ $stat['color'] }}-600 flex items-center justify-center">
                    <i class="ph ph-{{ $stat['icon'] }} text-2xl"></i>
                </div>
                <div>
                     <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-0.5">{{ $stat['label'] }}</p>
                     <h4 class="text-xl font-black text-slate-900 leading-tight">{{ $stat['val'] }}</h4>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Review Queue -->
    <div class="space-y-4">
        @foreach([
            ['client' => 'Marcus Aurelius', 'trip' => 'Serengeti Migration Premium', 'id' => 'BK-9286', 'reason' => 'Deposit Verification Required', 'type' => 'Payment', 'color' => 'orange'],
            ['client' => 'Sarah Connor', 'trip' => '7 Days Kili Lemosho', 'id' => 'BK-9287', 'reason' => 'Custom Request Update', 'type' => 'Review', 'color' => 'blue'],
            ['client' => 'Tony Stark', 'trip' => 'Zanzibar Luxury Honeymoon', 'id' => 'BK-9288', 'reason' => 'Hotel Availability Check', 'type' => 'Inventory', 'color' => 'purple'],
        ] as $req)
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all flex flex-col md:flex-row items-center justify-between gap-6 group">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 rounded-[1.5rem] bg-slate-50 flex items-center justify-center font-black text-slate-300 text-xl group-hover:bg-emerald-50 group-hover:text-emerald-500 transition-all">
                    {{ substr($req['client'], 0, 1) }}
                </div>
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-black bg-{{ $req['color'] }}-100 text-{{ $req['color'] }}-600 px-2 py-0.5 rounded-lg uppercase tracking-widest">{{ $req['type'] }}</span>
                        <span class="text-[10px] font-bold text-slate-400">{{ $req['id'] }}</span>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 tracking-tight">{{ $req['client'] }}</h3>
                    <p class="text-sm font-bold text-slate-500">{{ $req['trip'] }}</p>
                </div>
            </div>

            <div class="flex items-center gap-12">
                <div class="text-right hidden lg:block">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Issue</p>
                    <p class="text-sm font-black text-slate-900">{{ $req['reason'] }}</p>
                </div>
                <div class="flex items-center gap-3">
                     <button class="px-6 py-3 bg-slate-900 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl hover:bg-emerald-600 transition-all shadow-xl shadow-slate-900/10">Approve Booking</button>
                     <button class="p-3 text-slate-400 hover:text-red-500 bg-slate-50 hover:bg-red-50 rounded-2xl transition-all">
                        <i class="ph ph-x-circle text-2xl"></i>
                     </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
