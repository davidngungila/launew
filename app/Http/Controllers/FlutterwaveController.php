<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FlutterwaveController extends Controller
{
    /**
     * Initialize Flutterwave Payment
     */
    public function initialize(Request $request, $id)
    {
        $booking = Booking::with('tour')->findOrFail($id);
        $type = $request->get('type', 'full'); // 'full' or 'deposit'
        
        $amount = $booking->total_price;
        $title = $booking->tour->name ?? 'Safari Expedition';
        
        if ($type === 'deposit') {
            $amount = $booking->total_price * 0.30;
            $title = "Deposit for " . $title;
        }

        // Generate a unique reference
        $tx_ref = 'LAU_' . $booking->id . '_' . time();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.flutterwave.secret_key'),
            'Content-Type' => 'application/json',
        ])->post('https://api.flutterwave.com/v3/payments', [
            'tx_ref' => $tx_ref,
            'amount' => $amount,
            'currency' => 'USD',
            'redirect_url' => route('flutterwave.callback'),
            'customer' => [
                'email' => $booking->customer_email,
                'phonenumber' => $booking->customer_phone,
                'name' => $booking->customer_name,
            ],
            'customizations' => [
                'title' => 'LAU Paradise Adventure',
                'description' => $title,
                'logo' => asset('lau-adventuress-logo.png'),
            ],
            'meta' => [
                'booking_id' => $booking->id,
                'payment_type' => $type,
            ]
        ]);

        if ($response->successful()) {
            $data = $response->json();
            
            // Save initial reference
            $booking->update([
                'payment_reference' => $tx_ref,
                'payment_method' => 'flutterwave',
            ]);

            return redirect($data['data']['link']);
        }

        Log::error('Flutterwave Initialization Failed', [
            'booking_id' => $booking->id,
            'response' => $response->body()
        ]);

        return back()->with('error', 'Could not initialize payment. Please try again or contact support.');
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

                    return redirect()->route('payment.success', ['id' => $booking->id])
                                   ->with('success', 'Payment successful and verified!');
                }
            }
        }

        return redirect('/')->with('error', 'Payment failed or was cancelled.');
    }
}
