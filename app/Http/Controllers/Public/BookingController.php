<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Role;
use App\Models\Tour;
use App\Models\User;
use App\Services\BookingNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
            'password' => 'required|string|min:8|confirmed',
            'agree_terms' => 'accepted',
        ]);

        $user = $request->user();
        if (!$user) {
            $existing = User::query()->where('email', $validated['customer_email'])->first();
            if ($existing) {
                if (!Auth::attempt(['email' => $validated['customer_email'], 'password' => $validated['password']])) {
                    return back()->withErrors([
                        'customer_email' => 'This email is already registered. Please login with the correct password to continue.',
                    ])->onlyInput('customer_email');
                }

                $request->session()->regenerate();
                $user = $request->user();
            } else {
                $user = User::query()->create([
                    'name' => $validated['customer_name'],
                    'email' => $validated['customer_email'],
                    'password' => Hash::make($validated['password']),
                ]);

                $customerRole = Role::query()->firstOrCreate(['name' => 'Customer']);
                $user->roles()->syncWithoutDetaching([$customerRole->id]);

                Auth::login($user);
                $request->session()->regenerate();
            }
        }

        $tour = Tour::findOrFail($validated['tour_id']);
        
        // Simple price calculation
        $totalPrice = $tour->base_price * ($validated['adults'] + ($validated['children'] * 0.5));
        $depositAmount = round($totalPrice * 0.30, 2);
        $balanceAmount = round($totalPrice - $depositAmount, 2);

        $booking = Booking::create([
            'tour_id' => $validated['tour_id'],
            'user_id' => $user ? $user->id : null,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'start_date' => $validated['start_date'],
            'adults' => $validated['adults'],
            'children' => $validated['children'] ?? 0,
            'special_requests' => $validated['special_requests'],
            'total_price' => $totalPrice,
            'deposit_amount' => $depositAmount,
            'is_deposit_paid' => false,
            'balance_amount' => $balanceAmount,
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        try {
            (new BookingNotificationService())->sendBookingCreated($booking);
        } catch (\Throwable $e) {
            Log::warning('Booking created notification failed', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);
        }

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
