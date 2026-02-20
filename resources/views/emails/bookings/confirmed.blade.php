<x-mail::message>
# Safari Confirmed! 🦁

Dear {{ $booking->customer_name }},

Your adventure with **LAU Paradise Adventure** is officially confirmed! We are thrilled to host you for the **{{ $booking->tour->name }}**.

**📦 Booking Details:**
- **Booking Reference:** #{{ $booking->id }}
- **Start Date:** {{ \Carbon\Carbon::parse($booking->start_date)->format('d M, Y') }}
- **Status:** {{ ucfirst($booking->status) }}
- **Payment:** {{ strtoupper($booking->payment_status) }}

**💰 Financial Summary:**
- **Total Amount:** ${{ number_format($booking->total_price, 2) }}
- **Reference:** {{ $booking->payment_reference }}

Your itinerary is being prepared by our expert guides. Our team will contact you shortly with your digital welcome pack and preparation guide.

<x-mail::button :url="config('app.url')">
View My Booking
</x-mail::button>

If you have any immediate questions, simply reply to this email or contact us via WhatsApp.

Warm regards,<br>
**The LAU Paradise Team**  
*Moshi, Tanzania*
</x-mail::message>
