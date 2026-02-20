@extends('layouts.public')

@section('content')
<section class="relative pt-48 pb-32 overflow-hidden bg-slate-100">
    <div class="max-w-4xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 bg-emerald-600/10 text-emerald-600 rounded-full text-[10px] font-black tracking-[0.3em] uppercase mb-6 border border-emerald-600/20">Client Protection</span>
            <h1 class="text-4xl md:text-6xl font-serif text-slate-900 mb-6 font-bold italic">Refund Policy</h1>
            <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Fairness and Transparency</p>
        </div>

        <div class="bg-white rounded-[3rem] p-8 md:p-16 shadow-2xl border border-slate-100 prose prose-slate max-w-none prose-headings:font-serif prose-headings:italic prose-a:text-emerald-600">
            <h3>1. Cancellation by Client</h3>
            <p>If you cancel your booking, the following charges apply:</p>
            <ul>
                <li><strong>90+ days:</strong> 10% of total cost (admin fee).</li>
                <li><strong>60-90 days:</strong> 25% of total cost.</li>
                <li><strong>30-60 days:</strong> 50% of total cost.</li>
                <li><strong>Less than 30 days:</strong> No refund possible.</li>
            </ul>

            <h3>2. Force Majeure</h3>
            <p>In cases of uncontrollable events (natural disasters, political instability), we will work with you to reschedule your safari or provide a travel credit voucher.</p>

            <h3>3. Unused Services</h3>
            <p>No refunds will be given for unused portions of a safari after the trip has commenced.</p>
        </div>
    </div>
</section>
@endsection
