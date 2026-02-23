<x-mail::message>
# Your Safari Itinerary

Dear {{ $booking->customer_name }},

Your itinerary for **{{ $booking->tour->name ?? 'your safari' }}** is ready.

**Booking Details**
- **Booking Reference:** #{{ $booking->id }}
- **Start Date:** {{ \Carbon\Carbon::parse($booking->start_date)->format('d M, Y') }}
- **Travelers:** {{ $booking->adults + $booking->children }} ({{ $booking->adults }} adults, {{ $booking->children }} children)

**Ground Support**
- **Lead Guide:** {{ $booking->guide->name ?? 'Unassigned' }}
- **Lead Driver:** {{ $booking->driver->name ?? 'Unassigned' }}
- **Vehicle:** {{ $booking->vehicle->plate_number ?? 'Unassigned' }}

Your voucher/invoice is attached to this email.

<x-mail::button :url="route('bookings.invoice', $booking->id)">
Download Voucher PDF
</x-mail::button>

If you need any changes (dietary needs, pickup point, flight details), reply to this email.

Warm regards,  
**LAU Paradise Adventure Team**
</x-mail::message>
