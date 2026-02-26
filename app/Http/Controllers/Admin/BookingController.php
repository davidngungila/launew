<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Staff;
use App\Models\Vehicle;
use App\Services\BookingNotificationService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('tour')->latest()->paginate(10);
        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'revenue' => Booking::sum('total_price'),
        ];
        return view('admin.bookings.index', compact('bookings', 'stats'));
    }

    public function pending()
    {
        $bookings = Booking::with('tour')->where('status', 'pending')->latest()->paginate(10);
        return view('admin.bookings.pending', compact('bookings'));
    }

    public function confirmed()
    {
        $bookings = Booking::with('tour')->where('status', 'confirmed')->latest()->paginate(10);
        return view('admin.bookings.confirmed', compact('bookings'));
    }

    public function calendar()
    {
        $bookings = Booking::with(['tour', 'guide', 'driver'])->get();
        
        $events = $bookings->map(function($booking) {
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
                'color' => match($booking->status) {
                    'confirmed' => '#10b981', // Emerald
                    'pending' => '#f59e0b',   // Amber
                    'cancelled' => '#ef4444', // Red
                    'completed' => '#3b82f6', // Blue
                    default => '#94a3b8'     // Slate
                }
            ];
        });

        // Calculate some dynamic stats for the sidebar
        $monthStats = [
            'total_this_month' => Booking::whereMonth('start_date', now()->month)->count(),
            'confirmed_this_month' => Booking::whereMonth('start_date', now()->month)->where('status', 'confirmed')->count(),
            'revenue_this_month' => Booking::whereMonth('start_date', now()->month)->sum('total_price'),
        ];

        return view('admin.bookings.calendar', compact('events', 'monthStats'));
    }

    public function create()
    {
        $tours = \App\Models\Tour::all();
        return view('admin.bookings.create', compact('tours'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:255',
            'tour_id' => 'required|exists:tours,id',
            'start_date' => 'required|date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'special_requests' => 'nullable|string',
            'total_price' => 'required|numeric',
        ]);

        $booking = Booking::create(array_merge($validated, [
            'status' => 'pending',
            'children' => $validated['children'] ?? 0,
            'special_requests' => $validated['special_requests'] ?? null,
        ]));

        try {
            (new BookingNotificationService())->sendBookingCreated($booking);
        } catch (\Throwable $e) {
            Log::warning('Admin booking created notification failed', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Booking created successfully');
    }

    public function show($id)
    {
        $booking = Booking::with(['tour', 'guide', 'driver', 'vehicle'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit($id)
    {
        $booking = Booking::with('tour')->findOrFail($id);
        $tours = \App\Models\Tour::all();
        return view('admin.bookings.edit', compact('booking', 'tours'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:255',
            'tour_id' => 'required|exists:tours,id',
            'start_date' => 'required|date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'special_requests' => 'nullable|string',
            'total_price' => 'required|numeric',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'payment_status' => 'required|in:unpaid,partially_paid,paid',
        ]);

        $booking->update([
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'tour_id' => $validated['tour_id'],
            'start_date' => $validated['start_date'],
            'adults' => $validated['adults'],
            'children' => $validated['children'] ?? 0,
            'special_requests' => $validated['special_requests'] ?? null,
            'total_price' => $validated['total_price'],
            'status' => $validated['status'],
            'payment_status' => $validated['payment_status'],
        ]);

        return redirect()->route('admin.bookings.show', $booking->id)->with('success', 'Booking updated successfully');
    }

    public function editAssignments($id)
    {
        $booking = Booking::with(['tour', 'guide', 'driver', 'vehicle'])->findOrFail($id);
        $guides = Staff::where('role', 'guide')->orderBy('name')->get();
        $drivers = Staff::where('role', 'driver')->orderBy('name')->get();
        $vehicles = Vehicle::orderBy('plate_number')->get();

        return view('admin.bookings.assignments', compact('booking', 'guides', 'drivers', 'vehicles'));
    }

    public function updateAssignments(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'guide_id' => 'nullable|exists:staff,id',
            'driver_id' => 'nullable|exists:staff,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
        ]);

        $booking->update([
            'guide_id' => $validated['guide_id'] ?? null,
            'driver_id' => $validated['driver_id'] ?? null,
            'vehicle_id' => $validated['vehicle_id'] ?? null,
        ]);

        return redirect()->route('admin.bookings.show', $booking->id)->with('success', 'Assignments updated successfully');
    }

    public function sendItinerary($id)
    {
        $booking = Booking::with('tour')->findOrFail($id);

        try {
            (new BookingNotificationService())->sendItinerary($booking);
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to send itinerary: ' . $e->getMessage());
        }

        return back()->with('success', 'Itinerary sent successfully');
    }

    public function downloadReceipt($id)
    {
        $booking = Booking::with('tour')->findOrFail($id);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.receipt', compact('booking'));

        return $pdf->download('Receipt_BK' . str_pad($booking->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }

    public function previewReceipt($id)
    {
        $booking = Booking::with('tour')->findOrFail($id);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.receipt', compact('booking'));

        return $pdf->stream('Receipt_BK' . str_pad($booking->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }

    public function verifyPayment($id)
    {
        $booking = Booking::findOrFail($id);
        $reference = $booking->payment_reference;

        if (!$reference) {
            return back()->with('error', 'No payment reference found for this booking.');
        }

        $secret = config('services.flutterwave.secret_key');
        if (!$secret) {
            return back()->with('error', 'Flutterwave secret key is not configured.');
        }

        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Authorization' => 'Bearer ' . $secret,
        ])->get("https://api.flutterwave.com/v3/transactions/verify_by_reference?tx_ref={$reference}");

        if ($response->successful()) {
            $data = $response->json();
            
            if ($data['status'] === 'success' && $data['data']['status'] === 'successful') {
                $booking->update([
                    'payment_status' => 'paid',
                    'payment_method' => 'flutterwave',
                ]);

                try {
                    (new BookingNotificationService())->sendPaymentReceived($booking);
                } catch (\Throwable $e) {
                    Log::warning('Payment verified notification failed', [
                        'booking_id' => $booking->id,
                        'error' => $e->getMessage(),
                    ]);
                }

                return back()->with('success', 'Payment verified successfully!');
            }

            return back()->with('error', 'Payment not successful. Flutterwave Status: ' . ($data['data']['status'] ?? 'unknown'));
        }

        $message = null;
        try {
            $json = $response->json();
            $message = $json['message'] ?? null;
        } catch (\Throwable $e) {
            $message = null;
        }

        return back()->with('error', 'Payment could not be verified.' . ($message ? ' Flutterwave: ' . $message : ''));
    }
}
