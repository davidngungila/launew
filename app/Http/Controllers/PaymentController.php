<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    /**
     * Create a Stripe Checkout Session for a booking.
     * Supports full payment or 30% deposit.
     */
    public function checkout(Request $request, $id)
    {
        $booking = Booking::with('tour')->findOrFail($id);
        $type = $request->get('type', 'full'); // 'full' or 'deposit'
        
        $amount = $booking->total_price;
        $name = $booking->tour->name ?? 'Safari Package';
        
        if ($type === 'deposit') {
            $amount = $booking->total_price * 0.30;
            $name = "Deposit (30%) for " . $name;
            $booking->update(['deposit_amount' => $amount]);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $name,
                        'description' => 'Booking ID: BK-' . str_pad($booking->id, 4, '0', STR_PAD_LEFT),
                    ],
                    'unit_amount' => (int)($amount * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'client_reference_id' => (string) $booking->id,
            'success_url' => route('payment.success', ['id' => $booking->id]) . '&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('bookings.checkout', ['id' => $booking->id]) . '?cancelled=1',
            'metadata' => [
                'booking_id' => $booking->id,
                'payment_type' => $type,
            ],
            'customer_email' => $booking->customer_email,
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $id = $request->get('id');
        $booking = $id ? Booking::with('tour')->find($id) : null;
        return view('payment.success', compact('booking'));
    }

    public function createPaymentIntent(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|integer|exists:bookings,id',
            'type' => 'nullable|in:full,deposit',
        ]);

        $booking = Booking::with('tour')->findOrFail($validated['booking_id']);
        $type = $validated['type'] ?? 'full';

        $amount = (float) $booking->total_price;
        if ($type === 'deposit') {
            $amount = (float) ($booking->total_price * 0.30);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $intent = PaymentIntent::create([
            'amount' => (int) round($amount * 100),
            'currency' => 'usd',
            'metadata' => [
                'booking_id' => $booking->id,
                'payment_type' => $type,
            ],
            'receipt_email' => $booking->customer_email,
        ]);

        return response()->json([
            'client_secret' => $intent->client_secret,
        ]);
    }
}
