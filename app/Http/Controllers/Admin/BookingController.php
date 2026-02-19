<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = \App\Models\Booking::with('tour')->latest()->paginate(10);
        $stats = [
            'total' => \App\Models\Booking::count(),
            'pending' => \App\Models\Booking::where('status', 'pending')->count(),
            'confirmed' => \App\Models\Booking::where('status', 'confirmed')->count(),
            'revenue' => \App\Models\Booking::sum('total_price'),
        ];
        return view('admin.bookings.index', compact('bookings', 'stats'));
    }

    public function pending()
    {
        $bookings = \App\Models\Booking::with('tour')->where('status', 'pending')->latest()->paginate(10);
        return view('admin.bookings.pending', compact('bookings'));
    }

    public function confirmed()
    {
        $bookings = \App\Models\Booking::with('tour')->where('status', 'confirmed')->latest()->paginate(10);
        return view('admin.bookings.confirmed', compact('bookings'));
    }

    public function calendar()
    {
        $bookings = \App\Models\Booking::with(['tour', 'guide', 'driver'])->get();
        
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
            'total_this_month' => \App\Models\Booking::whereMonth('start_date', now()->month)->count(),
            'confirmed_this_month' => \App\Models\Booking::whereMonth('start_date', now()->month)->where('status', 'confirmed')->count(),
            'revenue_this_month' => \App\Models\Booking::whereMonth('start_date', now()->month)->sum('total_price'),
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
            'tour_id' => 'required|exists:tours,id',
            'start_date' => 'required|date',
            'adults' => 'required|integer|min:1',
            'total_price' => 'required|numeric',
        ]);

        $booking = \App\Models\Booking::create(array_merge($validated, ['status' => 'pending']));

        return redirect()->route('admin.bookings.index')->with('success', 'Booking created successfully');
    }

    public function show($id)
    {
        $booking = \App\Models\Booking::with(['tour', 'guide', 'driver', 'vehicle'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }
}
