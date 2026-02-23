<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemSettingsController extends Controller
{
    public function edit()
    {
        $settings = [
            'company' => SystemSetting::getValue('company', [
                'name' => 'LAU Paradise Adventure',
                'email' => 'lauparadiseadventure@gmail.com',
                'timezone' => config('app.timezone'),
                'currency' => 'USD',
            ]),
            'pricing_rules' => SystemSetting::getValue('pricing_rules', [
                'kilimanjaro_default_price' => null,
                'safari_default_price' => null,
                'zanzibar_default_price' => null,
                'allow_seasonal_pricing' => true,
                'allow_discounts' => true,
                'default_commission_percent' => 10,
            ]),
            'booking_rules' => SystemSetting::getValue('booking_rules', [
                'min_participants' => 1,
                'max_participants' => 30,
                'deposit_percent' => 30,
                'balance_due_days_before_departure' => 7,
                'auto_cancel_unpaid_after_days' => 3,
                'enable_waitlist' => false,
            ]),
            'payment_rules' => SystemSetting::getValue('payment_rules', [
                'enable_stripe' => true,
                'enable_flutterwave' => true,
                'enable_mpesa' => false,
                'vat_percent' => 0,
                'tourism_levy_percent' => 0,
                'enable_currency_conversion' => true,
            ]),
            'notification_rules' => SystemSetting::getValue('notification_rules', [
                'send_booking_confirmation' => true,
                'send_payment_received' => true,
                'send_pre_tour_reminder' => true,
                'pre_tour_reminder_days' => 3,
            ]),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'company.name' => 'required|string|max:255',
            'company.email' => 'required|email',
            'company.timezone' => 'required|string|max:255',
            'company.currency' => 'required|string|max:10',

            'pricing_rules.default_commission_percent' => 'nullable|numeric|min:0|max:100',
            'pricing_rules.allow_seasonal_pricing' => 'nullable|boolean',
            'pricing_rules.allow_discounts' => 'nullable|boolean',

            'booking_rules.min_participants' => 'nullable|integer|min:1',
            'booking_rules.max_participants' => 'nullable|integer|min:1',
            'booking_rules.deposit_percent' => 'nullable|numeric|min:0|max:100',
            'booking_rules.balance_due_days_before_departure' => 'nullable|integer|min:0',
            'booking_rules.auto_cancel_unpaid_after_days' => 'nullable|integer|min:0',
            'booking_rules.enable_waitlist' => 'nullable|boolean',

            'payment_rules.enable_stripe' => 'nullable|boolean',
            'payment_rules.enable_flutterwave' => 'nullable|boolean',
            'payment_rules.enable_mpesa' => 'nullable|boolean',
            'payment_rules.vat_percent' => 'nullable|numeric|min:0|max:100',
            'payment_rules.tourism_levy_percent' => 'nullable|numeric|min:0|max:100',
            'payment_rules.enable_currency_conversion' => 'nullable|boolean',

            'notification_rules.send_booking_confirmation' => 'nullable|boolean',
            'notification_rules.send_payment_received' => 'nullable|boolean',
            'notification_rules.send_pre_tour_reminder' => 'nullable|boolean',
            'notification_rules.pre_tour_reminder_days' => 'nullable|integer|min:0',
        ]);

        foreach (['company', 'pricing_rules', 'booking_rules', 'payment_rules', 'notification_rules'] as $key) {
            $value = $validated[$key] ?? [];
            SystemSetting::setValue($key, $value);
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'settings.updated',
            'subject_type' => 'system_settings',
            'properties' => [
                'keys' => array_keys($validated),
            ],
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1024),
        ]);

        return back()->with('success', 'Settings updated successfully');
    }
}
