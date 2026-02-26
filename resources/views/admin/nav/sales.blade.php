{{-- SALES OFFICER NAV --}}

<a href="{{ route('admin.placeholder', ['title' => 'Sales Dashboard']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
    <i class="ph-bold ph-chart-bar mr-3 text-xl"></i>
    <span class="text-sm">Sales Dashboard</span>
</a>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Leads</div>
<div class="space-y-1">
    <a href="{{ route('admin.placeholder', ['title' => 'My Leads']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-user mr-3 text-xl"></i><span class="text-sm">My Leads</span></a>
    <a href="{{ route('admin.placeholder', ['title' => 'Follow-ups']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-phone-call mr-3 text-xl"></i><span class="text-sm">Follow-ups</span></a>
    <a href="{{ route('admin.placeholder', ['title' => 'Hot Leads']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-fire mr-3 text-xl"></i><span class="text-sm">Hot Leads</span></a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Quotations</div>
<div class="space-y-1">
    <a href="{{ route('admin.quotations.create') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-file-plus mr-3 text-xl"></i><span class="text-sm">Create Quotation</span></a>
    <a href="{{ route('admin.quotations.index') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-files mr-3 text-xl"></i><span class="text-sm">Sent Quotations</span></a>
    <a href="{{ route('admin.quotations.accepted') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-check-circle mr-3 text-xl"></i><span class="text-sm">Accepted</span></a>
    <a href="{{ route('admin.placeholder', ['title' => 'Rejected Quotations']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-x-circle mr-3 text-xl"></i><span class="text-sm">Rejected</span></a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Bookings</div>
<div class="space-y-1">
    <a href="{{ route('admin.placeholder', ['title' => 'My Bookings']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-calendar mr-3 text-xl"></i><span class="text-sm">My Bookings</span></a>
    <a href="{{ route('admin.bookings.pending') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-hourglass-medium mr-3 text-xl"></i><span class="text-sm">Pending Confirmation</span></a>
    <a href="{{ route('admin.bookings.confirmed') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-checks mr-3 text-xl"></i><span class="text-sm">Confirmed</span></a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Performance</div>
<div class="space-y-1">
    <a href="{{ route('admin.placeholder', ['title' => 'Sales Target']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-target mr-3 text-xl"></i><span class="text-sm">Sales Target</span></a>
    <a href="{{ route('admin.finance.commissions.agent') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-hand-coins mr-3 text-xl"></i><span class="text-sm">Commission Tracker</span></a>
    <a href="{{ route('admin.placeholder', ['title' => 'Monthly Report']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-file-text mr-3 text-xl"></i><span class="text-sm">Monthly Report</span></a>
</div>
