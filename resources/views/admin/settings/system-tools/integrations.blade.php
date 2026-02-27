@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 pb-20">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Integrations</h1>
            <p class="text-slate-500 font-medium">Quick view of enabled services (keys remain in .env)</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.sms-gateway.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">SMS Gateway</a>
            <a href="{{ route('admin.settings.email-gateway.edit') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Email Gateway</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Mail Driver</div>
            <div class="mt-3 text-2xl font-black text-slate-900">{{ $stats['mail_driver'] ?? '' }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Queue Driver</div>
            <div class="mt-3 text-2xl font-black text-slate-900">{{ $stats['queue_driver'] ?? '' }}</div>
        </div>
        <div class="bg-slate-900 rounded-2xl p-6 text-white shadow-xl">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-white/50">Rule based toggles</div>
            <div class="mt-2 text-xs font-bold text-white/60">Some integrations are toggled from Settings.</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 space-y-6">
        <div>
            <h3 class="text-lg font-black text-slate-900 tracking-tight">Payment Gateways</h3>
            <p class="text-slate-500 text-sm font-medium">Enable/disable flags (keys are in environment variables)</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @php($items = [
                ['label' => 'Stripe', 'key' => 'enable_stripe'],
                ['label' => 'Flutterwave', 'key' => 'enable_flutterwave'],
                ['label' => 'M-Pesa', 'key' => 'enable_mpesa'],
            ])
            @foreach($items as $it)
                @php($on = (bool) data_get($paymentRules, $it['key'], false))
                <div class="px-6 py-5 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-between">
                    <div>
                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $it['label'] }}</div>
                        <div class="mt-1 text-sm font-black {{ $on ? 'text-emerald-700' : 'text-slate-700' }}">{{ $on ? 'Enabled' : 'Disabled' }}</div>
                    </div>
                    <div class="w-2.5 h-2.5 rounded-full {{ $on ? 'bg-emerald-500' : 'bg-slate-300' }}"></div>
                </div>
            @endforeach
        </div>

        <div class="pt-4 border-t border-slate-100">
            <a href="{{ route('admin.settings.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-slate-700 transition-colors">Manage toggles in General Settings</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 space-y-6">
        <div>
            <h3 class="text-lg font-black text-slate-900 tracking-tight">Notifications</h3>
            <p class="text-slate-500 text-sm font-medium">Rules for automated notifications</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @php($notiItems = [
                ['label' => 'Booking confirmation', 'key' => 'send_booking_confirmation'],
                ['label' => 'Payment received', 'key' => 'send_payment_received'],
                ['label' => 'Pre-tour reminder', 'key' => 'send_pre_tour_reminder'],
            ])
            @foreach($notiItems as $it)
                @php($on = (bool) data_get($notificationRules, $it['key'], false))
                <div class="px-6 py-5 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-between">
                    <div>
                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $it['label'] }}</div>
                        <div class="mt-1 text-sm font-black {{ $on ? 'text-emerald-700' : 'text-slate-700' }}">{{ $on ? 'Enabled' : 'Disabled' }}</div>
                    </div>
                    <div class="w-2.5 h-2.5 rounded-full {{ $on ? 'bg-emerald-500' : 'bg-slate-300' }}"></div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
