@extends('layouts.admin')

@section('content')
<div class="space-y-8 min-h-screen pb-20">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                <i class="ph ph-envelope-simple text-emerald-600"></i>
                Email Gateway (SMTP)
            </h1>
            <p class="text-slate-500 font-medium">Configure SMTP settings and send a test email</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-50">
                <h3 class="text-lg font-black text-slate-900 flex items-center gap-3">
                    <i class="ph ph-gear text-emerald-600"></i>
                    SMTP Configuration
                </h3>
            </div>

            <form method="POST" action="{{ route('admin.settings.email-gateway.update') }}" class="p-8 space-y-6" id="email-gateway-form">
                @csrf

                @if(isset($gateways) && $gateways->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">SMTP Profile</label>
                            <select class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none" onchange="window.location = '{{ route('admin.settings.email-gateway.edit') }}' + '?gateway_id=' + this.value">
                                @foreach($gateways as $g)
                                    <option value="{{ $g->id }}" {{ (int)($settings['gateway_id'] ?? 0) === (int)$g->id ? 'selected' : '' }}>
                                        {{ $g->name }}{{ $g->is_active ? ' (Active)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Active Profile</label>
                            <div class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900">
                                {{ optional($gateways->firstWhere('is_active', true))->name ?? 'None' }}
                            </div>
                        </div>
                    </div>
                @endif

                <input type="hidden" name="gateway_id" value="{{ old('gateway_id', $settings['gateway_id'] ?? '') }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2 space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Profile Name</label>
                        <input type="text" name="gateway_name" id="gateway_name" value="{{ old('gateway_name', $settings['gateway_name'] ?? '') }}" placeholder="e.g. Gmail SMTP" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">SMTP Host</label>
                        <input type="text" name="mail_host" id="mail_host" value="{{ old('mail_host', $settings['mail_host'] ?? '') }}" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">SMTP Port</label>
                        <input type="number" name="mail_port" id="mail_port" value="{{ old('mail_port', $settings['mail_port'] ?? 587) }}" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Username</label>
                        <input type="text" name="mail_username" id="mail_username" value="{{ old('mail_username', $settings['mail_username'] ?? '') }}" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Password</label>
                        <input type="password" name="mail_password" id="mail_password" value="{{ old('mail_password', $settings['mail_password'] ?? '') }}" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Encryption</label>
                        <select name="mail_encryption" id="mail_encryption" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none">
                            @php($enc = old('mail_encryption', $settings['mail_encryption'] ?? 'tls'))
                            <option value="tls" {{ $enc === 'tls' ? 'selected' : '' }}>TLS</option>
                            <option value="ssl" {{ $enc === 'ssl' ? 'selected' : '' }}>SSL</option>
                            <option value="none" {{ $enc === null || $enc === '' || $enc === 'none' ? 'selected' : '' }}>None</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">From Name</label>
                        <input type="text" name="mail_from_name" id="mail_from_name" value="{{ old('mail_from_name', $settings['mail_from_name'] ?? '') }}" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div class="md:col-span-2 space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">From Address</label>
                        <input type="email" name="mail_from_address" id="mail_from_address" value="{{ old('mail_from_address', $settings['mail_from_address'] ?? '') }}" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="pt-4 flex gap-4">
                    <button type="submit" class="flex-1 py-4 bg-emerald-600 text-white font-black text-xs uppercase tracking-widest rounded-xl hover:bg-emerald-700 shadow-xl shadow-emerald-500/20 transition-all">Save SMTP Settings</button>
                </div>

                @php($selected = (isset($gateways) && ($settings['gateway_id'] ?? null))
                    ? $gateways->firstWhere('id', (int) ($settings['gateway_id'] ?? 0))
                    : null)
                @if($selected && !$selected->is_active)
                    <div class="pt-2">
                        <form action="{{ route('admin.settings.email-gateway.activate', $selected->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-3 bg-slate-900 text-white font-black text-xs uppercase tracking-widest rounded-xl hover:bg-slate-800 transition-all">Make Active</button>
                        </form>
                    </div>
                @endif
            </form>
        </div>

        <div class="bg-slate-950 rounded-2xl border border-slate-900 text-slate-50 overflow-hidden">
            <div class="p-8 border-b border-white/5">
                <h3 class="text-lg font-black flex items-center gap-3">
                    <i class="ph ph-paper-plane-tilt text-emerald-400"></i>
                    Send Test Email
                </h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">Uses the form values (no need to save first)</p>
            </div>

            <div class="p-8 space-y-5">
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">To</label>
                    <input type="email" id="test_to" placeholder="you@example.com" class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl text-sm font-bold text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Subject</label>
                    <input type="text" id="test_subject" value="SMTP Test - LAU Paradise" class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl text-sm font-bold text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Message</label>
                    <textarea id="test_message" rows="4" class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl text-sm font-bold text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">Hello, this is a test email from LAU Paradise admin.</textarea>
                </div>

                <button type="button" id="btn-send-test" class="w-full py-4 bg-emerald-600 text-white font-black text-xs uppercase tracking-widest rounded-xl hover:bg-emerald-700 shadow-xl shadow-emerald-500/20 transition-all flex items-center justify-center gap-2">
                    <i class="ph ph-paper-plane-tilt"></i>
                    Send Test Email
                </button>

                <pre id="test-output" class="w-full p-6 bg-black/40 rounded-2xl text-xs overflow-auto min-h-[220px]">{
  "status": "waiting"
}</pre>
            </div>
        </div>
    </div>
</div>

<script>
    function smtpPayload() {
        const enc = document.getElementById('mail_encryption').value;
        return {
            mail_host: document.getElementById('mail_host').value,
            mail_port: document.getElementById('mail_port').value,
            mail_username: document.getElementById('mail_username').value,
            mail_password: document.getElementById('mail_password').value,
            mail_encryption: (enc === 'none') ? 'none' : enc,
            mail_from_address: document.getElementById('mail_from_address').value,
            mail_from_name: document.getElementById('mail_from_name').value,
        };
    }

    document.getElementById('btn-send-test').addEventListener('click', async function () {
        const out = document.getElementById('test-output');
        out.innerText = JSON.stringify({ status: 'sending' }, null, 2);

        const p = smtpPayload();
        const to = document.getElementById('test_to').value;
        const subject = document.getElementById('test_subject').value;
        const message = document.getElementById('test_message').value;

        try {
            const resp = await fetch(`{{ route('admin.settings.email-gateway.test') }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    ...p,
                    to,
                    subject,
                    message,
                }),
            });

            const data = await resp.json();
            out.innerText = JSON.stringify({ http_status: resp.status, ...data }, null, 2);
        } catch (e) {
            out.innerText = JSON.stringify({ error: (e && e.message) ? e.message : 'Unknown error' }, null, 2);
        }
    });
</script>
@endsection
