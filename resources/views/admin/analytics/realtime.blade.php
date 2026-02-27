@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Real-Time Analytics</h1>
            <p class="text-slate-500 font-medium">Live website tracking (no Google Analytics)</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl text-xs font-black">Live</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Active users (last {{ $activeWindowMinutes }} min)</div>
            <div id="rt-active-users" class="mt-3 text-3xl font-black text-slate-900">{{ $activeUsersNow }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Visitors today</div>
            <div class="mt-3 text-3xl font-black text-slate-900">{{ $visitorsToday }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Pageviews today</div>
            <div class="mt-3 text-3xl font-black text-slate-900">{{ $pageviewsToday }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Map</div>
            <div class="mt-3 rounded-xl border border-slate-100 bg-slate-50 overflow-hidden" style="height: 120px;">
                <div id="rt-world-map" class="w-full h-full"></div>
            </div>
            <div class="mt-3 text-[11px] text-slate-500 font-bold leading-relaxed">
                City-level map will activate after GeoLite2 setup.
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between">
                <h3 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Live Pageviews</h3>
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Auto refresh</div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="text-left px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Time</th>
                            <th class="text-left px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Path</th>
                            <th class="text-left px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Location</th>
                            <th class="text-left px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Device</th>
                        </tr>
                    </thead>
                    <tbody id="rt-pageviews">
                        @foreach($recentPageviews as $pv)
                            <tr class="border-t border-slate-50">
                                <td class="px-8 py-4 text-xs font-bold text-slate-500">{{ $pv->viewed_at?->format('H:i:s') }}</td>
                                <td class="px-8 py-4">
                                    <div class="font-black text-slate-900">{{ $pv->path }}</div>
                                    <div class="text-xs text-slate-400 font-bold">{{ $pv->title }}</div>
                                </td>
                                <td class="px-8 py-4 text-xs font-bold text-slate-500">{{ $pv->session?->country }} {{ $pv->session?->city }}</td>
                                <td class="px-8 py-4 text-xs font-bold text-slate-500">{{ $pv->session?->device_type }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-50">
                    <h3 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Top Pages Today</h3>
                </div>
                <div class="p-8 space-y-4">
                    @foreach($topPagesToday as $row)
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-black text-slate-900">{{ $row->path }}</div>
                            <div class="text-xs font-black text-emerald-700">{{ (int) $row->c }}</div>
                        </div>
                    @endforeach
                    @if($topPagesToday->count() === 0)
                        <div class="text-sm text-slate-500 font-medium">No data yet.</div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-50">
                    <h3 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Active Countries</h3>
                </div>
                <div class="p-8 space-y-3">
                    @foreach($countryActive as $country => $count)
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-black text-slate-900">{{ $country }}</div>
                            <div class="text-xs font-black text-slate-600">{{ $count }}</div>
                        </div>
                    @endforeach
                    @if($countryActive->count() === 0)
                        <div class="text-sm text-slate-500 font-medium">No active users right now.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world-merc.js"></script>
<script>
(function () {
    const apiUrl = @json(route('admin.analytics.realtime.api'));
    const initialCountryCounts = @json($countryActive);

    let map = null;

    function normalizeCountryValues(obj) {
        const out = {};
        if (!obj) return out;
        Object.keys(obj).forEach(function (k) {
            if (!k) return;
            if (k === '??') return;
            out[String(k).toUpperCase()] = Number(obj[k] || 0);
        });
        return out;
    }

    function initMap() {
        const el = document.getElementById('rt-world-map');
        if (!el || typeof jsVectorMap === 'undefined') return;

        const values = normalizeCountryValues(initialCountryCounts);

        map = new jsVectorMap({
            selector: '#rt-world-map',
            map: 'world_merc',
            zoomButtons: false,
            zoomOnScroll: false,
            regionStyle: {
                initial: {
                    fill: '#e2e8f0',
                    stroke: '#ffffff',
                    strokeWidth: 0.5,
                },
                hover: {
                    fill: '#a7f3d0',
                },
            },
            series: {
                regions: [
                    {
                        values: values,
                        scale: ['#d1fae5', '#059669'],
                        normalizeFunction: 'polynomial',
                    }
                ]
            },
            markerStyle: {
                initial: {
                    fill: '#0f766e',
                    stroke: '#ffffff',
                    strokeWidth: 1,
                    r: 4,
                },
                hover: {
                    fill: '#10b981',
                }
            },
            onRegionTooltipShow: function (tooltip, code) {
                const c = values[code] || 0;
                tooltip.text(tooltip.text() + ' — ' + c + ' active');
            }
        });
    }

    function updateMap(countryCounts) {
        if (!map || !map.series || !map.series.regions || !map.series.regions[0]) return;
        const values = normalizeCountryValues(countryCounts);
        map.series.regions[0].setValues(values);
    }

    function updateMarkersFromSessions(sessions) {
        if (!map || !sessions || !Array.isArray(sessions)) return;

        const markers = sessions
            .filter(s => typeof s.latitude === 'number' && typeof s.longitude === 'number')
            .slice(0, 200)
            .map(function (s) {
                const name = [s.country, s.city, s.device_type].filter(Boolean).join(' ');
                return {
                    name: name,
                    coords: [s.latitude, s.longitude]
                };
            });

        try {
            if (typeof map.removeMarkers === 'function') {
                map.removeMarkers();
            } else if (Array.isArray(map.markers) && typeof map.clearSelectedMarkers === 'function') {
                map.clearSelectedMarkers();
            }
        } catch (e) {
        }

        try {
            if (typeof map.addMarkers === 'function') {
                map.addMarkers(markers);
            }
        } catch (e) {
        }
    }

    function escapeHtml(str) {
        return String(str || '').replace(/[&<>"']/g, function (m) {
            return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#39;'}[m]);
        });
    }

    async function refresh() {
        try {
            const res = await fetch(apiUrl, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) return;
            const data = await res.json();

            const activeEl = document.getElementById('rt-active-users');
            if (activeEl) activeEl.textContent = data.active_users_now;

            const tbody = document.getElementById('rt-pageviews');
            if (tbody && Array.isArray(data.recent_pageviews)) {
                tbody.innerHTML = data.recent_pageviews.map(pv => {
                    const d = pv.viewed_at ? new Date(pv.viewed_at) : null;
                    const t = d ? d.toLocaleTimeString() : '';
                    const loc = [pv.country, pv.city].filter(Boolean).join(' ');
                    return `
                        <tr class="border-t border-slate-50">
                            <td class="px-8 py-4 text-xs font-bold text-slate-500">${escapeHtml(t)}</td>
                            <td class="px-8 py-4">
                                <div class="font-black text-slate-900">${escapeHtml(pv.path)}</div>
                                <div class="text-xs text-slate-400 font-bold">${escapeHtml(pv.title)}</div>
                            </td>
                            <td class="px-8 py-4 text-xs font-bold text-slate-500">${escapeHtml(loc)}</td>
                            <td class="px-8 py-4 text-xs font-bold text-slate-500">${escapeHtml(pv.device_type)}</td>
                        </tr>
                    `;
                }).join('');
            }

            if (data && data.active_countries) {
                updateMap(data.active_countries);
            }

            if (data && data.sessions) {
                updateMarkersFromSessions(data.sessions);
            }
        } catch (e) {
            // silent
        }
    }

    initMap();
    setInterval(refresh, 5000);
})();
</script>
@endpush
@endsection
