<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Tour;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'start_date' => 'required|date|after:today',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'special_requests' => 'nullable|string',
        ]);

        $tour = Tour::findOrFail($validated['tour_id']);
        
        // Simple price calculation
        $totalPrice = $tour->base_price * ($validated['adults'] + ($validated['children'] * 0.5));

        $booking = Booking::create([
            'tour_id' => $validated['tour_id'],
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'start_date' => $validated['start_date'],
            'adults' => $validated['adults'],
            'children' => $validated['children'] ?? 0,
            'special_requests' => $validated['special_requests'],
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        return redirect()->route('bookings.checkout', ['id' => $booking->id]);
    }

    public function checkout($id)
    {
        $booking = Booking::with('tour')->findOrFail($id);
        return view('public.bookings.checkout', compact('booking'));
    }

    public function downloadInvoice($id)
    {
        $booking = Booking::with('tour')->findOrFail($id);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice', compact('booking'));
        return $pdf->download('Safari_Invoice_BK' . str_pad($booking->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }

    public function previewInvoice($id)
    {
        $booking = Booking::with('tour')->findOrFail($id);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice', compact('booking'));

        return $pdf->stream('Safari_Invoice_BK' . str_pad($booking->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }
}
