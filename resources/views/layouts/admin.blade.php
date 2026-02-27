<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Safari Admin') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('lau-adventuress-logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Manrope', sans-serif; }</style>
    @vite(['resources/css/admin.css', 'resources/js/app.js'])
    @stack('styles')
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden">
    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-slate-900/60 transition-opacity lg:hidden z-40"></div>

        <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 w-72 bg-emerald-950 text-white flex-shrink-0 flex flex-col z-50 transition-transform duration-300 lg:translate-x-0 lg:static overflow-hidden shadow-2xl">
        
        <!-- Logo Area with Close Button for Mobile -->
        <div class="p-6 flex items-center justify-between border-b border-white/5 bg-emerald-950/50 sticky top-0 z-10">
            <div class="flex items-center gap-3">
                <img src="{{ asset('lau-adventuress-logo.png') }}" alt="Logo" class="h-10 w-auto object-contain">
                <div class="flex flex-col">
                    <span class="text-xl font-black tracking-tighter text-white leading-none">LAU</span>
                    <span class="text-[9px] font-bold tracking-[0.2em] text-emerald-400 uppercase leading-none mt-1">PARADISE ADVENTURE</span>
                </div>
            </div>
            <!-- Close Sidebar (Mobile Only) -->
            <button @click="sidebarOpen = false" class="lg:hidden p-2 text-white/50 hover:text-white transition-colors">
                <i class="ph-bold ph-x text-2xl"></i>
            </button>
        </div>
        
        <!-- Navigation Area (Scrollable) -->
        <div class="flex-grow overflow-y-auto custom-scrollbar p-4 space-y-2">
            
            @php
                $user = auth()->user();
                // Check if role methods exist, fallback if not
                $hasRoleMethod = method_exists($user, 'hasAnyRole') && $user && $user->roles()->exists();
                $isAdmin = $hasRoleMethod ? $user->hasAnyRole(['System Administrator']) : true; // Default true to show menu when roles not configured
                $navRoleView = session('nav_role_view');
                $canNavRoleView = $hasRoleMethod && $user && $user->hasAnyRole(['System Administrator']);
            @endphp

            @if($canNavRoleView && $navRoleView)
                @includeIf('admin.nav.' . $navRoleView)
            @else

            {{-- 🟦 MAIN DASHBOARD --}}
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-800 text-white font-bold shadow-lg shadow-emerald-900/40' : '' }}">
                <i class="ph-bold ph-house-line mr-3 text-xl"></i>
                <span class="text-sm">Dashboard Overview</span>
            </a>

            {{-- 🟦 CRM & SALES SECTION --}}
            <div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">CRM & Sales</div>

            {{-- Bookings --}}
            @if(!$hasRoleMethod || $user->hasAnyRole(['System Administrator', 'Travel Consultant', 'Reservations Officer']))
            <div x-data="{ open: window.innerWidth < 1024 || {{ request()->routeIs('admin.bookings.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.bookings.*') ? 'text-white' : '' }}">
                    <div class="flex items-center">
                        <i class="ph-bold ph-calendar-check mr-3 text-xl"></i>
                        <span class="text-sm">Bookings</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="bg-emerald-500 text-[10px] font-black px-1.5 py-0.5 rounded-md text-white">12</span>
                        <i class="ph ph-caret-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </div>
                </button>
                <div x-show="open" x-collapse class="pl-12 pr-4 py-2 space-y-1">
                    <a href="{{ route('admin.bookings.index') }}" class="block text-xs py-2 {{ request()->routeIs('admin.bookings.index') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">All Bookings</a>
                    <a href="{{ route('admin.bookings.pending') }}" class="block text-xs py-2 {{ request()->routeIs('admin.bookings.pending') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Pending Approvals</a>
                    <a href="{{ route('admin.bookings.confirmed') }}" class="block text-xs py-2 {{ request()->routeIs('admin.bookings.confirmed') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Confirmed Trips</a>
                    <a href="{{ route('admin.bookings.calendar') }}" class="block text-xs py-2 {{ request()->routeIs('admin.bookings.calendar') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Booking Calendar</a>
                </div>
            </div>
            @endif

            {{-- Quotations --}}
            @if(!$hasRoleMethod || $user->hasAnyRole(['System Administrator', 'Travel Consultant', 'Reservations Officer']))
            <div x-data="{ open: window.innerWidth < 1024 || {{ request()->routeIs('admin.quotations.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.quotations.*') ? 'text-white bg-emerald-800' : '' }}">
                    <div class="flex items-center">
                        <i class="ph-bold ph-file-text mr-3 text-xl"></i>
                        <span class="text-sm">Quotations</span>
                    </div>
                    <i class="ph ph-caret-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="pl-12 pr-4 py-2 space-y-1">
                    <a href="{{ route('admin.quotations.index') }}" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">All Quotations</a>
                    <a href="{{ route('admin.quotations.create') }}" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Create New</a>
                    <a href="{{ route('admin.quotations.accepted') }}" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Accepted</a>
                </div>
            </div>
            @endif

            {{-- Customers --}}
            @if(!$hasRoleMethod || $user->hasAnyRole(['System Administrator', 'Travel Consultant', 'Reservations Officer']))
            <div x-data="{ open: window.innerWidth < 1024 || {{ request()->routeIs('admin.customers.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.customers.*') ? 'text-white bg-emerald-800' : '' }}">
                    <div class="flex items-center">
                        <i class="ph-bold ph-users mr-3 text-xl"></i>
                        <span class="text-sm">Customers</span>
                    </div>
                    <i class="ph ph-caret-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="pl-12 pr-4 py-2 space-y-1">
                    <a href="{{ route('admin.customers.index') }}" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Customer List</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Feedback & Reviews</a>
                </div>
            </div>
            @endif

            {{-- 🟦 INVENTORY & LOGISTICS --}}
            <div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Inventory & Logistics</div>

            {{-- Tours & Packages --}}
            @if(!$hasRoleMethod || $user->hasAnyRole(['System Administrator', 'Content Manager', 'Travel Consultant']))
            <div x-data="{ open: window.innerWidth < 1024 || {{ request()->routeIs('admin.tours.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.tours.*') ? 'text-white' : '' }}">
                    <div class="flex items-center">
                        <i class="ph-bold ph-compass mr-3 text-xl"></i>
                        <span class="text-sm">Tours & Packages</span>
                    </div>
                    <i class="ph ph-caret-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="pl-12 pr-4 py-2 space-y-1">
                    <a href="{{ route('admin.tours.index') }}" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors {{ request()->routeIs('admin.tours.index') ? 'text-emerald-400 font-bold' : '' }}">All Packages</a>
                    <a href="{{ route('admin.tours.create') }}" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors {{ request()->routeIs('admin.tours.create') ? 'text-emerald-400 font-bold' : '' }}">Add New Tour</a>
                    <a href="{{ route('admin.tours.itinerary-builder') }}" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors {{ request()->routeIs('admin.tours.itinerary-builder') ? 'text-emerald-400 font-bold' : '' }}">Itinerary Builder</a>
                    <a href="{{ route('admin.tours.availability-pricing') }}" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors {{ request()->routeIs('admin.tours.availability-pricing') ? 'text-emerald-400 font-bold' : '' }}">Availability & Pricing</a>
                    <a href="{{ route('admin.tours.destinations') }}" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors {{ request()->routeIs('admin.tours.destinations') ? 'text-emerald-400 font-bold' : '' }}">Destinations</a>
                </div>
            </div>
            @endif

            {{-- Hotels --}}
            @if(!$hasRoleMethod || $user->hasAnyRole(['System Administrator', 'Hotel Partner', 'Travel Consultant']))
            <div x-data="{ open: window.innerWidth < 1024 || {{ request()->routeIs('admin.hotels.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.hotels.*') ? 'text-white bg-emerald-800' : '' }}">
                    <div class="flex items-center">
                        <i class="ph-bold ph-buildings mr-3 text-xl"></i>
                        <span class="text-sm">Hotels & Lodges</span>
                    </div>
                    <i class="ph ph-caret-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="pl-12 pr-4 py-2 space-y-1">
                    <a href="{{ route('admin.hotels.index') }}" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">All Accommodations</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Room Pricing</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Partner Portal</a>
                </div>
            </div>
            @endif

            {{-- Fleet & Drivers --}}
            @if(!$hasRoleMethod || $user->hasAnyRole(['System Administrator', 'Driver/Guide', 'Travel Consultant', 'Reservations Officer']))
            <div x-data="{ open: window.innerWidth < 1024 || {{ request()->routeIs('admin.fleet.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.fleet.*') ? 'text-white bg-emerald-800' : '' }}">
                    <div class="flex items-center">
                        <i class="ph-bold ph-jeep mr-3 text-xl"></i>
                        <span class="text-sm">Transport & Fleet</span>
                    </div>
                    <i class="ph ph-caret-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="pl-12 pr-4 py-2 space-y-1">
                    <a href="{{ route('admin.fleet.index') }}" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Vehicle Inventory</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Drivers / Guides</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Trip Assignments</a>
                </div>
            </div>
            @endif

            {{-- 🟦 FINANCE & ANALYTICS --}}
            <div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Finance & Analytics</div>

            @if(!$hasRoleMethod || $user->hasAnyRole(['System Administrator', 'Finance Officer', 'Accountant']))
            <div x-data="{ open: window.innerWidth < 1024 || {{ request()->routeIs('admin.finance.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.finance.*') ? 'text-white bg-emerald-800' : '' }}">
                    <div class="flex items-center">
                        <i class="ph-bold ph-currency-dollar mr-3 text-xl"></i>
                        <span class="text-sm">Finance</span>
                    </div>
                    <i class="ph ph-caret-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open" x-collapse class="pl-12 pr-4 py-2 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Dashboard</a>
                    <a href="{{ route('admin.finance.index') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.index') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Finance Overview</a>
                    <a href="{{ route('admin.finance.cash-position') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.cash-position') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Cash Position</a>
                    <a href="{{ route('admin.finance.monthly-summary') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.monthly-summary') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Monthly Summary</a>

                    <div class="pt-2">
                        <div class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-500/60 px-0.5">Revenue</div>
                        <div class="space-y-1 mt-1">
                            <a href="{{ route('admin.finance.revenue.all-bookings') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.revenue.all-bookings') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">All Bookings Revenue</a>
                            <a href="{{ route('admin.finance.revenue.payments-received') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.revenue.payments-received') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Payments Received</a>
                            <a href="{{ route('admin.finance.revenue.deposits') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.revenue.deposits') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Deposits</a>
                            <a href="{{ route('admin.finance.revenue.outstanding-balances') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.revenue.outstanding-balances') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Outstanding Balances</a>
                            <a href="{{ route('admin.finance.revenue.multi-currency-tracker') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.revenue.multi-currency-tracker') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Multi-Currency Tracker</a>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-500/60 px-0.5">Invoices</div>
                        <div class="space-y-1 mt-1">
                            <a href="{{ route('admin.finance.invoices.all') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.invoices.all') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">All Invoices</a>
                            <a href="{{ route('admin.finance.invoices.create') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.invoices.create') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Create Invoice</a>
                            <a href="{{ route('admin.finance.invoices.draft') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.invoices.draft') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Draft Invoices</a>
                            <a href="{{ route('admin.finance.invoices.overdue') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.invoices.overdue') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Overdue Invoices</a>
                            <a href="{{ route('admin.finance.invoices.credit-notes') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.invoices.credit-notes') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Credit Notes</a>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-500/60 px-0.5">Accounts Receivable (AR)</div>
                        <div class="space-y-1 mt-1">
                            <a href="{{ route('admin.finance.ar.customer-balances') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.ar.customer-balances') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Customer Balances</a>
                            <a href="{{ route('admin.finance.ar.aging-report') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.ar.aging-report') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Aging Report</a>
                            <a href="{{ route('admin.finance.ar.payment-reminders') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.ar.payment-reminders') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Payment Reminders</a>
                            <a href="{{ route('admin.finance.ar.installment-plans') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.ar.installment-plans') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Installment Plans</a>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-500/60 px-0.5">Accounts Payable (AP)</div>
                        <div class="space-y-1 mt-1">
                            <a href="{{ route('admin.finance.ap.supplier-bills') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.ap.supplier-bills') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Supplier Bills</a>
                            <a href="{{ route('admin.finance.ap.pending-payments') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.ap.pending-payments') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Pending Payments</a>
                            <a href="{{ route('admin.finance.ap.operator-payments') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.ap.operator-payments') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Operator Payments</a>
                            <a href="{{ route('admin.finance.ap.guide-payments') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.ap.guide-payments') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Guide Payments</a>
                            <a href="{{ route('admin.finance.ap.due-schedule') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.ap.due-schedule') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Due Schedule</a>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-500/60 px-0.5">Transactions</div>
                        <div class="space-y-1 mt-1">
                            <a href="{{ route('admin.finance.transactions.all') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.transactions.all') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">All Transactions</a>
                            <a href="{{ route('admin.finance.transactions.bank-transfers') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.transactions.bank-transfers') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Bank Transfers</a>
                            <a href="{{ route('admin.finance.transactions.cash') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.transactions.cash') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Cash Transactions</a>
                            <a href="{{ route('admin.finance.transactions.mobile-money') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.transactions.mobile-money') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Mobile Money (M-Pesa, Airtel)</a>
                            <a href="{{ route('admin.finance.transactions.stripe-card') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.transactions.stripe-card') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Stripe / Card Payments</a>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-500/60 px-0.5">Expenses</div>
                        <div class="space-y-1 mt-1">
                            <a href="{{ route('admin.finance.expenses.index') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.expenses.index') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">All Expenses</a>
                            <a href="{{ route('admin.finance.expenses.create') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.expenses.create') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Add Expense</a>
                            <a href="{{ route('admin.finance.expenses.categories.index') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.expenses.categories.*') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Expense Categories</a>
                            <a href="{{ route('admin.finance.expenses.vendors') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.expenses.vendors') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Vendor Management</a>
                            <a href="{{ route('admin.finance.expenses.recurring.index') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.expenses.recurring.*') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Recurring Expenses</a>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-500/60 px-0.5">Commissions</div>
                        <div class="space-y-1 mt-1">
                            <a href="{{ route('admin.finance.commissions.overview') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.commissions.overview') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Commission Overview</a>
                            <a href="{{ route('admin.finance.commissions.per-booking') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.commissions.per-booking') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Per Booking Commission</a>
                            <a href="{{ route('admin.finance.commissions.operator') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.commissions.operator') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Operator Commission</a>
                            <a href="{{ route('admin.finance.commissions.agent') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.commissions.agent') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Agent Commission</a>
                            <a href="{{ route('admin.finance.commissions.reports') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.commissions.reports') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Commission Reports</a>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-500/60 px-0.5">Banking & Cash</div>
                        <div class="space-y-1 mt-1">
                            <a href="{{ route('admin.finance.banking.bank-accounts') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.banking.bank-accounts') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Bank Accounts</a>
                            <a href="{{ route('admin.finance.banking.cash-accounts') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.banking.cash-accounts') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Cash Accounts</a>
                            <a href="{{ route('admin.finance.banking.transfers') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.banking.transfers') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Transfers Between Accounts</a>
                            <a href="{{ route('admin.finance.banking.reconciliation') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.banking.reconciliation') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Reconciliation</a>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-500/60 px-0.5">Reports</div>
                        <div class="space-y-1 mt-1">
                            <a href="{{ route('admin.finance.reports.profit-loss') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.reports.profit-loss') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Profit & Loss</a>
                            <a href="{{ route('admin.finance.reports.balance-sheet') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.reports.balance-sheet') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Balance Sheet</a>
                            <a href="{{ route('admin.finance.reports.cash-flow') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.reports.cash-flow') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Cash Flow</a>
                            <a href="{{ route('admin.finance.reports.revenue-report') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.reports.revenue-report') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Revenue Report</a>
                            <a href="{{ route('admin.finance.reports.expense-report') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.reports.expense-report') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Expense Report</a>
                            <a href="{{ route('admin.finance.reports.commission-report') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.reports.commission-report') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Commission Report</a>
                            <a href="{{ route('admin.finance.reports.tax-report') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.reports.tax-report') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Tax Report</a>
                            <a href="{{ route('admin.finance.reports.custom-builder') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.reports.custom-builder') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Custom Report Builder</a>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-500/60 px-0.5">Tax & Compliance</div>
                        <div class="space-y-1 mt-1">
                            <a href="{{ route('admin.finance.tax.vat-settings') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.tax.vat-settings') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">VAT Settings</a>
                            <a href="{{ route('admin.finance.tax.tax-summary') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.tax.tax-summary') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Tax Summary</a>
                            <a href="{{ route('admin.finance.tax.tax-payments') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.tax.tax-payments') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Tax Payments</a>
                            <a href="{{ route('admin.finance.tax.withholding-tax') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.tax.withholding-tax') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Withholding Tax</a>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-500/60 px-0.5">Finance Settings</div>
                        <div class="space-y-1 mt-1">
                            <a href="{{ route('admin.finance.settings.chart-of-accounts') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.settings.chart-of-accounts') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Chart of Accounts</a>
                            <a href="{{ route('admin.finance.settings.currencies') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.settings.currencies') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Currencies</a>
                            <a href="{{ route('admin.finance.settings.exchange-rates') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.settings.exchange-rates') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Exchange Rates</a>
                            <a href="{{ route('admin.finance.settings.payment-methods') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.settings.payment-methods') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Payment Methods</a>
                            <a href="{{ route('admin.finance.settings.financial-year') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.settings.financial-year') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Financial Year Settings</a>
                            <a href="{{ route('admin.finance.settings.approval-rules') }}" class="block text-xs py-2 {{ request()->routeIs('admin.finance.settings.approval-rules') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Approval Rules</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Statistics --}}
            @if(!$hasRoleMethod || $user->hasAnyRole(['System Administrator', 'Finance Officer', 'Travel Consultant']))
            <div x-data="{ open: window.innerWidth < 1024 || {{ request()->routeIs('admin.statistics.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.statistics.*') ? 'text-white bg-emerald-800' : '' }}">
                    <div class="flex items-center">
                        <i class="ph-bold ph-chart-pie mr-3 text-xl"></i>
                        <span class="text-sm">Statistics</span>
                    </div>
                    <i class="ph ph-caret-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="pl-12 pr-4 py-2 space-y-1">
                    <a href="{{ route('admin.statistics.index') }}" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Business Analytics</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Revenue Summary</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Booking Trends</a>
                </div>
            </div>
            @endif

            {{-- 🟦 SYSTEM & CONTENT --}}
            <div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">System & Content</div>

            {{-- Marketing --}}
            @if(!$hasRoleMethod || $user->hasAnyRole(['System Administrator', 'Marketing Officer', 'Marketing Manager', 'Content Manager']))
            <div x-data="{ open: window.innerWidth < 1024 || {{ request()->routeIs('admin.marketing.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.marketing.*') ? 'text-white bg-emerald-800' : '' }}">
                    <div class="flex items-center">
                        <i class="ph-bold ph-megaphone mr-3 text-xl"></i>
                        <span class="text-sm">Marketing</span>
                    </div>
                    <i class="ph ph-caret-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="pl-12 pr-4 py-2 space-y-1">
                    <a href="{{ route('admin.marketing.index') }}" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Promo Codes</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Email Campaigns</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Landing Pages</a>
                </div>
            </div>
            @endif

            {{-- Website Sections --}}
            @if(!$hasRoleMethod || $user->hasAnyRole(['System Administrator', 'Content Manager']))
            <div x-data="{ open: window.innerWidth < 1024 || {{ request()->routeIs('admin.website.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.website.*') ? 'text-white bg-emerald-800' : '' }}">
                    <div class="flex items-center">
                        <i class="ph-bold ph-browser mr-3 text-xl"></i>
                        <span class="text-sm">Website Manager</span>
                    </div>
                    <i class="ph ph-caret-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="pl-12 pr-4 py-2 space-y-1">
                    <a href="{{ route('admin.website.index') }}" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Hero Slider</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">About Page</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Testimonials</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">SEO & Meta</a>
                </div>
            </div>
            @endif

            {{-- Support & Notifications --}}
            @if(!$hasRoleMethod || $user->hasAnyRole(['System Administrator', 'Travel Consultant', 'Reservations Officer']))
            <div x-data="{ open: window.innerWidth < 1024 || {{ request()->routeIs('admin.support.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.support.*') ? 'text-white bg-emerald-800' : '' }}">
                    <div class="flex items-center">
                        <i class="ph-bold ph-chat-centered-text mr-3 text-xl"></i>
                        <span class="text-sm">Support & Inbox</span>
                    </div>
                    <i class="ph ph-caret-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="pl-12 pr-4 py-2 space-y-1">
                    <a href="{{ route('admin.support.index') }}" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Customer Queries</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Support Tickets</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Mail Inbox</a>
                </div>
            </div>
            @endif

            {{-- User Settings --}}
            @if(!$hasRoleMethod || $user->hasAnyRole(['System Administrator', 'ICT Officer']))
            <div x-data="{ open: window.innerWidth < 1024 || {{ request()->routeIs('admin.settings.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.settings.*') ? 'text-white bg-emerald-800' : '' }}">
                    <div class="flex items-center">
                        <i class="ph-bold ph-gear mr-3 text-xl"></i>
                        <span class="text-sm">Settings & Roles</span>
                    </div>
                    <i class="ph ph-caret-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="pl-12 pr-4 py-2 space-y-1">
                    <a href="{{ route('admin.settings.index') }}" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">System Settings</a>
                    <a href="{{ route('admin.settings.sms-gateway.index') }}" class="block text-xs py-2 {{ request()->routeIs('admin.settings.sms-gateway.*') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">SMS Gateway</a>
                    <a href="{{ route('admin.settings.email-gateway.edit') }}" class="block text-xs py-2 {{ request()->routeIs('admin.settings.email-gateway.*') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Email Gateway</a>
                    <a href="{{ route('admin.settings.users.index') }}" class="block text-xs py-2 {{ request()->routeIs('admin.settings.users.*') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">User Management</a>
                    <a href="{{ route('admin.settings.roles.index') }}" class="block text-xs py-2 {{ request()->routeIs('admin.settings.roles.*') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Role Permissions</a>
                    <a href="{{ route('admin.settings.activity-logs.index') }}" class="block text-xs py-2 {{ request()->routeIs('admin.settings.activity-logs.*') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">Activity Logs</a>
                    <a href="{{ route('admin.settings.system-health.index') }}" class="block text-xs py-2 {{ request()->routeIs('admin.settings.system-health.*') ? 'text-emerald-400 font-bold' : 'text-emerald-100/50' }} hover:text-white transition-colors">System Health</a>
                </div>
            </div>
            @endif

            @endif
        </div>
        
    </aside>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 flex-shrink-0 z-30">
            <div class="flex items-center gap-4 flex-grow">
                <!-- Mobile Menu Button -->
                <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-xl transition-colors">
                    <i class="ph-bold ph-list text-2xl"></i>
                </button>

                <div class="relative w-full max-w-md hidden sm:block">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                        <i class="ph ph-magnifying-glass"></i>
                    </span>
                    <input type="text" class="block w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all duration-300" placeholder="Search data, bookings or customers...">
                </div>
            </div>
            
            <div class="flex items-center gap-2 sm:gap-4">
                <div class="hidden md:flex items-center gap-3 px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-100">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-[10px] font-black uppercase tracking-widest leading-none">Live System</span>
                </div>

                @php
                    $user = auth()->user();
                    $hasRoleMethod = $user && method_exists($user, 'hasAnyRole') && $user->roles()->exists();
                    $canNavRoleView = $hasRoleMethod && $user->hasAnyRole(['System Administrator']);
                    $navRoleView = session('nav_role_view');
                @endphp

                @if($canNavRoleView)
                    <form action="{{ route('admin.nav-role-view.set') }}" method="POST" class="hidden lg:flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl shadow-sm">
                        @csrf
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Role View</span>
                        <select name="role" class="text-xs font-bold text-slate-700 bg-transparent focus:outline-none" onchange="this.form.submit()">
                            <option value="super-admin" {{ $navRoleView === 'super-admin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="admin-manager" {{ $navRoleView === 'admin-manager' ? 'selected' : '' }}>Admin / GM</option>
                            <option value="accountant" {{ $navRoleView === 'accountant' ? 'selected' : '' }}>Accountant</option>
                            <option value="marketing" {{ $navRoleView === 'marketing' ? 'selected' : '' }}>Marketing</option>
                            <option value="sales" {{ $navRoleView === 'sales' ? 'selected' : '' }}>Sales</option>
                            <option value="operations" {{ $navRoleView === 'operations' ? 'selected' : '' }}>Operations</option>
                            <option value="driver-guide" {{ $navRoleView === 'driver-guide' ? 'selected' : '' }}>Driver / Guide</option>
                            <option value="external-agent" {{ $navRoleView === 'external-agent' ? 'selected' : '' }}>External Agent</option>
                            <option value="client-portal" {{ $navRoleView === 'client-portal' ? 'selected' : '' }}>Client Portal</option>
                            <option value="branch-manager" {{ $navRoleView === 'branch-manager' ? 'selected' : '' }}>Branch Manager</option>
                            <option value="it-support" {{ $navRoleView === 'it-support' ? 'selected' : '' }}>IT Support</option>
                        </select>
                    </form>

                    @if($navRoleView)
                        <form action="{{ route('admin.nav-role-view.clear') }}" method="POST" class="hidden lg:block">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm text-xs">Clear</button>
                        </form>
                    @endif
                @endif

                <div class="h-8 w-px bg-slate-100 mx-2 hidden sm:block"></div>

                <!-- Notifications -->
                <div class="relative group" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" 
                            class="p-3 text-slate-500 hover:bg-emerald-50 hover:text-emerald-600 rounded-xl relative transition-all duration-300">
                        <i class="ph ph-bell text-2xl transition-transform group-hover:rotate-12"></i>
                        <span class="absolute top-3 right-3 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white shadow-sm"></span>
                    </button>
                    <!-- Notification Dropdown -->
                    <div x-show="open" x-transition class="absolute right-0 mt-4 w-80 bg-white rounded-2xl shadow-2xl border border-slate-100 p-4 z-50">
                        <div class="flex items-center justify-between mb-4 px-2">
                            <h4 class="font-black text-xs uppercase tracking-widest text-slate-900">Notifications</h4>
                            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">3 New</span>
                        </div>
                        <div class="space-y-2">
                            <div class="p-3 rounded-xl bg-slate-50 hover:bg-emerald-50 transition-colors cursor-pointer border border-transparent hover:border-emerald-100">
                                <p class="text-sm font-bold text-slate-900">New Booking</p>
                                <p class="text-xs text-slate-500">John Doe booked Serengeti Safari</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Profile Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" 
                            class="flex items-center gap-3 p-1.5 pr-4 rounded-xl hover:bg-slate-50 transition-all duration-300 group">
                        @php
                            $u = Auth::user();
                            $avatarUrl = $u && $u->profile_image
                                ? asset('storage/' . ltrim($u->profile_image, '/'))
                                : null;
                        @endphp
                        @if($avatarUrl)
                            <img src="{{ $avatarUrl }}" alt="Avatar" class="w-10 h-10 rounded-lg object-cover shadow-lg shadow-emerald-500/20 group-hover:scale-105 transition-transform" />
                        @else
                            <div class="w-10 h-10 rounded-lg bg-emerald-500 flex items-center justify-center text-white font-black shadow-lg shadow-emerald-500/20 group-hover:scale-105 transition-transform">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="text-left hidden sm:block">
                            <p class="text-xs font-black text-slate-900 leading-tight">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-wider leading-tight mt-0.5">Administrator</p>
                        </div>
                        <i class="ph ph-caret-down text-xs text-slate-400 transition-transform hidden sm:block" :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <!-- User Dropdown Menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                         class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl border border-slate-100 py-4 z-50 overflow-hidden">
                        
                        <div class="px-6 py-4 border-b border-slate-50 mb-2">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Signed in as</p>
                            <p class="text-sm font-black text-slate-900 truncate">{{ Auth::user()->name }}</p>
                        </div>

                        <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 px-6 py-3 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-emerald-600 transition-all">
                            <i class="ph ph-user-circle text-xl"></i>
                            View Profile
                        </a>
                        <a href="{{ route('admin.account-settings') }}" class="flex items-center gap-3 px-6 py-3 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-emerald-600 transition-all">
                            <i class="ph ph-sliders text-xl"></i>
                            Account Settings
                        </a>
                        
                        <div class="px-6 py-3 border-t border-slate-50 mt-2">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 text-sm font-bold text-red-500 hover:text-red-700 transition-colors">
                                    <i class="ph-bold ph-sign-out text-lg"></i>
                                    Logout System
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="flex-grow overflow-y-auto p-4 lg:p-10 bg-slate-50/50">
            @yield('content')
        </div>
    </main>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.05); border-radius: 10px; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); }
    </style>
    @stack('scripts')
</body>
</html>
