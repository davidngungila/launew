@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                <i class="ph ph-calendar-blank text-emerald-600"></i>
                Booking Calendar
            </h1>
            <p class="text-slate-500 font-medium">Visual overview of all scheduled safari departures</p>
        </div>
    </div>

    <!-- Calendar Card -->
    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
        <div id="calendar" class="min-h-[600px]"></div>
    </div>
</div>

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<style>
    .fc { font-family: 'Manrope', sans-serif; --fc-border-color: #f1f5f9; --fc-today-bg-color: #ecfdf5; }
    .fc .fc-toolbar-title { font-weight: 900; color: #0f172a; text-transform: uppercase; letter-spacing: -0.025em; font-size: 1.25rem; }
    .fc .fc-button-primary { background-color: #10b981; border-color: #10b981; font-weight: 800; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 0.1em; border-radius: 0.75rem !important; padding: 0.75rem 1.25rem; }
    .fc .fc-button-primary:hover { background-color: #059669; border-color: #059669; }
    .fc .fc-event { border-radius: 0.5rem; padding: 2px 6px; font-weight: 700; border: none; font-size: 0.75rem; }
    .fc-theme-standard td, .fc-theme-standard th { border-color: #f8fafc; }
</style>
@endpush

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: @json($events),
            eventClick: function(info) {
                if (info.event.url) {
                    window.location.href = info.event.url;
                    return false;
                }
            },
            eventDidMount: function(info) {
                if (info.event.extendedProps.status === 'confirmed') {
                    info.el.style.backgroundColor = '#10b981';
                } else if (info.event.extendedProps.status === 'paid') {
                    info.el.style.backgroundColor = '#0ea5e9';
                }
            }
        });
        calendar.render();
    });
</script>
@endpush
@endsection
