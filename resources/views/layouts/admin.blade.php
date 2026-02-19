<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Safari Admin') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Manrope', sans-serif; }</style>
    @vite(['resources/css/admin.css', 'resources/js/app.js'])
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
        
        <!-- Logo Area -->
        <div class="p-6 flex items-center gap-3 border-b border-white/5 bg-emerald-950/50 sticky top-0 z-10">
            <img src="{{ asset('lau-adventuress-logo.png') }}" alt="Logo" class="h-10 w-auto object-contain">
            <div class="flex flex-col">
                <span class="text-xl font-black tracking-tighter text-white leading-none">LAU</span>
                <span class="text-[9px] font-bold tracking-[0.2em] text-emerald-400 uppercase leading-none mt-1">PARADISE ADVENTURE</span>
            </div>
        </div>
        
        <!-- Navigation Area (Scrollable) -->
        <div class="flex-grow overflow-y-auto custom-scrollbar p-4 space-y-2">
            
            @php
                $user = auth()->user();
                // Check if role methods exist, fallback if not
                $hasRoleMethod = method_exists($user, 'hasAnyRole');
                $isAdmin = $hasRoleMethod ? $user->hasAnyRole(['System Administrator']) : true; // Default true for now to show menu
            @endphp

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
            <div x-data="{ open: {{ request()->routeIs('admin.bookings.*') ? 'true' : 'false' }} }">
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
            <div x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.quotations.*') ? 'text-white bg-emerald-800' : '' }}">
                    <div class="flex items-center">
                        <i class="ph-bold ph-file-text mr-3 text-xl"></i>
                        <span class="text-sm">Quotations</span>
                    </div>
                    <i class="ph ph-caret-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="pl-12 pr-4 py-2 space-y-1">
                    <a href="{{ route('admin.quotations.index') }}" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">All Quotations</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Create New</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Accepted</a>
                </div>
            </div>
            @endif

            {{-- Customers --}}
            @if(!$hasRoleMethod || $user->hasAnyRole(['System Administrator', 'Travel Consultant', 'Reservations Officer']))
            <div x-data="{ open: false }">
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
            <div x-data="{ open: {{ request()->routeIs('admin.tours.*') ? 'true' : 'false' }} }">
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
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Itinerary Builder</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Availability & Pricing</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Destinations</a>
                </div>
            </div>
            @endif

            {{-- Hotels --}}
            @if(!$hasRoleMethod || $user->hasAnyRole(['System Administrator', 'Hotel Partner', 'Travel Consultant']))
            <div x-data="{ open: false }">
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
            <div x-data="{ open: false }">
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

            {{-- Accounting --}}
            @if(!$hasRoleMethod || $user->hasAnyRole(['System Administrator', 'Finance Officer']))
            <div x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.finance.*') ? 'text-white bg-emerald-800' : '' }}">
                    <div class="flex items-center">
                        <i class="ph-bold ph-currency-dollar mr-3 text-xl"></i>
                        <span class="text-sm">Finance & Invoices</span>
                    </div>
                    <i class="ph ph-caret-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="pl-12 pr-4 py-2 space-y-1">
                    <a href="{{ route('admin.finance.index') }}" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Payments Recieved</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Generated Invoices</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Expense Tracking</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Revenue Reports</a>
                </div>
            </div>
            @endif

            {{-- Statistics --}}
            @if(!$hasRoleMethod || $user->hasAnyRole(['System Administrator', 'Finance Officer', 'Travel Consultant']))
            <div x-data="{ open: false }">
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
            <div x-data="{ open: false }">
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
            <div x-data="{ open: false }">
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
            <div x-data="{ open: false }">
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
            <div x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.settings.*') ? 'text-white bg-emerald-800' : '' }}">
                    <div class="flex items-center">
                        <i class="ph-bold ph-gear mr-3 text-xl"></i>
                        <span class="text-sm">Settings & Roles</span>
                    </div>
                    <i class="ph ph-caret-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="pl-12 pr-4 py-2 space-y-1">
                    <a href="{{ route('admin.settings.index') }}" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">System Settings</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">User Management</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Role Permissions</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">Activity Logs</a>
                    <a href="#" class="block text-xs py-2 text-emerald-100/50 hover:text-white transition-colors">System Health</a>
                </div>
            </div>
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
                    <input type="text" class="block w-full pl-11 pr-4 py-3 border border-slate-200 rounded-2xl bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all duration-300" placeholder="Search data, bookings or customers...">
                </div>
            </div>
            
            <div class="flex items-center gap-2 sm:gap-4">
                <div class="hidden md:flex items-center gap-3 px-4 py-2 bg-emerald-50 text-emerald-700 rounded-2xl border border-emerald-100">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-[10px] font-black uppercase tracking-widest leading-none">Live System</span>
                </div>

                <div class="h-8 w-px bg-slate-100 mx-2 hidden sm:block"></div>

                <!-- Notifications -->
                <div class="relative group" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" 
                            class="p-3 text-slate-500 hover:bg-emerald-50 hover:text-emerald-600 rounded-2xl relative transition-all duration-300">
                        <i class="ph ph-bell text-2xl transition-transform group-hover:rotate-12"></i>
                        <span class="absolute top-3 right-3 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white shadow-sm"></span>
                    </button>
                    <!-- Notification Dropdown Placeholder -->
                    <div x-show="open" x-transition class="absolute right-0 mt-4 w-80 bg-white rounded-3xl shadow-2xl border border-slate-100 p-4 z-50">
                        <div class="flex items-center justify-between mb-4 px-2">
                            <h4 class="font-black text-xs uppercase tracking-widest text-slate-900">Notifications</h4>
                            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">3 New</span>
                        </div>
                        <div class="space-y-2">
                            <div class="p-3 rounded-2xl bg-slate-50 hover:bg-emerald-50 transition-colors cursor-pointer border border-transparent hover:border-emerald-100">
                                <p class="text-sm font-bold text-slate-900">New Booking</p>
                                <p class="text-xs text-slate-500">John Doe booked Serengeti Safari</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Profile Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" 
                            class="flex items-center gap-3 p-1.5 pr-4 rounded-2xl hover:bg-slate-50 transition-all duration-300 group">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center text-white font-black shadow-lg shadow-emerald-500/20 group-hover:scale-105 transition-transform">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="text-left hidden sm:block">
                            <p class="text-xs font-black text-slate-900 leading-tight">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-wider leading-tight mt-0.5">Administrator</p>
                        </div>
                        <i class="ph ph-caret-down text-xs text-slate-400 transition-transform hidden sm:block" :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                         class="absolute right-0 mt-3 w-64 bg-white rounded-3xl shadow-2xl border border-slate-100 py-4 z-50 overflow-hidden">
                        
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
</body>
</html>
