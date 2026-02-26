{{-- BRANCH MANAGER NAV --}}

<a href="{{ route('admin.placeholder', ['title' => 'Branch Dashboard']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
    <i class="ph-bold ph-house-line mr-3 text-xl"></i>
    <span class="text-sm">Branch Dashboard</span>
</a>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Branch Bookings</div>
<div class="space-y-1">
    <a href="{{ route('admin.placeholder', ['title' => 'Branch Bookings']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-calendar-check mr-3 text-xl"></i><span class="text-sm">Branch Bookings</span></a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Finance</div>
<div class="space-y-1">
    <a href="{{ route('admin.placeholder', ['title' => 'Branch Revenue']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-currency-dollar mr-3 text-xl"></i><span class="text-sm">Branch Revenue</span></a>
    <a href="{{ route('admin.placeholder', ['title' => 'Branch Expenses']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-receipt mr-3 text-xl"></i><span class="text-sm">Expenses</span></a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Staff</div>
<div class="space-y-1">
    <a href="{{ route('admin.placeholder', ['title' => 'Branch Staff']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-users-three mr-3 text-xl"></i><span class="text-sm">Staff</span></a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Reports</div>
<div class="space-y-1">
    <a href="{{ route('admin.placeholder', ['title' => 'Branch Reports']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-chart-bar mr-3 text-xl"></i><span class="text-sm">Reports</span></a>
</div>
