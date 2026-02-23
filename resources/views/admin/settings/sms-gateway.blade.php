@extends('layouts.admin')

@section('content')
<div class="space-y-8 min-h-screen pb-20">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                <i class="ph ph-chat-circle-dots text-emerald-600"></i>
                SMS Gateway Management
            </h1>
            <p class="text-slate-500 font-medium">Manage multiple SMS providers, test connections, and configure fallback settings</p>
        </div>
        <button type="button" class="px-6 py-3 bg-emerald-600 text-white font-black rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2" onclick="openAddModal()">
            <i class="ph ph-plus-bold"></i>
            Add New Provider
        </button>
    </div>

    <!-- Main Content Area -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <!-- Tabs Header -->
        <div class="px-8 pt-8 border-b border-slate-50">
            <div class="flex items-center gap-8 overflow-x-auto no-scrollbar">
                <button onclick="switchTab('providers')" id="btn-providers" class="tab-btn active pb-4 text-sm font-black uppercase tracking-widest transition-all relative">
                    Providers
                    <span class="ml-2 px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded-lg text-[10px]">{{ $providers->count() }}</span>
                </button>
                <button onclick="switchTab('settings')" id="btn-settings" class="tab-btn pb-4 text-sm font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition-all relative">
                    Fallback Settings
                </button>
                <button onclick="switchTab('test')" id="btn-test" class="tab-btn pb-4 text-sm font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition-all relative">
                    Quick Test
                </button>
                <button onclick="switchTab('info')" id="btn-info" class="tab-btn pb-4 text-sm font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition-all relative">
                    Information
                </button>
            </div>
        </div>

        <div class="p-8">
            <!-- Providers Tab -->
            <div id="tab-providers" class="tab-content transition-all duration-300">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($providers as $provider)
                    <div class="group relative bg-slate-50 rounded-2xl border-2 border-transparent hover:border-emerald-500/50 transition-all p-8 {{ $provider->is_primary ? 'ring-2 ring-emerald-500 ring-offset-4' : '' }}" id="provider-card-{{ $provider->id }}">
                        <!-- Checking Overlay (Requested Animation) -->
                        <div id="checking-{{ $provider->id }}" class="checking-overlay hidden">
                            <div class="slash-scan"></div>
                            <div class="text-center">
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600 mb-2">Verifying Credentials</p>
                                <div class="count-text" id="count-{{ $provider->id }}">0%</div>
                                <p class="text-[9px] font-bold text-slate-400 mt-2 uppercase tracking-widest">Scanning SMS Gateway API...</p>
                            </div>
                        </div>

                        <div class="flex justify-between items-start mb-6">
                            <div class="flex items-center gap-2">
                                @if($provider->is_primary)
                                <span class="px-3 py-1 bg-emerald-600 text-white text-[9px] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-emerald-500/20">Primary</span>
                                @endif
                                @if(!$provider->is_active)
                                <span class="px-3 py-1 bg-slate-200 text-slate-500 text-[9px] font-black uppercase tracking-widest rounded-xl">Inactive</span>
                                @endif
                            </div>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false" class="w-8 h-8 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-emerald-600 transition-all">
                                    <i class="ph ph-dots-three-vertical-bold"></i>
                                </button>
                                <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 z-20">
                                    <button onclick="editProvider({{ $provider->id }})" class="w-full text-left px-5 py-2 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-all flex items-center gap-2">
                                        <i class="ph ph-note-pencil"></i> Edit Details
                                    </button>
                                    @if(!$provider->is_primary)
                                    <button onclick="setPrimary({{ $provider->id }})" class="w-full text-left px-5 py-2 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-all flex items-center gap-2">
                                        <i class="ph ph-star"></i> Set Primary
                                    </button>
                                    @endif
                                    <button onclick="toggleActive({{ $provider->id }})" class="w-full text-left px-5 py-2 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-all flex items-center gap-2">
                                        <i class="ph ph-{{ $provider->is_active ? 'eye-slash' : 'eye' }}"></i> 
                                        {{ $provider->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                    <div class="border-t border-slate-50 my-1"></div>
                                    <button onclick="deleteProvider({{ $provider->id }})" class="w-full text-left px-5 py-2 text-xs font-bold text-red-500 hover:bg-red-50 transition-all flex items-center gap-2">
                                        <i class="ph ph-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>

                        <h4 class="text-xl font-black text-slate-900 mb-1">{{ $provider->name }}</h4>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-6">{{ $provider->sms_method }} Method</p>

                        <div class="space-y-3 mb-8">
                            <div class="flex justify-between items-center px-4 py-2 bg-white rounded-xl border border-slate-100">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Sender ID</span>
                                <span class="text-xs font-black text-slate-900">{{ $provider->sms_from }}</span>
                            </div>
                            <div class="flex justify-between items-center px-4 py-2 bg-white rounded-xl border border-slate-100">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</span>
                                <div class="flex items-center gap-2">
                                    <div class="w-1.5 h-1.5 rounded {{ $provider->connection_status === 'connected' ? 'bg-emerald-500 animate-pulse' : 'bg-red-500' }}"></div>
                                    <span class="text-xs font-black text-slate-900 capitalize">{{ $provider->connection_status }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <button onclick="startConnectionTest({{ $provider->id }})" class="py-3 bg-white border border-slate-200 text-slate-700 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-200 transition-all flex items-center justify-center gap-2">
                                <i class="ph ph-wifi-high"></i> Verify
                            </button>
                            <button onclick="openTestSmsModal({{ $provider->id }})" class="py-3 bg-emerald-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-600/10 transition-all flex items-center justify-center gap-2">
                                <i class="ph ph-paper-plane-tilt"></i> Test SMS
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <i class="ph ph-sidebar text-3xl text-slate-300"></i>
                        </div>
                        <h4 class="text-xl font-black text-slate-900 mb-2">No Providers Defined</h4>
                        <p class="text-slate-400 font-medium mb-8">You haven't added any SMS gateway providers yet.</p>
                        <button onclick="openAddModal()" class="px-8 py-3 bg-emerald-600 text-white font-black rounded-xl shadow-xl shadow-emerald-500/20">Add First Provider</button>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Settings Tab -->
            <div id="tab-settings" class="tab-content hidden space-y-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="p-8 bg-slate-50 rounded-2xl border border-slate-100">
                        <h4 class="text-lg font-black text-slate-900 mb-6 flex items-center gap-3">
                            <i class="ph ph-database text-emerald-500"></i> Database Fallbacks
                        </h4>
                        <div class="space-y-4">
                            @foreach(['Username' => 'sms_username', 'From' => 'sms_from', 'URL' => 'sms_url'] as $label => $key)
                            <div class="flex justify-between items-center px-6 py-4 bg-white rounded-2xl border border-slate-100">
                                <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest">{{ $label }}</span>
                                <span class="text-sm font-bold text-slate-900">{{ $fallbackSettings[$key] ?: 'Not configured' }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="p-8 bg-slate-900 rounded-2xl text-white">
                        <h4 class="text-lg font-black mb-6 flex items-center gap-3">
                            <i class="ph ph-terminal-window text-emerald-400"></i> Environment Variables
                        </h4>
                        <div class="space-y-4">
                             @foreach(['SMS_USERNAME' => env('SMS_USERNAME'), 'SMS_FROM' => env('SMS_FROM'), 'SMS_URL' => env('SMS_URL')] as $key => $val)
                            <div class="flex justify-between items-center px-6 py-4 bg-white/5 rounded-2xl border border-white/5">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $key }}</span>
                                <code class="text-xs text-emerald-400">{{ $val ? '********' : 'NULL' }}</code>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Test Tab -->
            <div id="tab-test" class="tab-content hidden space-y-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="p-8 bg-slate-50 rounded-2xl border border-slate-100">
                        <h4 class="text-lg font-black text-slate-900 mb-6 flex items-center gap-3">
                            <i class="ph ph-paper-plane-tilt text-emerald-500"></i> Send Test SMS
                        </h4>

                        <form id="quick-test-form" class="space-y-5">
                            @csrf
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">To (phone)</label>
                                <input type="text" name="to" id="test_to" placeholder="2557XXXXXXXX" class="w-full px-5 py-3 bg-white border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Message</label>
                                <textarea name="message" id="test_message" rows="4" class="w-full px-5 py-3 bg-white border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Hello from LAU Paradise"></textarea>
                            </div>

                            <button type="submit" class="w-full py-4 bg-emerald-600 text-white font-black text-xs uppercase tracking-widest rounded-xl hover:bg-emerald-700 shadow-xl shadow-emerald-500/20 transition-all flex items-center justify-center gap-2">
                                <i class="ph ph-paper-plane-tilt"></i>
                                Send Test
                            </button>
                        </form>
                    </div>

                    <div class="p-8 bg-slate-950 rounded-2xl border border-slate-900 text-slate-50">
                        <h4 class="text-lg font-black mb-6 flex items-center gap-3">
                            <i class="ph ph-terminal-window text-emerald-400"></i> API Response
                        </h4>
                        <pre id="quick-test-response" class="w-full p-6 bg-black/40 rounded-2xl text-xs overflow-auto min-h-[220px]">{
  "status": "waiting"
}</pre>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-4">Tip: Configure a Primary provider with Sender ID and Bearer token, then run a test.</p>
                    </div>
                </div>
            </div>

            <!-- Info Tab -->
            <div id="tab-info" class="tab-content hidden space-y-8">
                <div class="p-8 bg-slate-50 rounded-2xl border border-slate-100">
                    <h4 class="text-lg font-black text-slate-900 mb-4 flex items-center gap-3">
                        <i class="ph ph-info text-emerald-500"></i> Messaging Service API V2
                    </h4>
                    <div class="space-y-2 text-sm font-medium text-slate-600">
                        <div><span class="font-black">Base URL:</span> https://messaging-service.co.tz</div>
                        <div><span class="font-black">Balance:</span> GET /api/v2/balance</div>
                        <div><span class="font-black">Test SMS:</span> POST /api/sms/v2/test/text/single</div>
                        <div><span class="font-black">Send SMS:</span> POST /api/sms/v2/text/single</div>
                        <div><span class="font-black">Auth:</span> Bearer token (recommended) or Basic</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Provider Modal (Simplified for the scanning demo) -->
<div x-data="{ isOpen: false }" id="provider-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-6 hidden">
    <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm" onclick="closeModal()"></div>
    <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="p-8 pb-0 flex justify-between items-center">
            <h3 class="text-2xl font-black text-slate-900" id="modal-title">New SMS Provider</h3>
            <button onclick="closeModal()" class="w-10 h-10 bg-slate-50 text-slate-400 rounded-xl flex items-center justify-center hover:bg-rose-50 hover:text-rose-500 transition-all">
                <i class="ph ph-x text-2xl"></i>
            </button>
        </div>
        
        <form id="main-provider-form" class="p-8 space-y-6">
            @csrf
            <input type="hidden" name="id" id="provider_id">
            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2 space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Provider Name</label>
                    <input type="text" name="name" id="name" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Username / Key</label>
                    <input type="text" name="sms_username" id="sms_username" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Password / Secret</label>
                    <input type="password" name="sms_password" id="sms_password" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900">
                </div>
                <div class="col-span-2 space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Bearer Token (Recommended)</label>
                    <input type="password" name="sms_bearer_token" id="sms_bearer_token" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900" placeholder="Bearer token">
                </div>
                 <div class="col-span-2 space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">API Endpoint URL</label>
                    <input type="url" name="sms_url" id="sms_url" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Sender ID (From)</label>
                    <input type="text" name="sms_from" id="sms_from" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">HTTP Method</label>
                    <select name="sms_method" id="sms_method" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none">
                        <option value="post">POST</option>
                        <option value="get">GET</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Priority</label>
                    <input type="number" name="priority" id="priority" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900" placeholder="0">
                </div>
                <div class="col-span-2 space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Notes</label>
                    <textarea name="notes" id="notes" rows="3" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900" placeholder="Optional notes"></textarea>
                </div>
                <div class="col-span-2 flex flex-wrap gap-3">
                    <label class="inline-flex items-center gap-2 px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl">
                        <input type="checkbox" name="is_primary" id="is_primary" value="1">
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-600">Set as Primary</span>
                    </label>
                    <label class="inline-flex items-center gap-2 px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl">
                        <input type="checkbox" name="is_active" id="is_active" value="1" checked>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-600">Active</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 flex gap-4">
                <button type="button" onclick="closeModal()" class="flex-1 py-4 bg-slate-100 text-slate-500 font-black text-xs uppercase tracking-widest rounded-xl hover:bg-slate-200 transition-all">Cancel</button>
                <button type="submit" class="flex-1 py-4 bg-emerald-600 text-white font-black text-xs uppercase tracking-widest rounded-xl hover:bg-emerald-700 shadow-xl shadow-emerald-500/20 transition-all">Save Provider</button>
            </div>
        </form>
    </div>
</div>

<style>
    .tab-btn.active { color: #059669; }
    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; width: 100%; height: 3px;
        background: #059669;
        border-radius: 10px;
    }

    /* Requested Scanning Animation */
    .checking-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255, 255, 255, 0.95);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 50;
        border-radius: 1rem;
        overflow: hidden;
    }

    .slash-scan {
        position: absolute;
        top: -100%; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, transparent, #10b981, transparent);
        box-shadow: 0 0 20px #10b981;
        animation: scanline 2s cubic-bezier(0.45, 0.05, 0.55, 0.95) infinite;
    }

    @keyframes scanline {
        0% { top: -10%; }
        50% { top: 110%; }
        100% { top: -10%; }
    }

    .count-text {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        font-weight: 900;
        color: #064e3b;
        letter-spacing: -0.05em;
    }

    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>

