{{-- OPERATIONS MANAGER NAV --}}

<a href="{{ route('admin.operations.dashboard') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
    <i class="ph-bold ph-compass-tool mr-3 text-xl"></i>
    <span class="text-sm">Operations Dashboard</span>
</a>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Tour Planning</div>
<div class="space-y-1">
    <a href="{{ route('admin.operations.calendar') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-calendar mr-3 text-xl"></i><span class="text-sm">Tour Calendar</span></a>
    <a href="{{ route('admin.operations.upcoming') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-timer mr-3 text-xl"></i><span class="text-sm">Upcoming Tours</span></a>
    <a href="{{ route('admin.operations.active-trips') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-road-horizon mr-3 text-xl"></i><span class="text-sm">Active Trips</span></a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Assignments</div>
<div class="space-y-1">
    <a href="{{ route('admin.operations.assign.guides') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-user-circle-gear mr-3 text-xl"></i><span class="text-sm">Assign Guides</span></a>
    <a href="{{ route('admin.operations.assign.drivers') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-steering-wheel mr-3 text-xl"></i><span class="text-sm">Assign Drivers</span></a>
    <a href="{{ route('admin.fleet.index') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-jeep mr-3 text-xl"></i><span class="text-sm">Assign Vehicles</span></a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Logistics</div>
<div class="space-y-1">
    <a href="{{ route('admin.operations.logistics.accommodation') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-bed mr-3 text-xl"></i><span class="text-sm">Accommodation Bookings</span></a>
    <a href="{{ route('admin.operations.logistics.park-fees') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-ticket mr-3 text-xl"></i><span class="text-sm">Park Fees</span></a>
    <a href="{{ route('admin.operations.logistics.flights') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-airplane mr-3 text-xl"></i><span class="text-sm">Flight Details</span></a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Suppliers</div>
<div class="space-y-1">
    <a href="{{ route('admin.operations.suppliers.operators') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-handshake mr-3 text-xl"></i><span class="text-sm">Operator List</span></a>
    <a href="{{ route('admin.operations.suppliers.contracts') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-file-contract mr-3 text-xl"></i><span class="text-sm">Contracts</span></a>
    <a href="{{ route('admin.finance.ap.supplier-bills') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-money mr-3 text-xl"></i><span class="text-sm">Supplier Payments</span></a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Monitoring</div>
<div class="space-y-1">
    <a href="{{ route('admin.operations.monitoring.status') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-map-pin mr-3 text-xl"></i><span class="text-sm">Trip Status</span></a>
    <a href="{{ route('admin.operations.monitoring.incidents') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-warning mr-3 text-xl"></i><span class="text-sm">Incident Reports</span></a>
    <a href="{{ route('admin.operations.monitoring.feedback') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-chat-centered-dots mr-3 text-xl"></i><span class="text-sm">Customer Feedback</span></a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Reports</div>
<div class="space-y-1">
    <a href="{{ route('admin.operations.reports.completion') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-clipboard-text mr-3 text-xl"></i><span class="text-sm">Tour Completion Report</span></a>
    <a href="{{ route('admin.operations.reports.performance') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-chart-line-up mr-3 text-xl"></i><span class="text-sm">Operations Performance</span></a>
</div>
