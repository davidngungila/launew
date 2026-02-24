@extends('layouts.public')

@section('content')
<section class="py-24 bg-slate-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-6 space-y-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">My Bookings</h1>
                <p class="text-slate-500 font-medium">Track payments, balance and booking status.</p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-6 py-3 bg-slate-900 text-white font-black rounded-2xl hover:bg-slate-800 transition-all">Logout</button>
            </form>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-50">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Account</p>
                <p class="text-sm font-black text-slate-900">{{ auth()->user()->name }} · {{ auth()->user()->email }}</p>
            </div>

            <div class="divide-y divide-slate-50">
                @forelse($bookings as $booking)
                    <div class="p-8 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                        <div class="space-y-2">
                            <p class="text-lg font-black text-slate-900">{{ $booking->tour->name ?? 'Tour' }}</p>
                            <p class="text-sm font-bold text-slate-500">Start: {{ $booking->start_date }} · Pax: {{ $booking->adults + $booking->children }}</p>
                            <p class="text-xs font-black text-slate-400">Booking: {{ $booking->booking_code ?: ('BK-' . str_pad($booking->id, 4, '0', STR_PAD_LEFT)) }}</p>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 w-full lg:w-auto">
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Total</p>
                                <p class="text-sm font-black text-slate-900">${{ number_format($booking->total_price, 2) }}</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Paid</p>
                                <p class="text-sm font-black text-emerald-700">${{ number_format(($booking->deposit_amount ?? 0) - ($booking->balance_amount ?? 0) > 0 ? (($booking->total_price ?? 0) - ($booking->balance_amount ?? 0)) : ($booking->deposit_amount ?? 0), 2) }}</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Balance</p>
                                <p class="text-sm font-black text-slate-900">${{ number_format($booking->balance_amount ?? 0, 2) }}</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Payment</p>
                                <p class="text-sm font-black text-slate-900">{{ str_replace('_', ' ', ucfirst($booking->payment_status)) }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <p class="text-sm font-black text-slate-900">No bookings yet</p>
                        <p class="text-sm font-bold text-slate-500 mt-2">Book a tour to see it here.</p>
                    </div>
                @endforelse
            </div>

            @if(method_exists($bookings, 'links'))
                <div class="p-6 border-t border-slate-50">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
