<?php

namespace App\Services;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BookingNotificationService
{
    public function sendBookingCreated(Booking $booking): void
    {
        $booking = $booking->loadMissing('tour');

        $toEmail = (string) ($booking->customer_email ?? '');
        $toPhone = (string) ($booking->customer_phone ?? '');

        $subject = 'Booking Received: BK-' . str_pad((int) $booking->id, 5, '0', STR_PAD_LEFT);
        $html = view('emails.system.booking-created', [
            'booking' => $booking,
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
            $sms = "LAU Paradise Adventure: Booking received (BK-" . str_pad((int) $booking->id, 5, '0', STR_PAD_LEFT) . "). We have emailed your invoice. Travel date: "
                . ($booking->start_date ?: 'TBD')
                . ".";
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
