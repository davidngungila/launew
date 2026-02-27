@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Analytics Map</h1>
            <p class="text-slate-500 font-medium">Country heatmap + city dots (activates after GeoLite2 setup)</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.analytics.realtime') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl text-xs font-black hover:bg-slate-50">Back to Realtime</a>
            <div class="px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl text-xs font-black">Live</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="lg:col-span-3 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between">
                <h3 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Live Visitor Map</h3>
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Auto refresh</div>
            </div>
            <div class="p-6">
                <div class="rounded-2xl border border-slate-100 bg-slate-50 overflow-hidden" style="height: 520px;">
                    <div id="rt-map-full" class="w-full h-full"></div>
                </div>
                <div id="rt-map-error" class="hidden mt-4 text-sm font-bold text-rose-700 bg-rose-50 border border-rose-100 rounded-xl px-4 py-3"></div>
                <div class="mt-4 text-[11px] text-slate-500 font-bold leading-relaxed">
                    City dots appear automatically after GeoLite2 is installed + configured and sessions have latitude/longitude.
                </div>
            </div>
        </div>

        <div class="space-y-6">
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

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-50">
                    <h3 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">GeoLite2 Status</h3>
                </div>
                <div class="p-8 space-y-2">
                    <div class="text-xs font-black text-slate-700">Env</div>
                    <div class="text-[11px] font-bold text-slate-500 break-all">GEOIP2_CITY_DB_PATH={{ env('GEOIP2_CITY_DB_PATH') }}</div>
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

    function showError(msg) {
        const el = document.getElementById('rt-map-error');
        if (!el) return;
        el.textContent = msg;
        el.classList.remove('hidden');
    }

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
        const el = document.getElementById('rt-map-full');
        if (!el) return;

        if (typeof jsVectorMap === 'undefined') {
            showError('Map library failed to load (jsVectorMap). Check network or CSP.');
            return;
        }

        const values = normalizeCountryValues(initialCountryCounts);

        map = new jsVectorMap({
            selector: '#rt-map-full',
            map: 'world_merc',
            zoomButtons: true,
            zoomOnScroll: true,
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
            .slice(0, 500)
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

    async function refresh() {
        try {
            const res = await fetch(apiUrl, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) return;
            const data = await res.json();

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
