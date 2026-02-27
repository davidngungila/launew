<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OperationsController extends Controller
{
    public function dashboard()
    {
        $today = now()->toDateString();

        $stats = [
            'upcoming_30_days' => Booking::whereDate('start_date', '>=', $today)
                ->whereDate('start_date', '<=', now()->addDays(30)->toDateString())
                ->count(),
            'active_trips' => Booking::where('status', 'confirmed')
                ->whereDate('start_date', '<=', $today)
                ->count(),
            'pending_approval' => Booking::where('status', 'pending')->count(),
            'unassigned_guides' => Booking::whereDate('start_date', '>=', $today)
                ->whereNull('guide_id')
                ->count(),
            'unassigned_drivers' => Booking::whereDate('start_date', '>=', $today)
                ->whereNull('driver_id')
                ->count(),
            'unassigned_vehicles' => Booking::whereDate('start_date', '>=', $today)
                ->whereNull('vehicle_id')
                ->count(),
        ];

        $upcoming = Booking::with(['tour', 'guide', 'driver', 'vehicle'])
            ->whereDate('start_date', '>=', $today)
            ->orderBy('start_date')
            ->limit(8)
            ->get();

        return view('admin.operations.dashboard', compact('stats', 'upcoming'));
    }

    public function calendar()
    {
        $bookings = Booking::with(['tour', 'guide', 'driver'])->get();

        $events = $bookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'title' => ($booking->tour->name ?? 'Safari'),
                'start' => $booking->start_date,
                'status' => $booking->status,
                'payment_status' => $booking->payment_status,
                'customer' => $booking->customer_name,
                'phone' => $booking->customer_phone,
                'pax' => ($booking->adults + $booking->children),
                'total_price' => $booking->total_price,
                'guide' => $booking->guide->name ?? 'Unassigned',
                'driver' => $booking->driver->name ?? 'Unassigned',
                'url' => route('admin.bookings.show', $booking->id),
                'assignments_url' => route('admin.bookings.assignments.edit', $booking->id),
                'send_itinerary_url' => route('admin.bookings.send-itinerary', $booking->id),
                'receipt_url' => route('admin.bookings.receipt', $booking->id),
                'receipt_preview_url' => route('admin.bookings.receipt.preview', $booking->id),
                'color' => match ($booking->status) {
                    'confirmed' => '#10b981',
                    'pending' => '#f59e0b',
                    'cancelled' => '#ef4444',
                    'completed' => '#3b82f6',
                    default => '#94a3b8',
                },
            ];
        });

        $monthStats = [
            'total_this_month' => Booking::whereMonth('start_date', now()->month)->count(),
            'confirmed_this_month' => Booking::whereMonth('start_date', now()->month)->where('status', 'confirmed')->count(),
            'revenue_this_month' => Booking::whereMonth('start_date', now()->month)->sum('total_price'),
        ];

        return view('admin.operations.calendar', compact('events', 'monthStats'));
    }

    public function calendarExportPdf(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');
        $status = $request->query('status');

        $query = Booking::query()->with(['tour', 'guide', 'driver', 'vehicle']);

        if (!empty($start)) {
            $query->whereDate('start_date', '>=', Carbon::parse($start)->toDateString());
        }

        if (!empty($end)) {
            $query->whereDate('start_date', '<', Carbon::parse($end)->toDateString());
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        $bookings = $query->orderBy('start_date')->get();

        $rangeLabel = null;
        if (!empty($start) && !empty($end)) {
            $rangeLabel = Carbon::parse($start)->format('d M Y') . ' - ' . Carbon::parse($end)->subDay()->format('d M Y');
        } elseif (!empty($start)) {
            $rangeLabel = Carbon::parse($start)->format('d M Y');
        }

        $pdf = Pdf::loadView('pdf.operations-calendar', [
            'bookings' => $bookings,
            'rangeLabel' => $rangeLabel,
            'statusFilter' => $status,
            'generatedAt' => now(),
            'generatedBy' => $request->user(),
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('Operations_Calendar_' . now()->format('Ymd_His') . '.pdf');
    }

    public function upcoming()
    {
        $today = now()->toDateString();

        $bookings = Booking::with(['tour', 'guide', 'driver', 'vehicle'])
            ->whereDate('start_date', '>=', $today)
            ->orderBy('start_date')
            ->paginate(15);

        return view('admin.operations.upcoming', compact('bookings'));
    }

    public function activeTrips()
    {
        $today = now()->toDateString();

        $bookings = Booking::with(['tour', 'guide', 'driver', 'vehicle'])
            ->where('status', 'confirmed')
            ->whereDate('start_date', '<=', $today)
            ->orderByDesc('start_date')
            ->paginate(15);

        return view('admin.operations.active-trips', compact('bookings'));
    }

    public function assignGuides()
    {
        $today = now()->toDateString();

        $bookings = Booking::with(['tour', 'guide', 'driver', 'vehicle'])
            ->whereDate('start_date', '>=', $today)
            ->whereNull('guide_id')
            ->orderBy('start_date')
            ->paginate(15);

        return view('admin.operations.assign-guides', compact('bookings'));
    }

    public function assignDrivers()
    {
        $today = now()->toDateString();

        $bookings = Booking::with(['tour', 'guide', 'driver', 'vehicle'])
            ->whereDate('start_date', '>=', $today)
            ->whereNull('driver_id')
            ->orderBy('start_date')
            ->paginate(15);

        return view('admin.operations.assign-drivers', compact('bookings'));
    }

    public function assignVehicles()
    {
        $today = now()->toDateString();

        $bookings = Booking::with(['tour', 'guide', 'driver', 'vehicle'])
            ->whereDate('start_date', '>=', $today)
            ->whereNull('vehicle_id')
            ->orderBy('start_date')
            ->paginate(15);

        return view('admin.operations.assign-vehicles', compact('bookings'));
    }

    public function logisticsAccommodation(Request $request)
    {
        $today = now()->toDateString();

        $bookings = Booking::with(['tour', 'guide', 'driver', 'vehicle'])
            ->whereDate('start_date', '>=', $today)
            ->orderBy('start_date')
            ->paginate(15);

        $stats = [
            'upcoming' => Booking::whereDate('start_date', '>=', $today)->count(),
            'missing_vehicle' => Booking::whereDate('start_date', '>=', $today)->whereNull('vehicle_id')->count(),
            'missing_team' => Booking::whereDate('start_date', '>=', $today)->where(function ($q) {
                $q->whereNull('guide_id')->orWhereNull('driver_id');
            })->count(),
        ];

        return view('admin.operations.logistics.accommodation', compact('bookings', 'stats'));
    }

    public function logisticsParkFees(Request $request)
    {
        $today = now()->toDateString();

        $bookings = Booking::with(['tour', 'guide', 'driver', 'vehicle'])
            ->whereDate('start_date', '>=', $today)
            ->orderBy('start_date')
            ->paginate(15);

        $stats = [
            'departures_30_days' => Booking::whereDate('start_date', '>=', $today)
                ->whereDate('start_date', '<=', now()->addDays(30)->toDateString())
                ->count(),
            'pending' => Booking::whereDate('start_date', '>=', $today)->where('status', 'pending')->count(),
        ];

        return view('admin.operations.logistics.park-fees', compact('bookings', 'stats'));
    }

    public function logisticsFlights(Request $request)
    {
        $today = now()->toDateString();

        $bookings = Booking::with(['tour', 'guide', 'driver', 'vehicle'])
            ->whereDate('start_date', '>=', $today)
            ->orderBy('start_date')
            ->paginate(15);

        $stats = [
            'upcoming_14_days' => Booking::whereDate('start_date', '>=', $today)
                ->whereDate('start_date', '<=', now()->addDays(14)->toDateString())
                ->count(),
            'with_phone' => Booking::whereDate('start_date', '>=', $today)->whereNotNull('customer_phone')->count(),
        ];

        return view('admin.operations.logistics.flights', compact('bookings', 'stats'));
    }

    public function suppliersOperators(Request $request)
    {
        $agents = Agent::query()
            ->with('user')
            ->orderBy('company_name')
            ->paginate(15);

        $bookingCounts = Booking::query()
            ->selectRaw('agent_id, COUNT(*) as total')
            ->whereNotNull('agent_id')
            ->groupBy('agent_id')
            ->pluck('total', 'agent_id');

        $stats = [
            'operators' => Agent::query()->count(),
            'bookings_with_operator' => Booking::query()->whereNotNull('agent_id')->count(),
        ];

        return view('admin.operations.suppliers.operators', compact('agents', 'bookingCounts', 'stats'));
    }

    public function suppliersContracts(Request $request)
    {
        $agents = Agent::query()
            ->with('user')
            ->orderBy('company_name')
            ->paginate(15);

        $stats = [
            'total' => Agent::query()->count(),
            'missing_commission' => Agent::query()->whereNull('commission_rate')->count(),
        ];

        return view('admin.operations.suppliers.contracts', compact('agents', 'stats'));
    }

    public function suppliersPayments(Request $request)
    {
        $today = now()->toDateString();

        $stats = [
            'bookings_next_30' => Booking::whereDate('start_date', '>=', $today)
                ->whereDate('start_date', '<=', now()->addDays(30)->toDateString())
                ->count(),
            'operators' => Agent::query()->count(),
        ];

        return view('admin.operations.suppliers.payments', compact('stats'));
    }
}
