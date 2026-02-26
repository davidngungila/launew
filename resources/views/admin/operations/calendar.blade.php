@extends('layouts.admin')

@section('content')
<div class="space-y-8 pb-12" x-data="{ filterStatus: 'all' }">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-sm">
                    <i class="ph-bold ph-calendar text-2xl"></i>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Tour Calendar</h1>
            </div>
            <p class="text-slate-500 font-medium">Coordinate departures, guides, drivers, and readiness</p>
        </div>

        <div class="flex flex-wrap items-center gap-4 bg-white p-3 rounded-2xl border border-slate-100 shadow-sm">
            <select x-model="filterStatus" @change="updateCalendar()" class="text-[10px] font-black uppercase tracking-widest text-slate-600 bg-slate-50 border-none rounded-xl px-4 py-2 focus:ring-0 cursor-pointer">
                <option value="all">All Statuses</option>
                <option value="confirmed">Confirmed Only</option>
                <option value="pending">Pending Only</option>
                <option value="completed">Completed Only</option>
            </select>
            <div class="h-6 w-px bg-slate-100"></div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-1.5"><div class="w-2 h-2 rounded-full bg-emerald-500"></div><span class="text-[9px] font-black uppercase text-slate-400">Confirmed</span></div>
                <div class="flex items-center gap-1.5"><div class="w-2 h-2 rounded-full bg-amber-500"></div><span class="text-[9px] font-black uppercase text-slate-400">Pending</span></div>
                <div class="flex items-center gap-1.5"><div class="w-2 h-2 rounded-full bg-blue-500"></div><span class="text-[9px] font-black uppercase text-slate-400">Done</span></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <div class="lg:col-span-3">
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-xl relative overflow-hidden">
                <div id="calendar" class="relative z-10" style="min-height:75vh;"></div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-slate-900 rounded-2xl p-8 text-white shadow-2xl relative overflow-hidden group">
                <div class="relative z-10">
                    <h3 class="text-xl font-black mb-1 leading-tight">{{ date('F') }} Insights</h3>
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-6">Monthly Targets</p>

                    <div class="space-y-4">
                        <div class="p-4 bg-white/5 rounded-2xl border border-white/10">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Scheduled Departures</p>
                            <div class="flex items-end gap-2">
                                <span class="text-2xl font-black text-emerald-400">{{ $monthStats['total_this_month'] }}</span>
                                <span class="text-[10px] font-bold text-slate-500 mb-1">expeditions</span>
                            </div>
                        </div>
                        <div class="p-4 bg-white/5 rounded-2xl border border-white/10">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Projected Revenue</p>
                            <div class="flex items-end gap-2">
                                <span class="text-2xl font-black text-blue-400">${{ number_format($monthStats['revenue_this_month'] / 1000, 1) }}k</span>
                                <span class="text-[10px] font-bold text-slate-500 mb-1">verified</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-3xl"></div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-6 flex items-center gap-2">
                    <i class="ph ph-warning-circle text-amber-500"></i> Critical Tasks
                </h4>
                <div class="space-y-4">
                    @php $critCount = 0; @endphp
                    @foreach($events as $event)
                        @if($event['status'] === 'pending' && strtotime($event['start']) <= strtotime('+7 days'))
                            <div class="flex items-center gap-3 p-3 bg-amber-50 rounded-2xl border border-amber-100">
                                <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-amber-600 shadow-sm">
                                    <i class="ph ph-clock-countdown-bold"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] font-black text-slate-900 truncate">Approve {{ $event['customer'] }}</p>
                                    <p class="text-[8px] font-bold text-amber-600 uppercase">{{ date('d M', strtotime($event['start'])) }}</p>
                                </div>
                            </div>
                            @php $critCount++; @endphp
                        @endif
                        @if($critCount >= 3) @break @endif
                    @endforeach
                    @if($critCount == 0)
                        <div class="text-center py-4">
                            <i class="ph ph-check-circle text-3xl text-emerald-200 mb-2"></i>
                            <p class="text-xs font-bold text-slate-400">All imminent trips confirmed</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div id="eventModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 md:p-8 bg-slate-900/60 backdrop-blur-sm animate-in fade-in duration-300">
    <div class="bg-white w-full h-[92vh] max-w-5xl rounded-2xl shadow-2xl relative overflow-hidden scale-95 opacity-0 duration-300 transition-all border border-slate-100" id="modalContent">
        <div class="absolute top-0 left-0 w-full h-32 bg-slate-50 -z-10"></div>

        <button onclick="closeModal()" class="absolute top-6 right-6 w-12 h-12 rounded-full bg-white text-slate-400 flex items-center justify-center hover:bg-slate-50 transition-all shadow-sm border border-slate-100 z-10">
            <i class="ph ph-x text-xl"></i>
        </button>

        <div id="modalBody" class="p-8 md:p-12 space-y-8 overflow-y-auto" style="max-height:calc(92vh - 0px);"></div>
    </div>
