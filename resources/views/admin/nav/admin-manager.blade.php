{{-- ADMIN / GENERAL MANAGER NAV --}}

<a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-800 text-white font-bold shadow-lg shadow-emerald-900/40' : '' }}">
    <i class="ph-bold ph-house-line mr-3 text-xl"></i>
    <span class="text-sm">Dashboard</span>
</a>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Bookings</div>
<div class="space-y-1">
    <a href="{{ route('admin.bookings.index') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-calendar-check mr-3 text-xl"></i>
        <span class="text-sm">All Bookings</span>
    </a>
    <a href="{{ route('admin.bookings.pending') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-hourglass-medium mr-3 text-xl"></i>
        <span class="text-sm">Pending Approval</span>
    </a>
    <a href="{{ route('admin.placeholder', ['title' => 'Cancelled Bookings']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-x-circle mr-3 text-xl"></i>
        <span class="text-sm">Cancelled</span>
    </a>
    <a href="{{ route('admin.placeholder', ['title' => 'Completed Bookings']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-check-circle mr-3 text-xl"></i>
        <span class="text-sm">Completed</span>
    </a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Customers</div>
<div class="space-y-1">
    <a href="{{ route('admin.customers.index') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-users mr-3 text-xl"></i>
        <span class="text-sm">All Customers</span>
    </a>
    <a href="{{ route('admin.placeholder', ['title' => 'Corporate Clients']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-buildings mr-3 text-xl"></i>
        <span class="text-sm">Corporate Clients</span>
    </a>
    <a href="{{ route('admin.placeholder', ['title' => 'Customer Documents']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-folder-simple mr-3 text-xl"></i>
        <span class="text-sm">Documents</span>
    </a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Tours Management</div>
<div class="space-y-1">
    <a href="{{ route('admin.tours.index') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-compass mr-3 text-xl"></i>
        <span class="text-sm">Tour Packages</span>
    </a>
    <a href="{{ route('admin.tours.itinerary-builder') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-map-trifold mr-3 text-xl"></i>
        <span class="text-sm">Itineraries</span>
    </a>
    <a href="{{ route('admin.placeholder', ['title' => 'Pricing Rules']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-tag mr-3 text-xl"></i>
        <span class="text-sm">Pricing Rules</span>
    </a>
    <a href="{{ route('admin.tours.availability-pricing') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-calendar-dots mr-3 text-xl"></i>
        <span class="text-sm">Availability</span>
    </a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Approvals</div>
<div class="space-y-1">
    <a href="{{ route('admin.placeholder', ['title' => 'Discount Requests']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-percent mr-3 text-xl"></i>
        <span class="text-sm">Discount Requests</span>
    </a>
    <a href="{{ route('admin.placeholder', ['title' => 'Refund Requests']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-arrow-counter-clockwise mr-3 text-xl"></i>
        <span class="text-sm">Refund Requests</span>
    </a>
    <a href="{{ route('admin.placeholder', ['title' => 'Expense Approvals']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-checks mr-3 text-xl"></i>
        <span class="text-sm">Expense Approvals</span>
    </a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Reports</div>
<div class="space-y-1">
    <a href="{{ route('admin.placeholder', ['title' => 'Sales Overview']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-chart-bar mr-3 text-xl"></i>
        <span class="text-sm">Sales Overview</span>
    </a>
    <a href="{{ route('admin.placeholder', ['title' => 'Operational Summary']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-clipboard-text mr-3 text-xl"></i>
        <span class="text-sm">Operational Summary</span>
    </a>
    <a href="{{ route('admin.placeholder', ['title' => 'Financial Summary']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
        <i class="ph-bold ph-currency-dollar mr-3 text-xl"></i>
        <span class="text-sm">Financial Summary</span>
    </a>
</div>
