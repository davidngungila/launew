<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminItineraryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Safari Itinerary: Booking #' . $this->booking->id,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.bookings.itinerary',
        );
    }

    public function attachments(): array
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice', ['booking' => $this->booking]);

        return [
            \Illuminate\Mail\Mailables\Attachment::fromData(fn () => $pdf->output(), 'Safari_Itinerary_Invoice_BK' . str_pad($this->booking->id, 5, '0', STR_PAD_LEFT) . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
