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

    public function create()
    {
        $defaults = [
            'sms_method' => 'post',
            'sms_url' => 'https://messaging-service.co.tz/api/sms/v2/text/single',
            'priority' => 0,
            'is_active' => true,
            'is_primary' => true,
        ];

        return view('admin.settings.sms-gateway-create', compact('defaults'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sms_from' => 'required|string',
            'sms_url' => 'required|url',
            'sms_method' => 'required|in:get,post',
            'sms_bearer_token' => 'nullable|string',
            'sms_username' => 'nullable|string',
            'sms_password' => 'nullable|string',
            'priority' => 'nullable|integer',
            'notes' => 'nullable|string',
            'is_primary' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        if (($validated['is_primary'] ?? false) == true) {
            \App\Models\NotificationProvider::where('is_primary', true)->update(['is_primary' => false]);
        }

        $validated['is_active'] = ($validated['is_active'] ?? true) == true;

        \App\Models\NotificationProvider::create($validated);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Provider added successfully']);
        }

        return redirect()->route('admin.settings.sms-gateway.index')->with('success', 'Provider added successfully');
    }

    public function update(Request $request, $id)
    {
        $provider = \App\Models\NotificationProvider::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sms_from' => 'required|string',
            'sms_url' => 'required|url',
            'sms_method' => 'required|in:get,post',
            'sms_bearer_token' => 'nullable|string',
            'sms_username' => 'nullable|string',
            'sms_password' => 'nullable|string',
            'priority' => 'nullable|integer',
            'notes' => 'nullable|string',
            'is_primary' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);
        
        if (($validated['is_primary'] ?? false) == true) {
            \App\Models\NotificationProvider::where('is_primary', true)->update(['is_primary' => false]);
        }

        if (array_key_exists('is_active', $validated)) {
            $validated['is_active'] = ($validated['is_active'] ?? false) == true;
        }

        $provider->update($validated);

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

        if (!$provider->sms_url) {
            return response()->json(['success' => false, 'message' => 'Provider is missing SMS URL (sms_url)'], 422);
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

            $method = strtolower((string) ($provider->sms_method ?: 'post'));
            if (!in_array($method, ['get', 'post'], true)) {
                $method = 'post';
            }

            $resp = $method === 'get'
                ? $requestClient->get($provider->sms_url, $payload)
                : $requestClient->post($provider->sms_url, $payload);
            $success = $resp->successful();

            return response()->json([
                'success' => $success,
                'message' => $success ? 'Test request submitted successfully' : 'Test request failed',
                'data' => $resp->json() ?? $resp->body(),
                'meta' => [
                    'provider_id' => $provider->id,
                    'url' => $provider->sms_url,
                    'method' => strtoupper($method),
                ],
            ], $success ? 200 : 500);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Test SMS failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function testDraftConnection(Request $request)
    {
        $validated = $request->validate([
            'sms_bearer_token' => 'nullable|string',
            'sms_username' => 'nullable|string',
            'sms_password' => 'nullable|string',
        ]);

        try {
            $token = $validated['sms_bearer_token'] ?? null;
            $username = $validated['sms_username'] ?? null;
            $password = $validated['sms_password'] ?? null;

            $client = Http::timeout(20)->acceptJson();
            if ($token) {
                $client = $client->withToken($token);
            } elseif ($username && $password) {
                $client = $client->withHeaders([
                    'Authorization' => 'Basic ' . base64_encode($username . ':' . $password),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Missing credentials. Set Bearer token or username/password.',
                ], 422);
            }

            $resp = $client->get('https://messaging-service.co.tz/api/v2/balance');
            $success = $resp->successful();

            return response()->json([
                'success' => $success,
                'message' => $success ? 'Connection verified successfully!' : 'Connection failed. Please check credentials.',
                'data' => $resp->json() ?? $resp->body(),
            ], $success ? 200 : 500);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Connection test failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function testDraftSms(Request $request)
    {
        $validated = $request->validate([
            'sms_from' => 'required|string',
            'sms_url' => 'required|url',
            'sms_method' => 'required|in:get,post',
            'sms_bearer_token' => 'nullable|string',
            'sms_username' => 'nullable|string',
            'sms_password' => 'nullable|string',
            'to' => 'required|string',
            'message' => 'required|string',
        ]);

        try {
            $token = $validated['sms_bearer_token'] ?? null;
            $username = $validated['sms_username'] ?? null;
            $password = $validated['sms_password'] ?? null;

            $client = Http::timeout(30)->acceptJson()->asJson();
            if ($token) {
                $client = $client->withToken($token);
            } elseif ($username && $password) {
                $client = $client->withHeaders([
                    'Authorization' => 'Basic ' . base64_encode($username . ':' . $password),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Missing credentials. Set Bearer token or username/password.',
                ], 422);
            }

            $payload = [
                'from' => $validated['sms_from'],
                'to' => preg_replace('/[^0-9]/', '', $validated['to']),
                'text' => $validated['message'],
                'reference' => 'draft_test_' . time(),
            ];

            $method = strtolower((string) ($validated['sms_method'] ?? 'post'));
            $resp = $method === 'get'
                ? $client->get($validated['sms_url'], $payload)
                : $client->post($validated['sms_url'], $payload);

            $success = $resp->successful();

            return response()->json([
                'success' => $success,
                'message' => $success ? 'Test request submitted successfully' : 'Test request failed',
                'data' => $resp->json() ?? $resp->body(),
                'meta' => [
                    'url' => $validated['sms_url'],
                    'method' => strtoupper($method),
                ],
            ], $success ? 200 : 500);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Test SMS failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
