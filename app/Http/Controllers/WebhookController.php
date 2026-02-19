<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleCheckoutCompleted($session);
                break;
        }

        return response()->json(['status' => 'success']);
    }

    protected function handleCheckoutCompleted($session)
    {
        $bookingId = $session->metadata->booking_id ?? null;
        $paymentType = $session->metadata->payment_type ?? 'full';

        if ($bookingId) {
            $booking = Booking::find($bookingId);
            if ($booking) {
                if ($paymentType === 'deposit') {
                    $booking->update([
                        'is_deposit_paid' => true,
                        'payment_status' => 'partially_paid',
                        'balance_amount' => $booking->total_price - $booking->deposit_amount,
                        'payment_reference' => $session->id,
                    ]);
                } else {
                    $booking->update([
                        'status' => 'confirmed',
                        'payment_status' => 'paid',
                        'is_deposit_paid' => true,
                        'deposit_amount' => $booking->total_price,
                        'balance_amount' => 0,
                        'payment_reference' => $session->id,
                    ]);
                }

                // Send Confirmation SMS/Email here
                // Event::dispatch(new BookingConfirmed($booking));
            }
        }
    }
}
