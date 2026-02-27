@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Business Analytics</h1>
            <p class="text-slate-500 font-medium">Deep dive into your sales performance and search trends</p>
        </div>
        <div class="flex items-center gap-3">
            <select class="px-6 py-3 border border-slate-200 rounded-2xl bg-white text-sm font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all shadow-sm">
                <option>Last 30 Days</option>
                <option>Last Quarter</option>
                <option>Annual View</option>
            </select>
        </div>
    </div>

    <!-- Analytics Cards -->
    @php($integrations = \App\Models\SystemSetting::getValue('integrations', []))
    @php($lookerUrl = (string) data_get($integrations, 'looker_studio_url', ''))

    @if($lookerUrl)
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-black text-slate-900 tracking-tight">Google Analytics Dashboard</h3>
                    <p class="text-slate-500 font-medium text-sm">Embedded from Looker Studio</p>
                </div>
                <a href="{{ $lookerUrl }}" target="_blank" class="px-5 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all">Open Full</a>
            </div>
            <div class="aspect-[16/9] bg-slate-50">
                <iframe src="{{ $lookerUrl }}" class="w-full h-full" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
    @else
        <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <h3 class="text-xl font-black text-slate-900 tracking-tight">Connect Google Analytics</h3>
            <p class="text-slate-500 font-medium mt-2">To display analytics here, add a Looker Studio embed URL in Settings.</p>
            <div class="mt-6 flex items-center gap-3">
                <a href="{{ route('admin.settings.index') }}" class="px-6 py-3 bg-emerald-600 text-white font-black rounded-xl hover:bg-emerald-700 transition-all">Open Settings</a>
                <a href="https://lookerstudio.google.com/" target="_blank" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 font-black rounded-xl hover:bg-slate-50 transition-all">Create Dashboard</a>
            </div>
        </div>
    @endif
</div>
@endsection
