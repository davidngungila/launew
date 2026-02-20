@extends('layouts.public')

@section('content')
<section class="relative pt-48 pb-32 overflow-hidden bg-slate-100">
    <div class="max-w-4xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 bg-emerald-600/10 text-emerald-600 rounded-full text-[10px] font-black tracking-[0.3em] uppercase mb-6 border border-emerald-600/20">Data Protection</span>
            <h1 class="text-4xl md:text-6xl font-serif text-slate-900 mb-6 font-bold italic">Privacy Policy</h1>
            <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Protecting Your Digital Journey</p>
        </div>

        <div class="bg-white rounded-[3rem] p-8 md:p-16 shadow-2xl border border-slate-100 prose prose-slate max-w-none prose-headings:font-serif prose-headings:italic prose-a:text-emerald-600">
            <h3>1. Information We Collect</h3>
            <p>We collect information you provide directly to us, such as when you book a tour, create an account, or contact our support team. This includes your name, email address, passport details (for park permits), and dietary requirements.</p>

            <h3>2. How We Use Your Information</h3>
            <p>Your data is used solely to facilitate your safari bookings, process payments, and improve our services. We do not sell your personal data to third parties.</p>

            <h3>3. Third-Party Sharing</h3>
            <p>We share necessary details only with trusted partners like hotels, airlines, and national park authorities to ensure your trip is properly coordinated.</p>

            <h3>4. Data Security</h3>
            <p>We implement industry-standard security measures to protect your digital information from unauthorized access.</p>
        </div>
    </div>
</section>
@endsection
