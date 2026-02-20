<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FlutterwaveController extends Controller
{
    /**
     * Show Processing View
     */
    public function initialize(Request $request, $id)
    {
        $booking = Booking::with('tour')->findOrFail($id);
        $type = $request->get('type', 'full');
        return view('public.bookings.processing', compact('booking', 'type'));
    }

    /**
     * Get Actual Payment Link (via AJAX)
     */
    public function getLink(Request $request, $id)
    {
        $booking = Booking::with('tour')->findOrFail($id);
        $type = $request->get('type', 'full');
        
        $amount = $booking->total_price;
        $title = $booking->tour->name ?? 'Safari Expedition';
        
        if ($type === 'deposit') {
            $amount = $booking->total_price * 0.30;
            $title = "Deposit for " . $title;
        }

        $tx_ref = 'LAU_' . $booking->id . '_' . time();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.flutterwave.secret_key'),
            'Content-Type' => 'application/json',
        ])->post('https://api.flutterwave.com/v3/payments', [
            'tx_ref' => $tx_ref,
            'amount' => $amount,
            'currency' => 'USD',
            'redirect_url' => route('flutterwave.callback'),
            'payment_options' => 'card,mobilemoneytanzania,banktransfer,ussd',
            'customer' => [
                'email' => $booking->customer_email,
                'phonenumber' => $booking->customer_phone,
                'name' => $booking->customer_name,
            ],
            'customizations' => [
                'title' => 'LAU Paradise Adventure',
                'description' => $title . ' (Tanzania Secure Gateway)',
                'logo' => asset('logo.png'),
            ],
            'meta' => [
                'booking_id' => $booking->id,
                'payment_type' => $type,
            ]
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $booking->update([
                'payment_reference' => $tx_ref,
                'payment_method' => 'flutterwave',
            ]);

            return response()->json(['link' => $data['data']['link']]);
        }

        return response()->json(['error' => 'Failed to initialize gateway'], 500);
    }

    /**
     * Handle Flutterwave Callback
     */
    public function callback(Request $request)
    {
        $status = $request->get('status');
        $transactionId = $request->get('transaction_id');
        $txRef = $request->get('tx_ref');

        if ($status === 'successful' || $status === 'completed') {
            // Verify Transaction
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.flutterwave.secret_key'),
            ])->get("https://api.flutterwave.com/v3/transactions/{$transactionId}/verify");

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['data']['status'] === 'successful') {
                    $bookingId = $data['data']['meta']['booking_id'];
                    $type = $data['data']['meta']['payment_type'];
                    $booking = Booking::findOrFail($bookingId);

                    // Update Booking Payment Status
                    if ($type === 'deposit') {
                        $booking->update([
                            'payment_status' => 'partially_paid',
                            'deposit_amount' => $data['data']['amount'],
                            'is_deposit_paid' => true,
                            'balance_amount' => $booking->total_price - $data['data']['amount'],
                            'payment_reference' => $transactionId,
                        ]);
                    } else {
                        $booking->update([
                            'payment_status' => 'paid',
                            'payment_reference' => $transactionId,
                        ]);
                    }

                    // Send Confirmations
                    try {
                        \Illuminate\Support\Facades\Mail::to($booking->customer_email)
                            ->send(new \App\Mail\BookingConfirmation($booking));
                        
                        Log::info("SMS SIMULATION: Sent confirmation to {$booking->customer_phone} for Booking #{$booking->id}");
                    } catch (\Exception $e) {
                        Log::error('Confirmation Emails Failed: ' . $e->getMessage());
                    }

                    return redirect()->route('payment.success', ['id' => $booking->id])
                                   ->with('success', 'Payment successful and verified!');
                }
            }
        }

        return redirect('/')->with('error', 'Payment failed or was cancelled.');
    }
}
