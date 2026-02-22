@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-32">
    <!-- Top Action Bar -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div class="flex items-center gap-6">
            <a href="{{ route('admin.bookings.index') }}" class="w-14 h-14 bg-white border border-slate-100 text-slate-400 rounded-2xl flex items-center justify-center hover:bg-slate-50 transition-all shadow-sm">
                <i class="ph-bold ph-arrow-left text-xl"></i>
            </a>
            <div>
                <nav class="flex items-center gap-2 mb-1">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Expedition Dossier</span>
                    <i class="ph ph-caret-right text-slate-300 text-[10px]"></i>
                    <span class="text-[10px] font-black uppercase tracking-widest text-emerald-600">ID #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                </nav>
                <h1 class="text-4xl font-black text-slate-900 tracking-tighter">{{ $booking->customer_name }}</h1>
            </div>
        </div>
        
        <div class="flex flex-wrap items-center gap-3">
            <button class="px-6 py-4 bg-white border border-slate-100 text-slate-600 font-black text-[10px] uppercase tracking-widest rounded-2xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-3">
                <i class="ph-bold ph-envelope-simple text-lg"></i>
                Send Itinerary
            </button>
            <a href="{{ route('bookings.invoice', $booking->id) }}" target="_blank" class="px-6 py-4 bg-white border border-slate-100 text-slate-600 font-black text-[10px] uppercase tracking-widest rounded-2xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-3">
                <i class="ph-bold ph-printer text-lg"></i>
                Voucher PDF
            </a>
            <div class="h-10 w-px bg-slate-200 mx-2"></div>
            <button class="px-8 py-4 bg-slate-900 text-white font-black text-[10px] uppercase tracking-widest rounded-2xl hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/10 flex items-center gap-3">
                <i class="ph-bold ph-pencil-simple text-lg text-emerald-400"></i>
                Edit Dossier
            </button>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Column: Core Dossier (8 Units) -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Quick Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm relative overflow-hidden group">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Tour Package</p>
                    <h3 class="text-lg font-black text-slate-900 leading-tight">{{ $booking->tour->name ?? 'Custom Expedition' }}</h3>
                    <div class="absolute -bottom-4 -right-4 opacity-5 group-hover:scale-110 transition-transform">
                        <i class="ph ph-mountains text-7xl"></i>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm relative overflow-hidden group">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Departure Date</p>
                    <h3 class="text-lg font-black text-slate-900 leading-tight">{{ date('d M, Y', strtotime($booking->start_date)) }}</h3>
                    <p class="text-[10px] font-bold text-emerald-600 mt-2 uppercase">Scheduled Departure</p>
                    <div class="absolute -bottom-4 -right-4 opacity-5 group-hover:scale-110 transition-transform">
                        <i class="ph ph-calendar-check text-7xl"></i>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm relative overflow-hidden group">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Group Dynamics</p>
                    <h3 class="text-lg font-black text-slate-900 leading-tight">{{ $booking->adults + $booking->children }} Travelers</h3>
                    <p class="text-[10px] font-bold text-slate-500 mt-2 uppercase">{{ $booking->adults }} Adults, {{ $booking->children }} Child</p>
                    <div class="absolute -bottom-4 -right-4 opacity-5 group-hover:scale-110 transition-transform">
                        <i class="ph ph-users-three text-7xl"></i>
                    </div>
                </div>
            </div>

            <!-- Detailed Dossier Section -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xl overflow-hidden">
                <div class="bg-slate-50 border-b border-slate-100 px-10 py-6 flex items-center justify-between">
                    <h4 class="text-xs font-black uppercase tracking-[0.2em] text-slate-900">Technical Specifications</h4>
                    <span class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-[9px] font-black text-slate-400 uppercase tracking-widest">Live Record</span>
                </div>
                <div class="p-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-10">
                        <!-- Contact Detail -->
                        <div class="space-y-4">
                            <h5 class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                                <i class="ph-bold ph-user-circle text-emerald-500"></i> Primary Liaison
                            </h5>
                            <div class="space-y-1">
                                <p class="text-sm font-black text-slate-900">{{ $booking->customer_name }}</p>
                                <p class="text-xs font-bold text-slate-500">{{ $booking->customer_email }}</p>
                                <p class="text-xs font-bold text-slate-500">{{ $booking->customer_phone }}</p>
                            </div>
                        </div>

                        <!-- Tour Specs -->
                        <div class="space-y-4">
                            <h5 class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                                <i class="ph-bold ph-map-trifold text-blue-500"></i> Safari Track
                            </h5>
                            <div class="space-y-1">
                                <p class="text-sm font-black text-slate-900">{{ $booking->tour->name ?? 'N/A' }}</p>
                                <p class="text-xs font-bold text-slate-500">{{ ($booking->tour->duration_days ?? '??') }} Days Expedition</p>
                            </div>
                        </div>

                        <!-- Special Requests -->
                        <div class="md:col-span-2 space-y-4 p-8 bg-slate-50/50 rounded-3xl border border-dashed border-slate-200">
                            <h5 class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-amber-600">
                                <i class="ph-bold ph-note text-amber-500"></i> Special Dossier Notes
                            </h5>
                            <p class="text-sm font-medium text-slate-600 italic leading-relaxed">
                                @if($booking->special_requests)
                                    "{{ $booking->special_requests }}"
                                @else
                                    No specific special requirements registered for this expedition.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logistics and Ground Support -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xl p-10 space-y-10">
                <div class="flex items-end justify-between border-b border-slate-50 pb-8">
                    <div>
                        <h4 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-1">Ground Support</h4>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Expedition Crew</h2>
                    </div>
                    <button class="px-5 py-2.5 bg-slate-50 text-[10px] font-black uppercase tracking-widest text-slate-900 rounded-xl hover:bg-slate-100 transition-all border border-slate-100">Modify Assignments</button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Guide Card -->
                    <div class="group">
                        <div class="flex items-center gap-5 p-4 rounded-[2rem] hover:bg-emerald-50/50 transition-all">
                            <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform">
                                <i class="ph-bold ph-identification-card text-3xl"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Lead Guide</p>
                                <p class="text-sm font-black text-slate-900 leading-tight">{{ $booking->guide->name ?? 'Unassigned' }}</p>
                                @if($booking->guide)
                                <p class="text-[10px] font-black text-emerald-600 mt-1 uppercase tracking-widest">Active Duty</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Driver Card -->
                    <div class="group">
                        <div class="flex items-center gap-5 p-4 rounded-[2rem] hover:bg-blue-50/50 transition-all">
                            <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform">
                                <i class="ph-bold ph-steering-wheel text-3xl"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Lead Driver</p>
                                <p class="text-sm font-black text-slate-900 leading-tight">{{ $booking->driver->name ?? 'Unassigned' }}</p>
                                @if($booking->driver)
                                <p class="text-[10px] font-black text-blue-600 mt-1 uppercase tracking-widest">Active Duty</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Vehicle Card -->
                    <div class="group">
                        <div class="flex items-center gap-5 p-4 rounded-[2rem] hover:bg-purple-50/50 transition-all">
                            <div class="w-16 h-16 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform">
                                <i class="ph-bold ph-jeep text-3xl"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Expedition 4x4</p>
                                <p class="text-sm font-black text-slate-900 leading-tight">{{ $booking->vehicle->plate_number ?? 'Unassigned' }}</p>
                                <p class="text-[10px] font-black text-slate-400 mt-1 uppercase tracking-widest">L-Series</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: status, Intelligence, Lifecycle (4 Units) -->
        <div class="lg:col-span-4 space-y-8">
            
            <!-- Financial Dossier -->
            <div class="bg-slate-900 rounded-2xl p-10 text-white shadow-2xl relative overflow-hidden group">
                <!-- Decoration -->
                <div class="absolute -top-20 -right-20 w-64 h-64 bg-emerald-500/10 rounded-full blur-[100px] group-hover:bg-emerald-500/20 transition-all duration-1000"></div>

                <div class="relative z-10 space-y-10">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-white/40 mb-3">Expedition Value</p>
                        <h2 class="text-5xl font-black tracking-tighter">${{ number_format($booking->total_price, 2) }}</h2>
                        <div class="flex items-center gap-2 mt-4 text-[10px] font-black uppercase text-emerald-400 tracking-widest">
                            <i class="ph ph-shield-check"></i> SSL Secured Transaction
                        </div>
                    </div>

                    <div class="space-y-6 bg-white/5 rounded-2xl p-8 border border-white/10">
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-black uppercase text-white/60 tracking-widest">Payment Plan</span>
                            <span class="text-xs font-black uppercase tracking-widest text-emerald-400">{{ $booking->payment_status }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-6 border-b border-white/5">
                            <span class="text-[10px] font-black uppercase text-white/60 tracking-widest">Deposit Paid</span>
                            <span class="text-xs font-black tracking-tighter">${{ number_format($booking->deposit_amount ?? ($booking->payment_status === 'paid' ? $booking->total_price : 0), 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-[10px] font-black uppercase text-white/40 tracking-widest">Balance Due</span>
                            <span class="text-lg font-black tracking-tighter text-amber-400">${{ number_format($booking->total_price - ($booking->deposit_amount ?? ($booking->payment_status === 'paid' ? $booking->total_price : 0)), 2) }}</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-[10px] font-black text-white/60 uppercase tracking-widest px-1">
                            <span>Lifecycle Progress</span>
                            <span>{{ $booking->payment_status === 'paid' ? '100' : '30' }}%</span>
                        </div>
                        <div class="w-full h-3 bg-white/10 rounded-full overflow-hidden p-0.5">
                             <div class="h-full bg-gradient-to-r from-emerald-600 to-emerald-400 rounded-full shadow-[0_0_15px_rgba(16,185,129,0.3)] transition-all duration-1000" style="width: {{ $booking->payment_status === 'paid' ? '100' : '30' }}%"></div>
                        </div>
                    </div>

                    <div class="bg-white/5 p-4 rounded-2xl">
                        <p class="text-[9px] font-black text-white/40 uppercase tracking-[0.2em] mb-1">Authorization Code</p>
                        <p class="text-xs font-medium text-slate-300 font-mono tracking-wider">{{ $booking->payment_reference ?? 'TRANS_AUTH_N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Booking Lifecycle Timeline -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xl p-10 space-y-8">
                <div>
                    <h4 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-2">Audit Trace</h4>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">Timeline</h3>
                </div>

                <div class="space-y-8 relative">
                    <!-- Vertical Line -->
                    <div class="absolute left-[15px] top-2 bottom-2 w-0.5 bg-slate-100"></div>

                    <!-- Timeline Item -->
                    <div class="relative pl-10">
                        <div class="absolute left-0 top-1 w-8 h-8 rounded-full bg-emerald-500 border-4 border-white shadow-sm flex items-center justify-center text-white">
                            <i class="ph-bold ph-check text-[10px]"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600 mb-1">Expedition Booked</p>
                            <p class="text-xs font-bold text-slate-900">{{ $booking->created_at->format('M d, Y • H:i') }}</p>
                            <p class="text-[10px] text-slate-400 mt-1">Automatic entry created via Public Engine.</p>
                        </div>
                    </div>

                    <!-- Timeline Item (Dynamic if paid) -->
                    @if($booking->payment_status === 'paid' || $booking->payment_status === 'partially_paid')
                    <div class="relative pl-10">
                        <div class="absolute left-0 top-1 w-8 h-8 rounded-full bg-blue-500 border-4 border-white shadow-sm flex items-center justify-center text-white">
                            <i class="ph-bold ph-currency-dollar text-[10px]"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-blue-600 mb-1">Payment Verified</p>
                            <p class="text-xs font-bold text-slate-900">{{ $booking->updated_at->format('M d, Y • H:i') }}</p>
                            <p class="text-[10px] text-slate-400 mt-1">{{ $booking->payment_method === 'flutterwave' ? 'Flutterwave' : 'Stripe' }} transaction authorized.</p>
                        </div>
                    </div>
                    @else
                    <div class="relative pl-10 opacity-40">
                         <div class="absolute left-0 top-1 w-8 h-8 rounded-full bg-slate-200 border-4 border-white shadow-sm"></div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Awaiting Deposit</p>
                            <p class="text-xs font-bold text-slate-400">Payment Pending Verification</p>
                        </div>
                    </div>
                    @endif

                    <!-- Final Timeline Item -->
                    <div class="relative pl-10 {{ $booking->status === 'confirmed' ? '' : 'opacity-40' }}">
                        <div class="absolute left-0 top-1 w-8 h-8 rounded-full {{ $booking->status === 'confirmed' ? 'bg-purple-500' : 'bg-slate-200' }} border-4 border-white shadow-sm flex items-center justify-center text-white">
                            <i class="ph-bold ph-airplane-landing text-[10px]"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest {{ $booking->status === 'confirmed' ? 'text-purple-600' : 'text-slate-400' }} mb-1">Final Confirmation</p>
                            <p class="text-xs font-bold {{ $booking->status === 'confirmed' ? 'text-slate-900' : 'text-slate-400' }}">
                                {{ $booking->status === 'confirmed' ? 'System Voucher Dispatched' : 'Expedition Pending Review' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Management (Flutterwave) -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xl p-10 space-y-6">
                <div>
                    <h4 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-2">Financial Control</h4>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">Transaction Management</h3>
                </div>

                <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Gateway</span>
                        <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-[9px] font-black uppercase">Flutterwave</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Reference</span>
                        <span class="text-xs font-mono font-bold text-slate-600">{{ $booking->payment_reference ?? 'N/A' }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-3">
                    <form action="{{ route('admin.bookings.verify-payment', $booking->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-emerald-500 text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-emerald-400 transition-all shadow-lg shadow-emerald-500/20">
                            <i class="ph-bold ph-shield-check text-lg"></i>
                            Verify Transaction Status
                        </button>
                    </form>
                    
                    <button class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-white border border-slate-200 text-slate-600 font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-slate-50 transition-all">
                        <i class="ph-bold ph-receipt text-lg"></i>
                        Generate Receipt
                    </button>
                </div>
                
                <p class="text-[9px] text-center text-slate-400 font-bold uppercase tracking-widest">Use this to manually sync payment status from Flutterwave</p>
            </div>

            <!-- Management Tools -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 flex items-center justify-between group cursor-pointer hover:bg-slate-50 transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-500 group-hover:bg-slate-900 group-hover:text-white transition-all">
                        <i class="ph ph-shield-warning text-xl"></i>
                    </div>
                    <div>
                        <h5 class="text-sm font-black text-slate-900">Incident Report</h5>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Register Issue</p>
                    </div>
                </div>
                <i class="ph ph-caret-right text-slate-300"></i>
            </div>
        </div>
    </div>
</div>
@endsection
