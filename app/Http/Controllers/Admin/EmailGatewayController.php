<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\EmailGateway;
use App\Models\SystemSetting;
use App\Services\EmailService;
use Illuminate\Http\Request;

class EmailGatewayController extends Controller
{
    public function edit(Request $request)
    {
        $gateways = EmailGateway::query()->orderByDesc('is_active')->orderBy('name')->get();
        $selectedId = $request->query('gateway_id');
        $active = null;

        if ($selectedId) {
            $active = $gateways->firstWhere('id', (int) $selectedId);
        }

        if (!$active) {
            $active = $gateways->firstWhere('is_active', true);
        }

        if (!$active) {
            $active = $gateways->first();
        }

        $settings = [
            'gateway_id' => $active?->id,
            'gateway_name' => $active?->name,
            'mail_host' => (string) ($active?->host ?: (SystemSetting::getValue('mail_host') ?: '')),
            'mail_port' => (int) ($active?->port ?: (SystemSetting::getValue('mail_port') ?: 587)),
            'mail_username' => (string) ($active?->username ?: (SystemSetting::getValue('mail_username') ?: '')),
            'mail_password' => (string) ($active?->password ?: (SystemSetting::getValue('mail_password') ?: '')),
            'mail_encryption' => (string) ($active?->encryption ?: (SystemSetting::getValue('mail_encryption') ?: 'tls')),
            'mail_from_address' => (string) ($active?->from_address ?: (SystemSetting::getValue('mail_from_address') ?: '')),
            'mail_from_name' => (string) ($active?->from_name ?: (SystemSetting::getValue('mail_from_name') ?: config('app.name', 'System'))),
        ];

        return view('admin.settings.email-gateway', compact('settings', 'gateways'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'gateway_id' => 'nullable|integer|exists:email_gateways,id',
            'gateway_name' => 'nullable|string|max:255',
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|integer|min:1|max:65535',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|in:tls,ssl,null,none',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string|max:255',
        ]);

        $encryption = $validated['mail_encryption'] ?? null;
        if ($encryption === 'none' || $encryption === 'null') {
            $validated['mail_encryption'] = null;
        }

        $gatewayData = [
            'name' => (string) ($validated['gateway_name'] ?? 'SMTP Gateway'),
            'host' => $validated['mail_host'],
            'port' => (int) $validated['mail_port'],
            'username' => $validated['mail_username'] ?? null,
            'password' => $validated['mail_password'] ?? null,
            'encryption' => $validated['mail_encryption'] ?? null,
            'from_address' => $validated['mail_from_address'],
            'from_name' => $validated['mail_from_name'],
        ];

        $gateway = null;
        if (!empty($validated['gateway_id'])) {
            $gateway = EmailGateway::query()->find($validated['gateway_id']);
        }

        if ($gateway) {
            $gateway->update($gatewayData);
        } else {
            $gateway = EmailGateway::query()->create(array_merge($gatewayData, ['is_active' => true]));
            EmailGateway::query()->where('id', '!=', $gateway->id)->update(['is_active' => false]);
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'email_gateway.updated',
            'subject_type' => 'email_gateway',
            'properties' => [
                'gateway_id' => $gateway?->id,
            ],
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1024),
        ]);

        return back()->with('success', 'Email gateway settings updated successfully');
    }

    public function activate(Request $request, EmailGateway $gateway)
    {
        EmailGateway::query()->where('id', '!=', $gateway->id)->update(['is_active' => false]);
        $gateway->update(['is_active' => true]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'email_gateway.activated',
            'subject_type' => EmailGateway::class,
            'subject_id' => $gateway->id,
            'properties' => [
                'gateway_id' => $gateway->id,
            ],
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1024),
        ]);

        return back()->with('success', 'Email gateway activated');
    }

    public function test(Request $request)
    {
        $validated = $request->validate([
            'mail_host' => 'nullable|string|max:255',
            'mail_port' => 'nullable|integer|min:1|max:65535',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|in:tls,ssl,null,none',
            'mail_from_address' => 'nullable|email',
            'mail_from_name' => 'nullable|string|max:255',
            'to' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $encryption = $validated['mail_encryption'] ?? null;
        if ($encryption === 'none' || $encryption === 'null') {
            $validated['mail_encryption'] = null;
        }

        $service = new EmailService();

        $hasPayload = !empty($validated['mail_host'])
            && !empty($validated['mail_port'])
            && !empty($validated['mail_from_address'])
            && !empty($validated['mail_from_name']);

        if ($hasPayload) {
            $service->updateConfig([
                'host' => $validated['mail_host'],
                'port' => (int) $validated['mail_port'],
                'username' => $validated['mail_username'] ?? null,
                'password' => $validated['mail_password'] ?? null,
                'encryption' => $validated['mail_encryption'] ?? null,
                'from_address' => $validated['mail_from_address'],
                'from_name' => $validated['mail_from_name'],
            ]);
        }

        $connection = $service->testConnection();
        if (!($connection['success'] ?? false)) {
            return response()->json([
                'success' => false,
                'message' => 'Connection check failed',
                'data' => $connection,
            ], 422);
        }

        $sent = $service->send(
            $validated['to'],
            $validated['subject'],
            nl2br(e($validated['message']))
        );

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'email_gateway.test_sent',
            'subject_type' => 'email_gateway',
            'properties' => [
                'to' => $validated['to'],
                'subject' => $validated['subject'],
                'connection' => $connection,
                'sent' => $sent,
            ],
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1024),
        ]);

        return response()->json([
            'success' => $sent,
            'message' => $sent ? 'Test email sent successfully' : 'Failed to send test email',
            'data' => [
                'connection' => $connection,
                'sent' => $sent,
            ],
        ], $sent ? 200 : 500);
    }
}