<script>
    const PROVIDERS = @json($providers->values());

    function switchTab(tab) {
        document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
        document.getElementById('tab-' + tab).classList.remove('hidden');
        
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.remove('active', 'text-emerald-600');
            b.classList.add('text-slate-400');
        });
        document.getElementById('btn-' + tab).classList.add('active', 'text-emerald-600');
    }

    function openAddModal() {
        document.getElementById('modal-title').innerText = 'New SMS Provider';
        document.getElementById('main-provider-form').reset();
        document.getElementById('provider_id').value = '';
        document.getElementById('sms_method').value = 'post';
        document.getElementById('is_active').checked = true;
        document.getElementById('sms_url').value = 'https://messaging-service.co.tz/api/sms/v2/text/single';
        document.getElementById('provider-modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('provider-modal').classList.add('hidden');
    }

    // Requested Connection Test with Animation
    async function startConnectionTest(id) {
        const overlay = document.getElementById('checking-' + id);
        const countTxt = document.getElementById('count-' + id);
        overlay.classList.remove('hidden');
        
        // Start counter
        let count = 0;
        const interval = setInterval(() => {
            count += Math.floor(Math.random() * 15) + 1;
            if (count >= 100) {
                count = 100;
                clearInterval(interval);
                finishTest(id);
            }
            countTxt.innerText = count + '%';
        }, 150);
    }

    async function finishTest(id) {
        try {
            const response = await fetch(`{{ route('admin.settings.sms-gateway.testConnection', ':id') }}`.replace(':id', id), {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            });
            const data = await response.json();

            const ok = response.ok && data && data.success;
            const overlay = document.getElementById('checking-' + id);
            const icon = ok ? 'ph-check-circle' : 'ph-x-circle';
            const iconColor = ok ? 'text-emerald-500' : 'text-red-500';
            const title = ok ? 'Connection Verified' : 'Connection Failed';
            const msg = (data && data.message) ? data.message : (ok ? 'Connection verified successfully.' : 'Unable to verify connection.');

            setTimeout(() => {
                overlay.innerHTML = `
                    <div class="text-center p-8">
                        <i class="ph ${icon} text-6xl ${iconColor} mb-4"></i>
                        <p class="font-black text-slate-900 uppercase tracking-widest mb-2">${title}</p>
                        <p class="text-xs font-bold text-slate-500">${msg}</p>
                    </div>
                `;
                setTimeout(() => location.reload(), 1800);
            }, 250);
        } catch (e) {
            const overlay = document.getElementById('checking-' + id);
            if (overlay) {
                overlay.innerHTML = `
                    <div class="text-center p-8">
                        <i class="ph ph-x-circle text-6xl text-red-500 mb-4"></i>
                        <p class="font-black text-slate-900 uppercase tracking-widest mb-2">Connection Failed</p>
                        <p class="text-xs font-bold text-slate-500">${e?.message || 'Unexpected error while verifying.'}</p>
                    </div>
                `;
                setTimeout(() => location.reload(), 1800);
            } else {
                location.reload();
            }
        }
    }

    // Basic Edit/Create handlers
    function editProvider(id) {
        const provider = PROVIDERS.find(p => p.id === id);
        if (!provider) {
            openAddModal();
            return;
        }

        document.getElementById('modal-title').innerText = 'Edit SMS Provider';
        document.getElementById('provider-modal').classList.remove('hidden');

        document.getElementById('provider_id').value = provider.id;
        document.getElementById('name').value = provider.name ?? '';
        document.getElementById('sms_username').value = provider.sms_username ?? '';
        document.getElementById('sms_password').value = '';
        document.getElementById('sms_bearer_token').value = '';
        document.getElementById('sms_url').value = provider.sms_url ?? '';
        document.getElementById('sms_from').value = provider.sms_from ?? '';
        document.getElementById('sms_method').value = (provider.sms_method ?? 'post').toLowerCase();
        document.getElementById('priority').value = provider.priority ?? 0;
        document.getElementById('notes').value = provider.notes ?? '';
        document.getElementById('is_primary').checked = !!provider.is_primary;
        document.getElementById('is_active').checked = !!provider.is_active;
    }

    document.getElementById('main-provider-form').addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = e.target;
        const id = document.getElementById('provider_id').value;
        const formData = new FormData(form);

        const payload = Object.fromEntries(formData.entries());
        payload.is_primary = document.getElementById('is_primary').checked ? 1 : 0;
        payload.is_active = document.getElementById('is_active').checked ? 1 : 0;

        if (!payload.sms_password) {
            delete payload.sms_password;
        }
        if (!payload.sms_bearer_token) {
            delete payload.sms_bearer_token;
        }

        const url = id
            ? `{{ route('admin.settings.sms-gateway.update', ':id') }}`.replace(':id', id)
            : `{{ route('admin.settings.sms-gateway.store') }}`;

        const method = id ? 'PUT' : 'POST';

        try {
            const response = await fetch(url, {
                method,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(payload),
            });

            const data = await response.json();
            if (!response.ok) {
                throw new Error(data.message || 'Failed to save provider');
            }

            closeModal();
            location.reload();
        } catch (err) {
            alert(err.message || 'Failed to save provider');
        }
    });

    async function openTestSmsModal(id) {
        switchTab('test');
        const provider = PROVIDERS.find(p => p.id === id);
        if (provider && provider.sms_from) {
            document.getElementById('test_message').value = `Test SMS from ${provider.sms_from}`;
        }
        document.getElementById('test_to').focus();
    }

    document.getElementById('quick-test-form').addEventListener('submit', async function (e) {
        e.preventDefault();

        const to = document.getElementById('test_to').value;
        const message = document.getElementById('test_message').value;
        const out = document.getElementById('quick-test-response');

        out.innerText = JSON.stringify({ status: 'sending' }, null, 2);

        try {
            const response = await fetch(`{{ route('admin.settings.sms-gateway.test') }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ to, message }),
            });

            const data = await response.json();
            out.innerText = JSON.stringify({ http_status: response.status, ...data }, null, 2);
        } catch (err) {
            out.innerText = JSON.stringify({ error: err.message || 'Unknown error' }, null, 2);
        }
    });
</script>
@endsection
