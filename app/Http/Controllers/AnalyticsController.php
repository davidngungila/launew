<?php

namespace App\Http\Controllers;

use App\Models\AnalyticsPageview;
use App\Models\AnalyticsSession;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnalyticsController extends Controller
{
    public function track(Request $request)
    {
        $validated = $request->validate([
            'visitor_id' => 'required|string|max:64',
            'session_uuid' => 'nullable|string|max:64',
            'path' => 'required|string|max:2048',
            'full_url' => 'nullable|string|max:2048',
            'title' => 'nullable|string|max:255',
            'referrer' => 'nullable|string|max:2048',
            'referrer_host' => 'nullable|string|max:255',
            'device_type' => 'nullable|string|max:20',
            'browser' => 'nullable|string|max:50',
            'os' => 'nullable|string|max:50',
            'screen_w' => 'nullable|integer|min:0|max:10000',
            'screen_h' => 'nullable|integer|min:0|max:10000',
            'language' => 'nullable|string|max:20',
            'timezone' => 'nullable|string|max:60',
            'utm_source' => 'nullable|string|max:255',
            'utm_medium' => 'nullable|string|max:255',
            'utm_campaign' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:2',
            'city' => 'nullable|string|max:255',
        ]);

        $now = now();
        $sessionUuid = $validated['session_uuid'] ?? '';
        if ($sessionUuid === '' || !Str::isUuid($sessionUuid)) {
            $sessionUuid = (string) Str::uuid();
        }

        $session = AnalyticsSession::query()->firstOrCreate(
            ['session_uuid' => $sessionUuid],
            [
                'visitor_id' => $validated['visitor_id'],
                'ip' => substr((string) $request->ip(), 0, 64),
                'country' => $validated['country'] ?? null,
                'city' => $validated['city'] ?? null,
                'device_type' => $validated['device_type'] ?? null,
                'browser' => $validated['browser'] ?? null,
                'os' => $validated['os'] ?? null,
                'referrer_host' => $validated['referrer_host'] ?? null,
                'utm_source' => $validated['utm_source'] ?? null,
                'utm_medium' => $validated['utm_medium'] ?? null,
                'utm_campaign' => $validated['utm_campaign'] ?? null,
                'started_at' => $now,
                'last_seen_at' => $now,
            ]
        );

        $session->fill([
            'last_seen_at' => $now,
            'country' => $session->country ?: ($validated['country'] ?? null),
            'city' => $session->city ?: ($validated['city'] ?? null),
            'device_type' => $session->device_type ?: ($validated['device_type'] ?? null),
            'browser' => $session->browser ?: ($validated['browser'] ?? null),
            'os' => $session->os ?: ($validated['os'] ?? null),
            'referrer_host' => $session->referrer_host ?: ($validated['referrer_host'] ?? null),
            'utm_source' => $session->utm_source ?: ($validated['utm_source'] ?? null),
            'utm_medium' => $session->utm_medium ?: ($validated['utm_medium'] ?? null),
            'utm_campaign' => $session->utm_campaign ?: ($validated['utm_campaign'] ?? null),
        ]);

        if (!$session->started_at) {
            $session->started_at = $now;
        }

        $session->pageviews_count = (int) $session->pageviews_count + 1;
        $session->save();

        AnalyticsPageview::query()->create([
            'analytics_session_id' => $session->id,
            'path' => $validated['path'],
            'full_url' => $validated['full_url'] ?? null,
            'title' => $validated['title'] ?? null,
            'referrer' => $validated['referrer'] ?? null,
            'screen_w' => $validated['screen_w'] ?? null,
            'screen_h' => $validated['screen_h'] ?? null,
            'language' => $validated['language'] ?? null,
            'timezone' => $validated['timezone'] ?? null,
            'viewed_at' => $now,
        ]);

        return response()->json([
            'ok' => true,
            'session_uuid' => $session->session_uuid,
        ]);
    }
}
