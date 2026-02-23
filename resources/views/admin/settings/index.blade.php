@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">System Settings</h1>
            <p class="text-slate-500 font-medium">Configure core business rules and user access</p>
        </div>
        <div class="flex items-center gap-3"></div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf
        @method('PUT')

        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between gap-4 mb-8">
                    <h3 class="text-xl font-black text-slate-900 flex items-center gap-3">
                        <i class="ph ph-laptop text-emerald-500"></i> General Configuration
                    </h3>
                    <button type="submit" class="px-5 py-3 bg-emerald-600 text-white font-black rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                        <i class="ph ph-check"></i>
                        Apply Changes
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Business Name</label>
                        <input type="text" name="company[name]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500" value="{{ old('company.name', $settings['company']['name'] ?? '') }}">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Default Currency</label>
                        <select name="company[currency]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none">
                            @foreach(['USD' => 'USD - US Dollar', 'TZS' => 'TZS - Tanzanian Shilling', 'EUR' => 'EUR - Euro', 'GBP' => 'GBP - British Pound'] as $code => $label)
                                <option value="{{ $code }}" {{ old('company.currency', $settings['company']['currency'] ?? '') === $code ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Primary Email</label>
                        <input type="email" name="company[email]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900" value="{{ old('company.email', $settings['company']['email'] ?? '') }}">
                    </div>
                    <div class="space-y-1">
                         <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Timezone</label>
                         <input type="text" name="company[timezone]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900" value="{{ old('company.timezone', $settings['company']['timezone'] ?? '') }}">
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm">
                <h3 class="text-xl font-black text-slate-900 mb-8 flex items-center gap-3">
                    <i class="ph ph-tag text-emerald-500"></i> Pricing & Packages
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Default Commission (%)</label>
                        <input type="number" step="0.01" name="pricing_rules[default_commission_percent]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900" value="{{ old('pricing_rules.default_commission_percent', $settings['pricing_rules']['default_commission_percent'] ?? '') }}">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Allow Seasonal Pricing</label>
                        <select name="pricing_rules[allow_seasonal_pricing]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none">
                            <option value="1" {{ (string) old('pricing_rules.allow_seasonal_pricing', (int) ($settings['pricing_rules']['allow_seasonal_pricing'] ?? 0)) === '1' ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ (string) old('pricing_rules.allow_seasonal_pricing', (int) ($settings['pricing_rules']['allow_seasonal_pricing'] ?? 0)) === '0' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Allow Discounts & Promotions</label>
                        <select name="pricing_rules[allow_discounts]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none">
                            <option value="1" {{ (string) old('pricing_rules.allow_discounts', (int) ($settings['pricing_rules']['allow_discounts'] ?? 0)) === '1' ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ (string) old('pricing_rules.allow_discounts', (int) ($settings['pricing_rules']['allow_discounts'] ?? 0)) === '0' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm">
                <h3 class="text-xl font-black text-slate-900 mb-8 flex items-center gap-3">
                    <i class="ph ph-calendar-check text-emerald-500"></i> Booking Rules
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Min Participants</label>
                        <input type="number" name="booking_rules[min_participants]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900" value="{{ old('booking_rules.min_participants', $settings['booking_rules']['min_participants'] ?? '') }}">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Max Participants</label>
                        <input type="number" name="booking_rules[max_participants]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900" value="{{ old('booking_rules.max_participants', $settings['booking_rules']['max_participants'] ?? '') }}">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Deposit (%)</label>
                        <input type="number" step="0.01" name="booking_rules[deposit_percent]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900" value="{{ old('booking_rules.deposit_percent', $settings['booking_rules']['deposit_percent'] ?? '') }}">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Balance Due (days before departure)</label>
                        <input type="number" name="booking_rules[balance_due_days_before_departure]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900" value="{{ old('booking_rules.balance_due_days_before_departure', $settings['booking_rules']['balance_due_days_before_departure'] ?? '') }}">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Auto-cancel unpaid after (days)</label>
                        <input type="number" name="booking_rules[auto_cancel_unpaid_after_days]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900" value="{{ old('booking_rules.auto_cancel_unpaid_after_days', $settings['booking_rules']['auto_cancel_unpaid_after_days'] ?? '') }}">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Enable Waitlist</label>
                        <select name="booking_rules[enable_waitlist]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none">
                            <option value="1" {{ (string) old('booking_rules.enable_waitlist', (int) ($settings['booking_rules']['enable_waitlist'] ?? 0)) === '1' ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ (string) old('booking_rules.enable_waitlist', (int) ($settings['booking_rules']['enable_waitlist'] ?? 0)) === '0' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm">
                <h3 class="text-xl font-black text-slate-900 mb-8 flex items-center gap-3">
                    <i class="ph ph-credit-card text-emerald-500"></i> Payment & Tax Rules
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Enable Stripe</label>
                        <select name="payment_rules[enable_stripe]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none">
                            <option value="1" {{ (string) old('payment_rules.enable_stripe', (int) ($settings['payment_rules']['enable_stripe'] ?? 0)) === '1' ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ (string) old('payment_rules.enable_stripe', (int) ($settings['payment_rules']['enable_stripe'] ?? 0)) === '0' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Enable Flutterwave</label>
                        <select name="payment_rules[enable_flutterwave]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none">
                            <option value="1" {{ (string) old('payment_rules.enable_flutterwave', (int) ($settings['payment_rules']['enable_flutterwave'] ?? 0)) === '1' ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ (string) old('payment_rules.enable_flutterwave', (int) ($settings['payment_rules']['enable_flutterwave'] ?? 0)) === '0' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Enable M-Pesa</label>
                        <select name="payment_rules[enable_mpesa]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none">
                            <option value="1" {{ (string) old('payment_rules.enable_mpesa', (int) ($settings['payment_rules']['enable_mpesa'] ?? 0)) === '1' ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ (string) old('payment_rules.enable_mpesa', (int) ($settings['payment_rules']['enable_mpesa'] ?? 0)) === '0' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">VAT (%)</label>
                        <input type="number" step="0.01" name="payment_rules[vat_percent]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900" value="{{ old('payment_rules.vat_percent', $settings['payment_rules']['vat_percent'] ?? '') }}">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Tourism Levy (%)</label>
                        <input type="number" step="0.01" name="payment_rules[tourism_levy_percent]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900" value="{{ old('payment_rules.tourism_levy_percent', $settings['payment_rules']['tourism_levy_percent'] ?? '') }}">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Enable Currency Conversion</label>
                        <select name="payment_rules[enable_currency_conversion]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none">
                            <option value="1" {{ (string) old('payment_rules.enable_currency_conversion', (int) ($settings['payment_rules']['enable_currency_conversion'] ?? 0)) === '1' ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ (string) old('payment_rules.enable_currency_conversion', (int) ($settings['payment_rules']['enable_currency_conversion'] ?? 0)) === '0' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm">
                <h3 class="text-xl font-black text-slate-900 mb-8 flex items-center gap-3">
                    <i class="ph ph-bell text-emerald-500"></i> Notification Rules
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Send Booking Confirmation</label>
                        <select name="notification_rules[send_booking_confirmation]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none">
                            <option value="1" {{ (string) old('notification_rules.send_booking_confirmation', (int) ($settings['notification_rules']['send_booking_confirmation'] ?? 0)) === '1' ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ (string) old('notification_rules.send_booking_confirmation', (int) ($settings['notification_rules']['send_booking_confirmation'] ?? 0)) === '0' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Send Payment Received</label>
                        <select name="notification_rules[send_payment_received]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none">
                            <option value="1" {{ (string) old('notification_rules.send_payment_received', (int) ($settings['notification_rules']['send_payment_received'] ?? 0)) === '1' ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ (string) old('notification_rules.send_payment_received', (int) ($settings['notification_rules']['send_payment_received'] ?? 0)) === '0' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Send Pre-tour Reminder</label>
                        <select name="notification_rules[send_pre_tour_reminder]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none">
                            <option value="1" {{ (string) old('notification_rules.send_pre_tour_reminder', (int) ($settings['notification_rules']['send_pre_tour_reminder'] ?? 0)) === '1' ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ (string) old('notification_rules.send_pre_tour_reminder', (int) ($settings['notification_rules']['send_pre_tour_reminder'] ?? 0)) === '0' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Reminder Days Before</label>
                        <input type="number" name="notification_rules[pre_tour_reminder_days]" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900" value="{{ old('notification_rules.pre_tour_reminder_days', $settings['notification_rules']['pre_tour_reminder_days'] ?? '') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm">
                <h3 class="text-lg font-black text-slate-900 tracking-tight mb-6">Quick Links</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.settings.sms-gateway.index') }}" class="block px-5 py-4 bg-slate-50 border border-slate-100 rounded-xl text-sm font-black text-slate-900 hover:bg-white transition-all">SMS Gateway</a>
                    <a href="{{ route('admin.settings.users.index') }}" class="block px-5 py-4 bg-slate-50 border border-slate-100 rounded-xl text-sm font-black text-slate-900 hover:bg-white transition-all">User Management</a>
                    <a href="{{ route('admin.settings.roles.index') }}" class="block px-5 py-4 bg-slate-50 border border-slate-100 rounded-xl text-sm font-black text-slate-900 hover:bg-white transition-all">Role Permissions</a>
                    <a href="{{ route('admin.settings.activity-logs.index') }}" class="block px-5 py-4 bg-slate-50 border border-slate-100 rounded-xl text-sm font-black text-slate-900 hover:bg-white transition-all">Activity Logs</a>
                    <a href="{{ route('admin.settings.system-health.index') }}" class="block px-5 py-4 bg-slate-50 border border-slate-100 rounded-xl text-sm font-black text-slate-900 hover:bg-white transition-all">System Health</a>
                </div>
            </div>

            <div class="bg-slate-900 p-8 rounded-2xl text-white shadow-xl shadow-slate-900/10">
                <h3 class="text-lg font-black mb-2">Payment Gateway Keys</h3>
                <p class="text-white/60 text-sm font-medium leading-relaxed">For security, keys should be set via environment variables. This page only controls enable/disable rules.</p>
            </div>
        </div>
    </form>
</div>
@endsection
