@extends('layouts.admin')

@section('content')
<div class="space-y-8 pb-12">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-sm">
                    <i class="ph-bold ph-calendar text-2xl"></i>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Expedition Calendar</h1>
            </div>
            <p class="text-slate-500 font-medium">Coordinate departures and track safari logistics visually</p>
        </div>

        <!-- Legend / Filters -->
        <div class="flex flex-wrap items-center gap-4 bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg border border-emerald-100 bg-emerald-50/30">
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-700">Confirmed</span>
            </div>
            <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg border border-amber-100 bg-amber-50/30">
                <div class="w-2.5 h-2.5 rounded-full bg-amber-500"></div>
                <span class="text-[10px] font-black uppercase tracking-widest text-amber-700">Pending</span>
            </div>
            <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg border border-blue-100 bg-blue-50/30">
                <div class="w-2.5 h-2.5 rounded-full bg-blue-500"></div>
                <span class="text-[10px] font-black uppercase tracking-widest text-blue-700">Completed</span>
            </div>
            <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg border border-red-100 bg-red-50/30">
                <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                <span class="text-[10px] font-black uppercase tracking-widest text-red-700">Cancelled</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Calendar Main -->
        <div class="lg:col-span-3">
            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-5 select-none pointer-events-none">
                    <i class="ph ph-calendar-blank text-9xl"></i>
                </div>
                <div id="calendar" class="relative z-10"></div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-6">
            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl relative overflow-hidden group">
                <div class="relative z-10">
                    <h3 class="text-xl font-black mb-2 leading-tight">Quick Insights</h3>
                    <p class="text-slate-400 text-sm font-medium mb-6">Overview of departure density for the current month.</p>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/10">
                            <span class="text-xs font-bold text-slate-300">Peak Week</span>
                            <span class="text-sm font-black text-emerald-400">Week 3</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/10">
                            <span class="text-xs font-bold text-slate-300">Avg. Group Size</span>
                            <span class="text-sm font-black text-blue-400">4.2 Pax</span>
                        </div>
                    </div>
                </div>
                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-3xl group-hover:bg-emerald-500/20 transition-all"></div>
            </div>

            <!-- Mini List of Upcoming -->
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-6">
                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-6">Upcoming Next 48h</h4>
                <div class="space-y-5">
                    @php $upcomingCount = 0; @endphp
                    @foreach($events as $event)
                        @if(strtotime($event['start']) >= time() && $upcomingCount < 3)
                            <a href="{{ $event['url'] }}" class="flex items-start gap-4 group">
                                <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex flex-col items-center justify-center group-hover:bg-emerald-50 group-hover:border-emerald-100 transition-all">
                                    <span class="text-[10px] font-black text-slate-900 group-hover:text-emerald-700 leading-none">{{ date('d', strtotime($event['start'])) }}</span>
                                    <span class="text-[8px] font-bold text-slate-400 uppercase leading-none mt-0.5">{{ date('M', strtotime($event['start'])) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h5 class="text-xs font-black text-slate-900 truncate">{{ $event['customer'] }}</h5>
                                    <p class="text-[10px] font-bold text-slate-500 truncate mt-0.5">{{ $event['title'] }}</p>
                                </div>
                            </a>
                            @php $upcomingCount++; @endphp
                        @endif
                    @endforeach
                    @if($upcomingCount == 0)
                        <p class="text-xs font-bold text-slate-400 italic text-center py-4">No departures soon</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Event Details -->
<div id="eventModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm animate-in fade-in duration-300">
    <div class="bg-white w-full max-w-sm rounded-[3rem] shadow-2xl p-10 relative overflow-hidden scale-95 opacity-0 duration-300 transition-all" id="modalContent">
        <button onclick="closeModal()" class="absolute top-6 right-6 w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-slate-100 transition-all">
            <i class="ph ph-x text-xl"></i>
        </button>
        
        <div id="modalBody" class="space-y-6">
            <!-- Content Injected via JS -->
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<style>
    :root {
        --fc-border-color: #f1f5f9;
        --fc-daygrid-event-dot-width: 8px;
        --fc-list-event-dot-width: 10px;
    }
    .fc { font-family: 'Manrope', sans-serif; }
    .fc .fc-toolbar-title { font-weight: 900; color: #0f172a; text-transform: uppercase; letter-spacing: -0.025em; font-size: 1.15rem; }
    .fc .fc-button-primary { background-color: #f8fafc; border-color: #f1f5f9; color: #64748b; font-weight: 800; text-transform: uppercase; font-size: 0.6rem; letter-spacing: 0.1em; border-radius: 0.75rem !important; padding: 0.6rem 1rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .fc .fc-button-primary:not(:disabled):active, .fc .fc-button-primary:not(:disabled).fc-button-active { background-color: #0f172a; border-color: #0f172a; color: #fff; box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.2); }
    .fc .fc-button-primary:hover { background-color: #f1f5f9; border-color: #e2e8f0; color: #0f172a; }
    .fc .fc-daygrid-day-number { font-weight: 800; color: #94a3b8; font-size: 0.75rem; text-decoration: none !important; padding: 5px 8px !important; }
    .fc .fc-daygrid-day.fc-day-today { background-color: #f0fdf4 !important; }
    .fc .fc-daygrid-day.fc-day-today .fc-daygrid-day-number { color: #10b981; }
    .fc .fc-event { border: none !important; padding: 4px 8px !important; transition: transform 0.2s; border-radius: 0.75rem !important; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
    .fc .fc-event:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); filter: brightness(1.05); }
    .fc-event-title { font-weight: 900; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.025em; }
    .fc-theme-standard td, .fc-theme-standard th { border-color: #f1f5f9; }
</style>
@endpush

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listMonth'
            },
            events: @json($events),
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                openModal(info.event);
            },
            eventDidMount: function(info) {
                tippy(info.el, {
                    content: `
                        <div class="px-3 py-2 text-left">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">${info.event.extendedProps.customer}</p>
                            <p class="text-xs font-black text-white">${info.event.title}</p>
                            <div class="flex items-center gap-2 mt-2 pt-2 border-t border-white/10">
                                <span class="text-[10px] font-bold text-slate-300">${info.event.extendedProps.pax} Pax</span>
                                <span class="text-[10px] font-bold text-slate-300">Status: ${info.event.extendedProps.status}</span>
                            </div>
                        </div>
                    `,
                    allowHTML: true,
                    theme: 'material',
                    placement: 'top',
                    animation: 'shift-away',
                });
            }
        });
        calendar.render();
    });

    const modal = document.getElementById('eventModal');
    const modalContent = document.getElementById('modalContent');
    const modalBody = document.getElementById('modalBody');

    function openModal(event) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);

        const statusColors = {
            'confirmed': 'emerald',
            'pending': 'amber',
            'cancelled': 'red',
            'completed': 'blue'
        };

        const colorClass = statusColors[event.extendedProps.status] || 'slate';

        modalBody.innerHTML = `
            <div class="text-center space-y-4">
                <div class="w-20 h-20 rounded-3xl bg-${colorClass}-50 text-${colorClass}-600 flex items-center justify-center mx-auto shadow-inner">
                    <i class="ph-bold ph-airplane-tilt text-4xl"></i>
                </div>
                <div>
                    <span class="inline-flex px-3 py-1 bg-${colorClass}-50 text-${colorClass}-600 text-[10px] font-black uppercase tracking-[0.2em] rounded-lg border border-${colorClass}-100">
                        ${event.extendedProps.status}
                    </span>
                    <h2 class="text-2xl font-black text-slate-900 mt-4 tracking-tight leading-tight">${event.extendedProps.customer}</h2>
                    <p class="text-sm font-bold text-slate-400 mt-1 uppercase tracking-widest">${event.title}</p>
                </div>
            </div>

            <div class="bg-slate-50/50 rounded-3xl p-6 grid grid-cols-2 gap-4">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Travel Date</p>
                    <p class="text-xs font-black text-slate-900">${new Date(event.start).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Group Size</p>
                    <p class="text-xs font-black text-slate-900">${event.extendedProps.pax} Guests</p>
                </div>
            </div>

            <div class="pt-2">
                <a href="${event.url}" class="block w-full py-4 bg-slate-900 text-white text-center rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/20">
                    View Full Details
                </a>
            </div>
        `;
    }

    function closeModal() {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }

    // Close on outside click
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });
</script>
@endpush