</div>
@endsection

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<style>
    .fc { font-family: 'Manrope', sans-serif; --fc-border-color: #f1f5f9; }
    .fc .fc-toolbar-title { font-weight: 900; color: #0f172a; text-transform: uppercase; letter-spacing: -0.025em; font-size: 1.1rem; }
    .fc .fc-button-primary { background-color: #fff; border-color: #f1f5f9; color: #64748b; font-weight: 800; text-transform: uppercase; font-size: 0.6rem; letter-spacing: 0.1em; border-radius: 0.75rem !important; padding: 0.6rem 1rem; }
    .fc .fc-button-primary:hover { background-color: #f8fafc; color: #0f172a; }
    .fc .fc-button-primary:not(:disabled).fc-button-active { background-color: #0f172a; color: #fff; border-color: #0f172a; }
    .fc .fc-daygrid-day-number { font-weight: 800; color: #cbd5e1; font-size: 0.7rem; padding: 10px !important; text-decoration: none; }
    .fc .fc-daygrid-day.fc-day-today { background-color: #f0fdf4 !important; }
    .fc .fc-event { border: none !important; margin: 2px 4px !important; padding: 4px 10px !important; border-radius: 8px !important; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .fc-event-title { font-weight: 900; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.025em; }
    .fc .fc-timegrid-slot-label { font-weight: 900; color: #94a3b8; font-size: 0.65rem; }
    .fc .fc-timegrid-axis-cushion { font-weight: 900; color: #94a3b8; font-size: 0.65rem; }

    .fc td.fc-daygrid-day.fc-day-with-event { background: #f8fafc; }
    .fc td.fc-daygrid-day.fc-day-with-event.fc-day-status-confirmed { background: #ecfdf5; }
    .fc td.fc-daygrid-day.fc-day-with-event.fc-day-status-pending { background: #fffbeb; }
    .fc td.fc-daygrid-day.fc-day-with-event.fc-day-status-completed { background: #eff6ff; }
    .fc td.fc-daygrid-day.fc-day-with-event.fc-day-status-cancelled { background: #fef2f2; }

    .fc td.fc-daygrid-day.fc-day-with-event .fc-daygrid-day-number { color: #0f172a; }
</style>
@endpush

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script>
    let calendar;
    const allEvents = @json($events);

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            height: 'auto',
            expandRows: true,
            timeZone: 'Africa/Dar_es_Salaam',
            firstDay: 1,
            initialView: 'dayGridMonth',
            headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth' },
            navLinks: true,
            nowIndicator: true,
            dayMaxEvents: true,
            events: allEvents,
            eventsSet: () => paintDayCells(),
            datesSet: () => paintDayCells(),
            eventClick: (info) => { info.jsEvent.preventDefault(); openModal(info.event); },
            eventDidMount: (info) => {
                if (typeof window.tippy === 'function') {
                    tippy(info.el, {
                        content: `<div class="p-2 text-left"><p class="text-[9px] font-black uppercase text-white/40 mb-1">${info.event.extendedProps.customer}</p><p class="text-xs font-black text-white">${info.event.title}</p></div>`,
                        allowHTML: true, theme: 'material',
                    });
                }
            }
        });
        calendar.render();
    });

    function paintDayCells() {
        const root = document.getElementById('calendar');
        if (!root || !calendar) return;

        root.querySelectorAll('td.fc-daygrid-day').forEach((el) => {
            el.classList.remove(
                'fc-day-with-event',
                'fc-day-status-confirmed',
                'fc-day-status-pending',
                'fc-day-status-completed',
                'fc-day-status-cancelled'
            );
        });

        const priority = { cancelled: 4, pending: 3, confirmed: 2, completed: 1 };
        const byDate = {};

        calendar.getEvents().forEach((ev) => {
            const status = ev.extendedProps?.status || 'confirmed';
            const d = ev.start;
            if (!d) return;
            const dateKey = d.toISOString().slice(0, 10);
            const prev = byDate[dateKey];
            if (!prev || (priority[status] || 0) > (priority[prev] || 0)) {
                byDate[dateKey] = status;
            }
        });

        Object.keys(byDate).forEach((dateKey) => {
            const cell = root.querySelector(`td.fc-daygrid-day[data-date="${dateKey}"]`);
            if (!cell) return;
            cell.classList.add('fc-day-with-event');
            cell.classList.add(`fc-day-status-${byDate[dateKey]}`);
        });
    }

    function updateCalendar() {
        const status = document.querySelector('[x-model="filterStatus"]').value;
        calendar.removeAllEvents();
        if (status === 'all') {
            calendar.addEventSource(allEvents);
        } else {
            calendar.addEventSource(allEvents.filter(e => e.status === status));
        }
        paintDayCells();
    }

    const modal = document.getElementById('eventModal');
    const modalContent = document.getElementById('modalContent');
    const modalBody = document.getElementById('modalBody');

    function openModal(event) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => { modalContent.classList.remove('scale-95', 'opacity-0'); modalContent.classList.add('scale-100', 'opacity-100'); }, 10);

        const props = event.extendedProps;
        const statusColors = { 'confirmed': 'emerald', 'pending': 'amber', 'cancelled': 'red', 'completed': 'blue' };
        const color = statusColors[props.status] || 'slate';

        modalBody.innerHTML = `
            <div class="flex items-start justify-between">
                <div class="space-y-1">
                    <span class="inline-flex px-3 py-1 bg-${color}-50 text-${color}-600 text-[9px] font-black uppercase tracking-[0.2em] rounded-lg border border-${color}-100">
                        ${props.status}
                    </span>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">${props.customer}</h2>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">${event.title}</p>
                </div>
                <div class="w-16 h-16 rounded-2xl bg-${color}-50 text-${color}-600 flex items-center justify-center shadow-inner">
                    <i class="ph-bold ph-airplane-tilt text-3xl"></i>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 pb-6 border-b border-slate-100">
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Travel Date</p>
                        <p class="text-sm font-black text-slate-800">${new Date(event.start).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Group Size</p>
                        <p class="text-sm font-black text-slate-800">${props.pax} Guests</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Value</p>
                        <p class="text-sm font-black text-emerald-600">$${new Intl.NumberFormat().format(props.total_price)}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Contact</p>
                        <p class="text-sm font-black text-slate-800">${props.phone || 'No phone'}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 bg-slate-50/50 p-6 rounded-3xl border border-slate-100">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-2">
                        <i class="ph-bold ph-user-circle"></i> Safari Guide
                    </p>
                    <p class="text-xs font-black text-slate-900">${props.guide}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-2">
                        <i class="ph-bold ph-steering-wheel"></i> Lead Driver
                    </p>
                    <p class="text-xs font-black text-slate-900">${props.driver}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <a href="${props.url}" class="py-5 bg-slate-900 text-white text-center rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/10">
                    Open Booking
                </a>
                <a href="${props.assignments_url}" class="py-5 bg-emerald-600 text-white text-center rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-500/20">
                    Assign Team
                </a>
            </div>

            <div class="grid grid-cols-2 gap-4">
                ${props.send_itinerary_url ? `
                    <form action="${props.send_itinerary_url}" method="POST" class="contents" onsubmit="return confirm('Send itinerary to the client?');">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="py-5 bg-white border border-slate-200 text-slate-900 text-center rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-slate-50 transition-all">
                            Send Itinerary
                        </button>
                    </form>
                ` : `
                    <button type="button" disabled class="py-5 bg-white border border-slate-100 text-slate-300 text-center rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] cursor-not-allowed">
                        Send Itinerary
                    </button>
                `}

                ${props.receipt_url ? `
                    <a href="${props.receipt_url}" class="py-5 bg-white border border-slate-200 text-slate-900 text-center rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-slate-50 transition-all">
                        Download Receipt
                    </a>
                ` : `
                    <button type="button" disabled class="py-5 bg-white border border-slate-100 text-slate-300 text-center rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] cursor-not-allowed">
                        Download Receipt
                    </button>
                `}
            </div>

            <div class="flex items-center justify-end">
                ${props.receipt_preview_url ? `
                    <a href="${props.receipt_preview_url}" target="_blank" class="px-6 py-3 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 hover:text-slate-900 transition-colors">
                        Preview Receipt
                    </a>
                ` : ''}
            </div>
        `;
    }

    function closeModal() {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => { modal.classList.add('hidden'); modal.classList.remove('flex'); }, 300);
    }
</script>
@endpush
