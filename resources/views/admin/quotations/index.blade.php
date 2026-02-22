@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Quotations & Proposals</h1>
            <p class="text-slate-500 font-medium">Draft and manage custom Safari itineraries for your clients</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.quotations.export-pdf') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                <i class="ph ph-file-pdf"></i>
                Export PDF
            </a>
            <a href="{{ route('admin.quotations.create') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <i class="ph ph-plus"></i>
                Create Quotation
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @foreach([
            ['label' => 'Total Drafted', 'val' => '45', 'sub' => 'This month', 'color' => 'slate'],
            ['label' => 'Pending Approval', 'val' => '12', 'sub' => 'Sent to client', 'color' => 'orange'],
            ['label' => 'Converted', 'val' => '28', 'sub' => 'To bookings', 'color' => 'emerald'],
            ['label' => 'Conversion Rate', 'val' => '62%', 'sub' => '+5% from Jan', 'color' => 'blue'],
        ] as $stat)
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">{{ $stat['label'] }}</p>
            <h4 class="text-2xl font-black text-slate-900 leading-tight">{{ $stat['val'] }}</h4>
            <p class="text-[10px] font-bold text-{{ $stat['color'] }}-500 mt-1 uppercase tracking-tight">{{ $stat['sub'] }}</p>
        </div>
        @endforeach
    </div>

    <!-- Quotations Table -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Quote ID</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Client Name</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Itinerary Brief</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Est. Value</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach([
                        ['id' => 'QT-2026-001', 'client' => 'Marcus Aurelius', 'brief' => '8 Days Northern Circuit Premium', 'val' => '$12,400', 'status' => 'Sent', 'color' => 'orange'],
                        ['id' => 'QT-2026-002', 'client' => 'Lucius Vorenus', 'brief' => '3 Days Serengeti Balloon Safari', 'val' => '$4,200', 'status' => 'Converted', 'color' => 'emerald'],
                        ['id' => 'QT-2026-003', 'client' => 'Julius Caesar', 'brief' => '14 Days Luxury Tanzania & Zanzibar', 'val' => '$32,500', 'status' => 'Draft', 'color' => 'slate'],
                        ['id' => 'QT-2026-004', 'client' => 'Cleopatra VII', 'brief' => '5 Days Kili Marangu Route', 'val' => '$2,800', 'status' => 'Expired', 'color' => 'red'],
                    ] as $quote)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-6 text-xs font-black text-slate-400">{{ $quote['id'] }}</td>
                        <td class="px-8 py-6 font-bold text-slate-900 text-sm">{{ $quote['client'] }}</td>
                        <td class="px-8 py-6">
                            <p class="text-sm font-bold text-slate-800 leading-tight">{{ $quote['brief'] }}</p>
                        </td>
                        <td class="px-8 py-6 font-black text-slate-900 text-sm">{{ $quote['val'] }}</td>
                        <td class="px-8 py-6">
                            <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-{{ $quote['color'] }}-100 text-{{ $quote['color'] }}-600">
                                {{ $quote['status'] }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all">
                                    <i class="ph-bold ph-paper-plane-tilt text-lg"></i>
                                </button>
                                <button class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                                    <i class="ph-bold ph-pencil-simple text-lg"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
