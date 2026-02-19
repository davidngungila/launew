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
        $bookings = \App\Models\Booking::with('tour')->whereIn('status', ['confirmed', 'paid'])->get();
        // Format for FullCalendar or similar
        $events = $bookings->map(function($booking) {
            return [
                'title' => $booking->customer_name . ' - ' . ($booking->tour->name ?? 'Safari'),
                'start' => $booking->start_date,
                'status' => $booking->status,
                'url' => route('admin.bookings.show', $booking->id)
            ];
        });
        return view('admin.bookings.calendar', compact('events'));
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
