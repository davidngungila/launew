{{-- CLIENT PORTAL NAV (PREVIEW) --}}

<a href="{{ route('client.dashboard') }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl">
    <i class="ph-bold ph-house-line mr-3 text-xl"></i>
    <span class="text-sm">My Dashboard</span>
</a>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">My Booking</div>
<div class="space-y-1">
    <a href="{{ route('admin.placeholder', ['title' => 'Booking Details']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-file-text mr-3 text-xl"></i><span class="text-sm">Booking Details</span></a>
    <a href="{{ route('admin.placeholder', ['title' => 'Itinerary']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-map-trifold mr-3 text-xl"></i><span class="text-sm">Itinerary</span></a>
    <a href="{{ route('admin.placeholder', ['title' => 'Trip Status']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-road-horizon mr-3 text-xl"></i><span class="text-sm">Trip Status</span></a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Payments</div>
<div class="space-y-1">
    <a href="{{ route('admin.placeholder', ['title' => 'Pay Balance']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-credit-card mr-3 text-xl"></i><span class="text-sm">Pay Balance</span></a>
    <a href="{{ route('admin.placeholder', ['title' => 'Payment History']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-clock-counter-clockwise mr-3 text-xl"></i><span class="text-sm">Payment History</span></a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Documents</div>
<div class="space-y-1">
    <a href="{{ route('admin.placeholder', ['title' => 'Upload Passport']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-upload mr-3 text-xl"></i><span class="text-sm">Upload Passport</span></a>
    <a href="{{ route('admin.placeholder', ['title' => 'Download Invoice']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-download mr-3 text-xl"></i><span class="text-sm">Download Invoice</span></a>
</div>

<div class="px-4 mt-6 mb-2 text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] opacity-50">Support</div>
<div class="space-y-1">
    <a href="{{ route('admin.placeholder', ['title' => 'Messages']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-chat-centered-text mr-3 text-xl"></i><span class="text-sm">Messages</span></a>
    <a href="{{ route('admin.placeholder', ['title' => 'Help Center']) }}" class="flex items-center px-4 py-3 text-emerald-100/70 hover:bg-emerald-800 hover:text-white transition-all rounded-xl"><i class="ph-bold ph-question mr-3 text-xl"></i><span class="text-sm">Help Center</span></a>
</div>
