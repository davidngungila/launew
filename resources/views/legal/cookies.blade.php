@extends('layouts.public')

@section('content')
<section class="relative pt-48 pb-32 overflow-hidden bg-slate-100">
    <div class="max-w-4xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 bg-emerald-600/10 text-emerald-600 rounded-full text-[10px] font-black tracking-[0.3em] uppercase mb-6 border border-emerald-600/20">Digital Experience</span>
            <h1 class="text-4xl md:text-6xl font-serif text-slate-900 mb-6 font-bold italic">Cookies Policy</h1>
            <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Ensuring a smooth browsing experience</p>
        </div>

        <div class="bg-white rounded-[3rem] p-8 md:p-16 shadow-2xl border border-slate-100 prose prose-slate max-w-none prose-headings:font-serif prose-headings:italic prose-a:text-emerald-600">
            <h3>1. What are Cookies?</h3>
            <p>Cookies are small text files stored on your device that help us recognize you and provide a personalized experience.</p>

            <h3>2. Types of Cookies We Use</h3>
            <ul>
                <li><strong>Essential:</strong> Required for the website to function (e.g., login session).</li>
                <li><strong>Analytics:</strong> Help us understand how visitors use our site (e.g., Google Analytics).</li>
                <li><strong>Functional:</strong> Remember your preferences (e.g., currency).</li>
            </ul>

            <h3>3. Managing Cookies</h3>
            <p>You can choose to disable cookies through your browser settings, though some parts of our site may not function correctly as a result.</p>
        </div>
    </div>
</section>
@endsection
