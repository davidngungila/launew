@extends('layouts.admin')

@section('content')
<div class="space-y-8 min-h-screen pb-20">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.settings.sms-gateway.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-emerald-600 transition-all">
                    <i class="ph ph-arrow-left"></i>
                </a>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                    <i class="ph ph-plus-circle text-emerald-600"></i>
                    New SMS Provider
                </h1>
            </div>
            <p class="text-slate-500 font-medium mt-2">Verify credentials and send a test SMS before saving the provider</p>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" id="btn-draft-verify" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 font-black rounded-xl hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-200 transition-all flex items-center gap-2">
                <i class="ph ph-wifi-high"></i>
                Verify Credentials
            </button>
            <button type="button" id="btn-draft-test" class="px-6 py-3 bg-slate-900 text-white font-black rounded-xl hover:bg-slate-800 transition-all flex items-center gap-2">
                <i class="ph ph-paper-plane-tilt"></i>
                Test SMS
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-50">
                <h3 class="text-lg font-black text-slate-900 flex items-center gap-3">
                    <i class="ph ph-gear text-emerald-600"></i>
                    Provider Details
                </h3>
            </div>

            <form id="provider-create-form" method="POST" action="{{ route('admin.settings.sms-gateway.store') }}" class="p-8 space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2 space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Provider Name</label>
                        <input type="text" name="name" id="name" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Sender ID (From)</label>
                        <input type="text" name="sms_from" id="sms_from" required value="LAUPARADISE" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">HTTP Method</label>
                        <select name="sms_method" id="sms_method" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none">
                            <option value="post" {{ ($defaults['sms_method'] ?? 'post') === 'post' ? 'selected' : '' }}>POST</option>
                            <option value="get" {{ ($defaults['sms_method'] ?? 'post') === 'get' ? 'selected' : '' }}>GET</option>
                        </select>
                    </div>

                    <div class="md:col-span-2 space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">API Endpoint URL</label>
                        <input type="url" name="sms_url" id="sms_url" required value="{{ $defaults['sms_url'] ?? '' }}" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest pl-1">Recommended: https://messaging-service.co.tz/api/sms/v2/text/single</p>
                    </div>

                    <div class="md:col-span-2 space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Bearer Token (Recommended)</label>
                        <input type="password" name="sms_bearer_token" id="sms_bearer_token" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900" placeholder="Bearer token">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Username / Key</label>
                        <input type="text" name="sms_username" id="sms_username" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Password / Secret</label>
                        <input type="password" name="sms_password" id="sms_password" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Priority</label>
                        <input type="number" name="priority" id="priority" value="{{ $defaults['priority'] ?? 0 }}" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900" placeholder="0">
                    </div>

                    <div class="md:col-span-2 space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Notes</label>
                        <textarea name="notes" id="notes" rows="3" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900" placeholder="Optional notes"></textarea>
                    </div>

                    <div class="md:col-span-2 flex flex-wrap gap-3">
                        <label class="inline-flex items-center gap-2 px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl">
                            <input type="checkbox" name="is_primary" id="is_primary" value="1" {{ ($defaults['is_primary'] ?? false) ? 'checked' : '' }}>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-600">Set as Primary</span>
                        </label>
                        <label class="inline-flex items-center gap-2 px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ ($defaults['is_active'] ?? true) ? 'checked' : '' }}>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-600">Active</span>
                        </label>
                    </div>
                </div>

                <div class="pt-4 flex gap-4">
                    <a href="{{ route('admin.settings.sms-gateway.index') }}" class="flex-1 py-4 bg-slate-100 text-slate-500 font-black text-xs uppercase tracking-widest rounded-xl hover:bg-slate-200 transition-all text-center">Cancel</a>
                    <button type="submit" class="flex-1 py-4 bg-emerald-600 text-white font-black text-xs uppercase tracking-widest rounded-xl hover:bg-emerald-700 shadow-xl shadow-emerald-500/20 transition-all">Save Provider</button>
                </div>
            </form>
        </div>

        <div class="bg-slate-950 rounded-2xl border border-slate-900 text-slate-50 overflow-hidden">
            <div class="p-8 border-b border-white/5">
                <h3 class="text-lg font-black flex items-center gap-3">
                    <i class="ph ph-terminal-window text-emerald-400"></i>
                    Live Test Output
                </h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">This uses draft inputs only (no save required)</p>
            </div>

            <div class="p-8 space-y-6">
                <div class="space-y-3">
                    <div class="grid grid-cols-1 gap-3">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">To (phone)</label>
                            <input type="text" id="draft_to" placeholder="2557XXXXXXXX" class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl text-sm font-bold text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Message</label>
                            <textarea id="draft_message" rows="4" placeholder="Hello from LAU Paradise" class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl text-sm font-bold text-white focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                        </div>
                    </div>
                </div>

                <pre id="draft-output" class="w-full p-6 bg-black/40 rounded-2xl text-xs overflow-auto min-h-[260px]">{
  "status": "waiting"
}</pre>

                <div class="grid grid-cols-1 gap-3">
                    <button type="button" id="btn-draft-verify-2" class="w-full py-4 bg-white border border-white/10 text-slate-900 font-black text-xs uppercase tracking-widest rounded-xl hover:bg-emerald-50 transition-all flex items-center justify-center gap-2">
                        <i class="ph ph-wifi-high"></i>
                        Verify Credentials
                    </button>
                    <button type="button" id="btn-draft-test-2" class="w-full py-4 bg-emerald-600 text-white font-black text-xs uppercase tracking-widest rounded-xl hover:bg-emerald-700 shadow-xl shadow-emerald-500/20 transition-all flex items-center justify-center gap-2">
                        <i class="ph ph-paper-plane-tilt"></i>
                        Send Test SMS
                    </button>
                </div>

                <div class="p-5 bg-white/5 rounded-2xl border border-white/5">
                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tip</div>
                    <div class="text-xs font-bold text-slate-200">Use Bearer token + Sender ID. Verify first, then send test SMS. After you see a successful response, save the provider.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function draftPayload() {
        return {
            name: document.getElementById('name').value,
            sms_from: document.getElementById('sms_from').value,
            sms_url: document.getElementById('sms_url').value,
            sms_method: document.getElementById('sms_method').value,
            sms_bearer_token: document.getElementById('sms_bearer_token').value,
            sms_username: document.getElementById('sms_username').value,
            sms_password: document.getElementById('sms_password').value,
        };
    }

    async function draftVerify() {
        const out = document.getElementById('draft-output');
        out.innerText = JSON.stringify({ status: 'verifying' }, null, 2);

        const payload = draftPayload();
        try {
            const resp = await fetch(`{{ route('admin.settings.sms-gateway.draft.testConnection') }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    sms_bearer_token: payload.sms_bearer_token,
                    sms_username: payload.sms_username,
                    sms_password: payload.sms_password,
                })
            });
            const data = await resp.json();
            out.innerText = JSON.stringify({ http_status: resp.status, ...data }, null, 2);
        } catch (e) {
            out.innerText = JSON.stringify({ error: e?.message || 'Unknown error' }, null, 2);
        }
    }

    async function draftTestSms() {
        const out = document.getElementById('draft-output');
        out.innerText = JSON.stringify({ status: 'sending' }, null, 2);

        const payload = draftPayload();
        const to = document.getElementById('draft_to').value;
        const message = document.getElementById('draft_message').value;

        try {
            const resp = await fetch(`{{ route('admin.settings.sms-gateway.draft.testSms') }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    sms_from: payload.sms_from,
                    sms_url: payload.sms_url,
                    sms_method: payload.sms_method,
                    sms_bearer_token: payload.sms_bearer_token,
                    sms_username: payload.sms_username,
                    sms_password: payload.sms_password,
                    to,
                    message,
                })
            });
            const data = await resp.json();
            out.innerText = JSON.stringify({ http_status: resp.status, ...data }, null, 2);
        } catch (e) {
            out.innerText = JSON.stringify({ error: e?.message || 'Unknown error' }, null, 2);
        }
    }

    document.getElementById('btn-draft-verify').addEventListener('click', draftVerify);
    document.getElementById('btn-draft-test').addEventListener('click', draftTestSms);
    document.getElementById('btn-draft-verify-2').addEventListener('click', draftVerify);
    document.getElementById('btn-draft-test-2').addEventListener('click', draftTestSms);
</script>
@endsection
