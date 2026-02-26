{{-- IT SUPPORT NAV --}}

<a href="{{ route('admin.placeholder', ['title' => 'System Logs']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
    <i class="ph-bold ph-bug-beetle mr-3 text-xl"></i>
    <span class="text-sm">System Logs</span>
</a>
<a href="{{ route('admin.settings.activity-logs.index') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
    <i class="ph-bold ph-activity mr-3 text-xl"></i>
    <span class="text-sm">User Activity</span>
</a>
<a href="{{ route('admin.placeholder', ['title' => 'Integrations']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
    <i class="ph-bold ph-plugs mr-3 text-xl"></i>
    <span class="text-sm">Integrations</span>
</a>
<a href="{{ route('admin.placeholder', ['title' => 'Backup']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
    <i class="ph-bold ph-hard-drives mr-3 text-xl"></i>
    <span class="text-sm">Backup</span>
</a>
<a href="{{ route('admin.placeholder', ['title' => 'Maintenance Mode']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
    <i class="ph-bold ph-wrench mr-3 text-xl"></i>
    <span class="text-sm">Maintenance Mode</span>
</a>
