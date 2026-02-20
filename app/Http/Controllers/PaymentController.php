<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

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
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout', $booking->id),
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
}
