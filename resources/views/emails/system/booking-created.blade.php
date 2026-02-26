@extends('emails.layout')

@section('content')
    <div style="font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:20px;color:#334155;">
        <p style="margin:0 0 12px 0;">Hello {{ $booking->customer_name ?? 'Guest' }},</p>
        <p style="margin:0 0 12px 0;">We have received your booking request. Your invoice is attached for your records.</p>

        <div style="margin-top:14px;padding:14px 16px;background-color:#f8fafc;border:1px solid #e5e7eb;border-radius:14px;">
            <div style="font-size:12px;line-height:16px;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;color:#64748b;">Booking Details</div>
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:10px;">
                <tr>
                    <td style="padding:6px 0;color:#64748b;font-weight:700;font-size:13px;">Booking</td>
                    <td align="right" style="padding:6px 0;color:#0f172a;font-weight:800;font-size:13px;">BK-{{ str_pad((int) $booking->id, 5, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;color:#64748b;font-weight:700;font-size:13px;">Tour</td>
                    <td align="right" style="padding:6px 0;color:#0f172a;font-weight:800;font-size:13px;">{{ $booking->tour->name ?? 'Custom Safari' }}</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;color:#64748b;font-weight:700;font-size:13px;">Travel Date</td>
                    <td align="right" style="padding:6px 0;color:#0f172a;font-weight:800;font-size:13px;">{{ $booking->start_date ?? 'TBD' }}</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;color:#64748b;font-weight:700;font-size:13px;">Total</td>
                    <td align="right" style="padding:6px 0;color:#065f46;font-weight:900;font-size:13px;">${{ number_format((float) $booking->total_price, 2) }}</td>
                </tr>
            </table>
        </div>

        <p style="margin:14px 0 0 0;">If you need help, reply to this email and our team will assist you.</p>
    </div>
@endsection
