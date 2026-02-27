<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsPageview;
use App\Models\AnalyticsSession;
use Illuminate\Http\Request;

class RealtimeAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $activeWindowMinutes = 5;
        $activeSince = now()->subMinutes($activeWindowMinutes);

        $activeSessions = AnalyticsSession::query()
            ->whereNotNull('last_seen_at')
            ->where('last_seen_at', '>=', $activeSince)
            ->orderByDesc('last_seen_at')
            ->limit(200)
            ->get();

        $activeUsersNow = $activeSessions->count();

        $todayStart = now()->startOfDay();

        $visitorsToday = AnalyticsSession::query()
            ->whereNotNull('started_at')
            ->where('started_at', '>=', $todayStart)
            ->count();

        $pageviewsToday = AnalyticsPageview::query()
            ->where('viewed_at', '>=', $todayStart)
            ->count();

        $topPagesToday = AnalyticsPageview::query()
            ->selectRaw('path, COUNT(*) as c')
            ->where('viewed_at', '>=', $todayStart)
            ->groupBy('path')
            ->orderByDesc('c')
            ->limit(10)
            ->get();

        $recentPageviews = AnalyticsPageview::query()
            ->with(['session'])
            ->orderByDesc('viewed_at')
            ->limit(50)
            ->get();

        $countryActive = $activeSessions
            ->groupBy(fn ($s) => $s->country ?: '??')
            ->map(fn ($group) => $group->count())
            ->sortDesc();

        return view('admin.analytics.realtime', compact(
            'activeWindowMinutes',
            'activeUsersNow',
            'visitorsToday',
            'pageviewsToday',
            'topPagesToday',
            'recentPageviews',
            'countryActive'
        ));
    }

    public function api(Request $request)
    {
        $activeWindowMinutes = 5;
        $activeSince = now()->subMinutes($activeWindowMinutes);

        $activeSessions = AnalyticsSession::query()
            ->whereNotNull('last_seen_at')
            ->where('last_seen_at', '>=', $activeSince)
            ->orderByDesc('last_seen_at')
            ->limit(200)
            ->get();

        $recentPageviews = AnalyticsPageview::query()
            ->with(['session'])
            ->orderByDesc('viewed_at')
            ->limit(30)
            ->get();

        $countryActive = $activeSessions
            ->groupBy(fn ($s) => $s->country ?: '??')
            ->map(fn ($group) => $group->count())
            ->sortDesc();

        return response()->json([
            'active_window_minutes' => $activeWindowMinutes,
            'active_users_now' => $activeSessions->count(),
            'active_countries' => $countryActive,
            'sessions' => $activeSessions->map(function ($s) {
                return [
                    'session_uuid' => $s->session_uuid,
                    'last_seen_at' => optional($s->last_seen_at)->toIso8601String(),
                    'country' => $s->country,
                    'city' => $s->city,
                    'latitude' => $s->latitude,
                    'longitude' => $s->longitude,
                    'device_type' => $s->device_type,
                    'browser' => $s->browser,
                    'os' => $s->os,
                    'pageviews_count' => (int) $s->pageviews_count,
                ];
            })->values(),
            'recent_pageviews' => $recentPageviews->map(function ($pv) {
                return [
                    'viewed_at' => optional($pv->viewed_at)->toIso8601String(),
                    'path' => $pv->path,
                    'title' => $pv->title,
                    'country' => $pv->session?->country,
                    'city' => $pv->session?->city,
                    'device_type' => $pv->session?->device_type,
                ];
            })->values(),
        ]);
    }
}
