{{-- ACCOUNTANT NAV --}}

<a href="{{ route('admin.finance.index') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.finance.*') ? 'bg-emerald-800 text-white font-bold shadow-lg shadow-emerald-900/40' : '' }}">
    <i class="ph-bold ph-house-line mr-3 text-xl"></i>
    <span class="text-sm">Finance Dashboard</span>
</a>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Revenue</div>
<div class="space-y-1">
    <a href="{{ route('admin.finance.revenue.all-bookings') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-chart-line-up mr-3 text-xl"></i><span class="text-sm">Booking Revenue</span></a>
    <a href="{{ route('admin.finance.revenue.deposits') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-piggy-bank mr-3 text-xl"></i><span class="text-sm">Deposits</span></a>
    <a href="{{ route('admin.finance.revenue.outstanding-balances') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-warning mr-3 text-xl"></i><span class="text-sm">Outstanding Payments</span></a>
    <a href="{{ route('admin.finance.revenue.multi-currency-tracker') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-arrows-left-right mr-3 text-xl"></i><span class="text-sm">Multi-Currency</span></a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Invoices</div>
<div class="space-y-1">
    <a href="{{ route('admin.finance.invoices.all') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-receipt mr-3 text-xl"></i><span class="text-sm">All Invoices</span></a>
    <a href="{{ route('admin.finance.invoices.create') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-plus-circle mr-3 text-xl"></i><span class="text-sm">Create Invoice</span></a>
    <a href="{{ route('admin.finance.invoices.draft') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-note-pencil mr-3 text-xl"></i><span class="text-sm">Draft</span></a>
    <a href="{{ route('admin.finance.invoices.overdue') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-clock mr-3 text-xl"></i><span class="text-sm">Overdue</span></a>
    <a href="{{ route('admin.finance.invoices.credit-notes') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-file-x mr-3 text-xl"></i><span class="text-sm">Credit Notes</span></a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Accounts Receivable</div>
<div class="space-y-1">
    <a href="{{ route('admin.finance.ar.customer-balances') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-users mr-3 text-xl"></i><span class="text-sm">Customer Balances</span></a>
    <a href="{{ route('admin.finance.ar.aging-report') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-timer mr-3 text-xl"></i><span class="text-sm">Aging Report</span></a>
    <a href="{{ route('admin.finance.ar.payment-reminders') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-bell mr-3 text-xl"></i><span class="text-sm">Payment Reminders</span></a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Expenses</div>
<div class="space-y-1">
    <a href="{{ route('admin.finance.expenses.index') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-receipt mr-3 text-xl"></i><span class="text-sm">All Expenses</span></a>
    <a href="{{ route('admin.finance.expenses.create') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-plus mr-3 text-xl"></i><span class="text-sm">Add Expense</span></a>
    <a href="{{ route('admin.finance.expenses.recurring') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-repeat mr-3 text-xl"></i><span class="text-sm">Recurring Expenses</span></a>
    <a href="{{ route('admin.finance.expenses.categories') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-tag mr-3 text-xl"></i><span class="text-sm">Expense Categories</span></a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Financial Reports</div>
<div class="space-y-1">
    <a href="{{ route('admin.finance.reports.profit-loss') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-chart-pie mr-3 text-xl"></i><span class="text-sm">Profit & Loss</span></a>
    <a href="{{ route('admin.finance.reports.balance-sheet') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-scales mr-3 text-xl"></i><span class="text-sm">Balance Sheet</span></a>
    <a href="{{ route('admin.finance.reports.cash-flow') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-wave-sine mr-3 text-xl"></i><span class="text-sm">Cash Flow</span></a>
    <a href="{{ route('admin.finance.reports.custom-builder') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-faders mr-3 text-xl"></i><span class="text-sm">Custom Reports</span></a>
</div>
