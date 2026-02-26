{{-- SUPER ADMIN NAV --}}

<a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-800 text-white font-bold shadow-lg shadow-emerald-900/40' : '' }}">
    <i class="ph-bold ph-house-line mr-3 text-xl"></i>
    <span class="text-sm">Dashboard</span>
</a>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Organization</div>
<div class="space-y-1">
    <a href="{{ route('admin.placeholder', ['title' => 'Branches']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-git-branch mr-3 text-xl"></i>
        <span class="text-sm">Branches</span>
    </a>
    <a href="{{ route('admin.placeholder', ['title' => 'Departments']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-buildings mr-3 text-xl"></i>
        <span class="text-sm">Departments</span>
    </a>
    <a href="{{ route('admin.settings.users.index') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.settings.users.*') ? 'bg-emerald-800 text-white font-bold' : '' }}">
        <i class="ph-bold ph-users-three mr-3 text-xl"></i>
        <span class="text-sm">User Management</span>
    </a>
    <a href="{{ route('admin.settings.roles.index') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.settings.roles.*') ? 'bg-emerald-800 text-white font-bold' : '' }}">
        <i class="ph-bold ph-lock-key mr-3 text-xl"></i>
        <span class="text-sm">Roles & Permissions</span>
    </a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">System Configuration</div>
<div class="space-y-1">
    <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.settings.index') ? 'bg-emerald-800 text-white font-bold' : '' }}">
        <i class="ph-bold ph-gear-six mr-3 text-xl"></i>
        <span class="text-sm">General Settings</span>
    </a>
    <a href="{{ route('admin.placeholder', ['title' => 'Business Rules']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-sliders-horizontal mr-3 text-xl"></i>
        <span class="text-sm">Business Rules</span>
    </a>
    <a href="{{ route('admin.placeholder', ['title' => 'Financial Year']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-calendar mr-3 text-xl"></i>
        <span class="text-sm">Financial Year</span>
    </a>
    <a href="{{ route('admin.finance.settings.currencies') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-currency-circle-dollar mr-3 text-xl"></i>
        <span class="text-sm">Currencies</span>
    </a>
    <a href="{{ route('admin.finance.settings.exchange-rates') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-arrows-left-right mr-3 text-xl"></i>
        <span class="text-sm">Exchange Rates</span>
    </a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Integrations</div>
<div class="space-y-1">
    <a href="{{ route('admin.placeholder', ['title' => 'Payment Gateways']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-credit-card mr-3 text-xl"></i>
        <span class="text-sm">Payment Gateways</span>
    </a>
    <a href="{{ route('admin.settings.sms-gateway.index') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.settings.sms-gateway.*') ? 'bg-emerald-800 text-white font-bold' : '' }}">
        <i class="ph-bold ph-chat-text mr-3 text-xl"></i>
        <span class="text-sm">Email & SMS</span>
    </a>
    <a href="{{ route('admin.placeholder', ['title' => 'Google / Meta Pixel']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-pulse mr-3 text-xl"></i>
        <span class="text-sm">Google / Meta Pixel</span>
    </a>
    <a href="{{ route('admin.placeholder', ['title' => 'API Keys']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-key mr-3 text-xl"></i>
        <span class="text-sm">API Keys</span>
    </a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Monitoring</div>
<div class="space-y-1">
    <a href="{{ route('admin.settings.activity-logs.index') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.settings.activity-logs.*') ? 'bg-emerald-800 text-white font-bold' : '' }}">
        <i class="ph-bold ph-activity mr-3 text-xl"></i>
        <span class="text-sm">Activity Logs</span>
    </a>
    <a href="{{ route('admin.placeholder', ['title' => 'Audit Logs']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-clipboard-text mr-3 text-xl"></i>
        <span class="text-sm">Audit Logs</span>
    </a>
    <a href="{{ route('admin.placeholder', ['title' => 'Error Logs']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-warning-circle mr-3 text-xl"></i>
        <span class="text-sm">Error Logs</span>
    </a>
    <a href="{{ route('admin.settings.system-health.index') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.settings.system-health.*') ? 'bg-emerald-800 text-white font-bold' : '' }}">
        <i class="ph-bold ph-heartbeat mr-3 text-xl"></i>
        <span class="text-sm">System Health</span>
    </a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Reports</div>
<div class="space-y-1">
    <a href="{{ route('admin.placeholder', ['title' => 'Global Revenue']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-chart-line-up mr-3 text-xl"></i>
        <span class="text-sm">Global Revenue</span>
    </a>
    <a href="{{ route('admin.placeholder', ['title' => 'Global Performance']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-gauge mr-3 text-xl"></i>
        <span class="text-sm">Global Performance</span>
    </a>
    <a href="{{ route('admin.placeholder', ['title' => 'Subscription Reports']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-receipt-x mr-3 text-xl"></i>
        <span class="text-sm">Subscription Reports</span>
    </a>
</div>
