<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SMSGatewayController extends Controller
{
    public function index()
    {
        $providers = \App\Models\NotificationProvider::orderBy('priority')->get();
        $fallbackSettings = [
            'sms_username' => null, // Would normally come from a Setting model
            'sms_from' => null,
            'sms_url' => null,
        ];
        
        return view('admin.settings.sms-gateway', compact('providers', 'fallbackSettings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sms_from' => 'required|string',
            'sms_url' => 'required|url',
            'sms_method' => 'required|in:get,post',
        ]);

        if ($request->is_primary) {
            \App\Models\NotificationProvider::where('is_primary', true)->update(['is_primary' => false]);
        }

        \App\Models\NotificationProvider::create($request->all());

        return response()->json(['success' => true, 'message' => 'Provider added successfully']);
    }

    public function update(Request $request, $id)
    {
        $provider = \App\Models\NotificationProvider::findOrFail($id);
        
        if ($request->is_primary) {
            \App\Models\NotificationProvider::where('is_primary', true)->update(['is_primary' => false]);
        }

        $provider->update($request->all());

        return response()->json(['success' => true, 'message' => 'Provider updated successfully']);
    }

    public function testConnection($id)
    {
        $provider = NotificationProvider::findOrFail($id);

        try {
            $token = $provider->sms_bearer_token;
            $username = $provider->sms_username;
            $password = $provider->sms_password;

            $request = Http::timeout(20)->acceptJson();
            if ($token) {
                $request = $request->withToken($token);
            } elseif ($username && $password) {
                $request = $request->withHeaders([
                    'Authorization' => 'Basic ' . base64_encode($username . ':' . $password),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Missing credentials. Set Bearer token or username/password.',
                ], 422);
            }

            $resp = $request->get('https://messaging-service.co.tz/api/v2/balance');
            $success = $resp->successful();

            $provider->update([
                'connection_status' => $success ? 'connected' : 'disconnected',
                'last_tested_at' => now(),
            ]);

            return response()->json([
                'success' => $success,
                'message' => $success ? 'Connection verified successfully!' : 'Connection failed. Please check credentials.',
                'data' => $success ? $resp->json() : null,
            ], $success ? 200 : 500);
        } catch (\Throwable $e) {
            $provider->update([
                'connection_status' => 'disconnected',
                'last_tested_at' => now(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Connection test failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function toggleActive($id)
    {
        $provider = \App\Models\NotificationProvider::findOrFail($id);
        $provider->update(['is_active' => !$provider->is_active]);
        return response()->json(['success' => true]);
    }

    public function setPrimary($id)
    {
        \App\Models\NotificationProvider::where('is_primary', true)->update(['is_primary' => false]);
        \App\Models\NotificationProvider::findOrFail($id)->update(['is_primary' => true]);
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        \App\Models\NotificationProvider::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function test(Request $request)
    {
        $validated = $request->validate([
            'to' => 'required|string',
            'message' => 'required|string',
        ]);

        $provider = NotificationProvider::getPrimary('sms') ?? NotificationProvider::query()->where('is_active', true)->orderByDesc('is_primary')->orderBy('priority')->first();
        if (!$provider) {
            return response()->json(['success' => false, 'message' => 'No SMS provider configured'], 422);
        }

        if (!$provider->sms_from) {
            return response()->json(['success' => false, 'message' => 'Provider is missing Sender ID (sms_from)'], 422);
        }

        try {
            $token = $provider->sms_bearer_token;
            $username = $provider->sms_username;
            $password = $provider->sms_password;

            $requestClient = Http::timeout(30)->acceptJson()->asJson();
            if ($token) {
                $requestClient = $requestClient->withToken($token);
            } elseif ($username && $password) {
                $requestClient = $requestClient->withHeaders([
                    'Authorization' => 'Basic ' . base64_encode($username . ':' . $password),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Missing credentials. Set Bearer token or username/password.',
                ], 422);
            }

            $payload = [
                'from' => $provider->sms_from,
                'to' => preg_replace('/[^0-9]/', '', $validated['to']),
                'text' => $validated['message'],
                'reference' => 'test_' . time(),
            ];

            $resp = $requestClient->post('https://messaging-service.co.tz/api/sms/v2/test/text/single', $payload);
            $success = $resp->successful();

            return response()->json([
                'success' => $success,
                'message' => $success ? 'Test request submitted successfully' : 'Test request failed',
                'data' => $resp->json(),
            ], $success ? 200 : 500);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Test SMS failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
