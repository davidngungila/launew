<?php

namespace App\Services;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BookingNotificationService
{
    public function sendBookingCreated(Booking $booking, array $context = []): void
    {
        $booking = $booking->loadMissing('tour');

        $accountCreated = (bool) ($context['account_created'] ?? false);
        $accountEmail = $context['account_email'] ?? null;
        $accountPassword = $context['account_password'] ?? null;

        $toEmail = (string) ($booking->customer_email ?? '');
        $toPhone = (string) ($booking->customer_phone ?? '');

        $subject = 'Booking Received: BK-' . str_pad((int) $booking->id, 5, '0', STR_PAD_LEFT);
        $html = view('emails.system.booking-created', [
            'booking' => $booking,
            'title' => $subject,
            'heading' => 'Booking received',
            'subheading' => 'Your invoice is attached. Choose a payment method below to secure your safari.',
            'logo_url' => url('lau-adventuress-logo.png'),
            'website_url' => config('app.url'),
            'support_email' => config('mail.from.address'),
            'support_phone' => null,
            'support_whatsapp' => null,
            'payment_url' => route('bookings.checkout', ['id' => $booking->id]),
            'stripe_payment_url' => route('checkout', ['id' => $booking->id]),
            'flutterwave_payment_url' => route('flutterwave.pay', ['id' => $booking->id]),
            'account_created' => $accountCreated,
            'account_email' => $accountEmail,
            'account_password' => $accountPassword,
            'login_url' => route('login'),
        ])->render();

        $invoicePath = $this->writePdfToLocalTemp(
            Pdf::loadView('pdf.invoice', ['booking' => $booking])->output(),
            'Safari_Invoice_BK' . str_pad((int) $booking->id, 5, '0', STR_PAD_LEFT) . '.pdf'
        );

        $notification = new NotificationService();

        if ($toEmail) {
            $notification->sendEmail($toEmail, $subject, $html, $invoicePath, basename($invoicePath));
        }

        if ($toPhone) {
            $sms = "LAU Paradise Adventure: We received your booking BK-" . str_pad((int) $booking->id, 5, '0', STR_PAD_LEFT)
                . ". Invoice sent to your email. Pay securely here: " . route('bookings.checkout', ['id' => $booking->id]);
            $notification->sendSMS($toPhone, $sms);
        }
    }

    public function sendItinerary(Booking $booking): void
    {
        $booking = $booking->loadMissing('tour');

        $toEmail = (string) ($booking->customer_email ?? '');
        $toPhone = (string) ($booking->customer_phone ?? '');

        $subject = 'Safari Itinerary: BK-' . str_pad((int) $booking->id, 5, '0', STR_PAD_LEFT);
        $html = view('emails.system.itinerary', [
            'booking' => $booking,
            'title' => $subject,
            'heading' => 'Your safari itinerary is ready',
            'subheading' => 'Please find your itinerary attached as a PDF.',
            'logo_url' => url('lau-adventuress-logo.png'),
            'website_url' => config('app.url'),
            'support_email' => config('mail.from.address'),
            'support_phone' => null,
            'support_whatsapp' => null,
        ])->render();

        $itineraryPath = $this->writePdfToLocalTemp(
            Pdf::loadView('pdf.invoice', ['booking' => $booking])->output(),
            'Safari_Itinerary_BK' . str_pad((int) $booking->id, 5, '0', STR_PAD_LEFT) . '.pdf'
        );

        $notification = new NotificationService();

        if ($toEmail) {
            $notification->sendEmail($toEmail, $subject, $html, $itineraryPath, basename($itineraryPath));
        }

        if ($toPhone) {
            $sms = "LAU Paradise Adventure: Your itinerary has been sent for booking BK-" . str_pad((int) $booking->id, 5, '0', STR_PAD_LEFT) . ".";
            $notification->sendSMS($toPhone, $sms);
        }
    }

    public function sendPaymentReceived(Booking $booking): void
    {
        $booking = $booking->loadMissing('tour');

        $toEmail = (string) ($booking->customer_email ?? '');
        $toPhone = (string) ($booking->customer_phone ?? '');

        $subject = 'Payment Confirmed: BK-' . str_pad((int) $booking->id, 5, '0', STR_PAD_LEFT);
        $html = view('emails.system.booking-paid', [
            'booking' => $booking,
            'title' => $subject,
            'heading' => 'Payment confirmed',
            'subheading' => 'Your receipt is attached for your records.',
            'logo_url' => url('lau-adventuress-logo.png'),
            'website_url' => config('app.url'),
            'support_email' => config('mail.from.address'),
            'support_phone' => null,
            'support_whatsapp' => null,
        ])->render();

        $receiptPath = $this->writePdfToLocalTemp(
            Pdf::loadView('pdf.receipt', ['booking' => $booking->loadMissing('tour')])->output(),
            'Receipt_BK' . str_pad((int) $booking->id, 5, '0', STR_PAD_LEFT) . '.pdf'
        );

        $notification = new NotificationService();

        if ($toEmail) {
            $notification->sendEmail($toEmail, $subject, $html, $receiptPath, basename($receiptPath));
        }

        if ($toPhone) {
            $sms = "LAU Paradise Adventure: Payment confirmed for booking BK-" . str_pad((int) $booking->id, 5, '0', STR_PAD_LEFT) . ". Receipt has been emailed to you.";
            $notification->sendSMS($toPhone, $sms);
        }
    }

    private function writePdfToLocalTemp(string $pdfBytes, string $filename): string
    {
        $dir = 'tmp/booking-notifications';
        $path = $dir . '/' . time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $filename);

        try {
            Storage::disk('local')->put($path, $pdfBytes);
        } catch (\Throwable $e) {
            Log::warning('Failed to write PDF temp file', ['error' => $e->getMessage()]);
        }

        return storage_path('app/' . $path);
    }
}
