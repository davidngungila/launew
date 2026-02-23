<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SystemSetting;
use App\Services\EmailService;
use Illuminate\Http\Request;

class EmailGatewayController extends Controller
{
    public function edit()
    {
        $settings = [
            'mail_host' => (string) (SystemSetting::getValue('mail_host') ?: env('MAIL_HOST', '127.0.0.1')),
            'mail_port' => (int) (SystemSetting::getValue('mail_port') ?: env('MAIL_PORT', 587)),
            'mail_username' => (string) (SystemSetting::getValue('mail_username') ?: env('MAIL_USERNAME')),
            'mail_password' => (string) (SystemSetting::getValue('mail_password') ?: env('MAIL_PASSWORD')),
            'mail_encryption' => (string) (SystemSetting::getValue('mail_encryption') ?: env('MAIL_ENCRYPTION', 'tls')),
            'mail_from_address' => (string) (SystemSetting::getValue('mail_from_address') ?: env('MAIL_FROM_ADDRESS')),
            'mail_from_name' => (string) (SystemSetting::getValue('mail_from_name') ?: env('MAIL_FROM_NAME', config('app.name', 'System'))),
        ];

        return view('admin.settings.email-gateway', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
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

        foreach (array_keys($validated) as $key) {
            SystemSetting::setValue($key, $validated[$key]);
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'email_gateway.updated',
            'subject_type' => 'email_gateway',
            'properties' => [
                'keys' => array_keys($validated),
            ],
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1024),
        ]);

        return back()->with('success', 'Email gateway settings updated successfully');
    }

    public function test(Request $request)
    {
        $validated = $request->validate([
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|integer|min:1|max:65535',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|in:tls,ssl,null,none',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string|max:255',
            'to' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $encryption = $validated['mail_encryption'] ?? null;
        if ($encryption === 'none' || $encryption === 'null') {
            $validated['mail_encryption'] = null;
        }

        $service = new EmailService();
        $service->updateConfig([
            'host' => $validated['mail_host'],
            'port' => (int) $validated['mail_port'],
            'username' => $validated['mail_username'] ?? null,
            'password' => $validated['mail_password'] ?? null,
            'encryption' => $validated['mail_encryption'] ?? null,
            'from_address' => $validated['mail_from_address'],
            'from_name' => $validated['mail_from_name'],
        ]);

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
