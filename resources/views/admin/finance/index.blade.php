@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Financial Overview</h1>
            <p class="text-slate-500 font-medium">Monitor revenue, expenses, and transaction health</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.finance.payments-received') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                <i class="ph ph-credit-card"></i>
                Payments
            </a>
            <a href="{{ route('admin.finance.generated-invoices') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                <i class="ph ph-receipt"></i>
                Invoices
            </a>
            <button class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                <i class="ph ph-sliders"></i>
                Advanced Filters
            </button>
            <button class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <i class="ph ph-printer"></i>
                Export Report
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <a href="{{ route('admin.finance.payments-received') }}" class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">Payments Received</p>
            <div class="flex items-center justify-between">
                <p class="text-sm font-black text-slate-900">View successful payments</p>
                <i class="ph ph-arrow-right text-slate-300 group-hover:text-emerald-600 transition-colors"></i>
            </div>
        </a>
        <a href="{{ route('admin.finance.generated-invoices') }}" class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">Generated Invoices</p>
            <div class="flex items-center justify-between">
                <p class="text-sm font-black text-slate-900">Download voucher PDFs</p>
                <i class="ph ph-arrow-right text-slate-300 group-hover:text-emerald-600 transition-colors"></i>
            </div>
        </a>
        <a href="{{ route('admin.finance.expense-tracking') }}" class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">Expense Tracking</p>
            <div class="flex items-center justify-between">
                <p class="text-sm font-black text-slate-900">Fuel, hotels & fees</p>
                <i class="ph ph-arrow-right text-slate-300 group-hover:text-emerald-600 transition-colors"></i>
            </div>
        </a>
        <a href="{{ route('admin.finance.revenue-reports') }}" class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">Revenue Reports</p>
            <div class="flex items-center justify-between">
                <p class="text-sm font-black text-slate-900">Paid vs pending totals</p>
                <i class="ph ph-arrow-right text-slate-300 group-hover:text-emerald-600 transition-colors"></i>
            </div>
        </a>
    </div>

    <!-- Finance Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-emerald-600 p-8 rounded-[2.5rem] text-white shadow-xl shadow-emerald-600/20 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-100/70 mb-2">Net Cash Flow</p>
                <h3 class="text-4xl font-black mb-4">$84,250.00</h3>
                <div class="flex items-center gap-2 text-xs font-bold text-emerald-100">
                    <span class="px-2 py-0.5 bg-white/20 rounded-md">+15.4%</span>
                    <span>vs last month</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">Unpaid Invoices</p>
            <h3 class="text-4xl font-black text-slate-900 mb-4">$12,840</h3>
            <div class="flex items-center gap-2 text-xs font-bold text-slate-500">
                <span class="px-2 py-0.5 bg-orange-100 text-orange-600 rounded-md">14 Pending</span>
                <span>requires action</span>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">Total Expenses</p>
            <h3 class="text-4xl font-black text-slate-900 mb-4">$28,500</h3>
            <div class="flex items-center gap-2 text-xs font-bold text-slate-500">
                <span class="px-2 py-0.5 bg-blue-100 text-blue-600 rounded-md">8.2% Growth</span>
                <span>expected climb</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Transaction History -->
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">Recent Transactions</h3>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 bg-slate-50 text-[10px] font-black uppercase tracking-widest text-slate-600 rounded-xl hover:bg-slate-100 transition-all">All</button>
                        <button class="px-4 py-2 bg-emerald-50 text-[10px] font-black uppercase tracking-widest text-emerald-600 rounded-xl">Income</button>
                        <button class="px-4 py-2 bg-slate-50 text-[10px] font-black uppercase tracking-widest text-slate-600 rounded-xl">Expenses</button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Reference</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Entity / Description</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Category</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach([
                                ['ref' => '#TRX-101', 'entity' => 'John Smith', 'desc' => 'Serengeti Safari Deposit', 'cat' => 'Income', 'amt' => '+$2,400.00', 'color' => 'emerald'],
                                ['ref' => '#TRX-102', 'entity' => 'Tanzania National Parks', 'desc' => 'Entry Fees - Group A', 'cat' => 'Expense', 'amt' => '-$1,200.00', 'color' => 'red'],
                                ['ref' => '#TRX-103', 'entity' => 'Zanzibar Serene Hotel', 'desc' => 'Accommodation Payout', 'cat' => 'Expense', 'amt' => '-$850.00', 'color' => 'red'],
                                ['ref' => '#TRX-104', 'entity' => 'Sarah Jones', 'desc' => 'Kili Trek Full Payment', 'cat' => 'Income', 'amt' => '+$2,250.00', 'color' => 'emerald'],
                                ['ref' => '#TRX-105', 'entity' => 'Puma Energy', 'desc' => 'Fuel Refill - Toyota T992', 'cat' => 'Expense', 'amt' => '-$180.00', 'color' => 'red'],
                            ] as $trx)
                            <tr class="hover:bg-slate-50/50 transition-colors cursor-pointer group">
                                <td class="px-8 py-6 text-xs font-black text-slate-400">{{ $trx['ref'] }}</td>
                                <td class="px-8 py-6">
                                    <p class="text-sm font-bold text-slate-900">{{ $trx['entity'] }}</p>
                                    <p class="text-[10px] text-slate-500 font-medium">{{ $trx['desc'] }}</p>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-{{ $trx['color'] }}-100 text-{{ $trx['color'] }}-600">
                                        {{ $trx['cat'] }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right font-black text-sm text-{{ $trx['color'] }}-600">{{ $trx['amt'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Revenue by category chart placeholder -->
        <div class="space-y-8">
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
                <h3 class="text-lg font-black text-slate-900 tracking-tight mb-8">Revenue Breakdown</h3>
                <div class="space-y-6">
                    @foreach([
                        ['label' => 'Serengeti Safaris', 'val' => 45, 'color' => 'emerald'],
                        ['label' => 'Kili Treks', 'val' => 30, 'color' => 'blue'],
                        ['label' => 'Zanzibar Beach', 'val' => 15, 'color' => 'purple'],
                        ['label' => 'Others', 'val' => 10, 'color' => 'slate']
                    ] as $item)
                    <div>
                        <div class="flex justify-between text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">
                            <span>{{ $item['label'] }}</span>
                            <span>{{ $item['val'] }}%</span>
                        </div>
                        <div class="w-full h-1.5 bg-slate-50 rounded-full overflow-hidden">
                            <div class="h-full bg-{{ $item['color'] }}-500" style="width: {{ $item['val'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-10 p-6 bg-slate-50 rounded-2xl border border-slate-100">
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">Most of your revenue this month is coming from <span class="text-emerald-600 font-bold">Serengeti Safaris</span>, showing a 12% increase from January.</p>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="bg-blue-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-blue-600/20">
                <h3 class="text-xl font-black mb-6">Need a Loan?</h3>
                <p class="text-blue-100/70 text-sm font-medium leading-relaxed mb-8">Get instant business credit based on your booking history. No complex paperwork.</p>
                <button class="w-full py-4 bg-white text-blue-600 font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-xl transition-all hover:scale-105 active:scale-95">
                    Check Eligibility
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
