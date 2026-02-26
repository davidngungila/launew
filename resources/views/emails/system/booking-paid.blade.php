@extends('emails.layout')

@section('content')
    <div style="font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:20px;color:#334155;">
        <p style="margin:0 0 12px 0;">Hello {{ $booking->customer_name ?? 'Guest' }},</p>
        <p style="margin:0 0 12px 0;">We have confirmed your payment. Your receipt is attached for your records.</p>

        <div style="margin-top:14px;padding:14px 16px;background-color:#ecfdf5;border:1px solid #a7f3d0;border-radius:14px;">
            <div style="font-size:12px;line-height:16px;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;color:#047857;">Payment Confirmation</div>
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:10px;">
                <tr>
                    <td style="padding:6px 0;color:#065f46;font-weight:700;font-size:13px;">Booking</td>
                    <td align="right" style="padding:6px 0;color:#064e3b;font-weight:900;font-size:13px;">BK-{{ str_pad((int) $booking->id, 5, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;color:#065f46;font-weight:700;font-size:13px;">Payment Status</td>
                    <td align="right" style="padding:6px 0;color:#064e3b;font-weight:900;font-size:13px;">{{ strtoupper($booking->payment_status ?? 'PAID') }}</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;color:#065f46;font-weight:700;font-size:13px;">Reference</td>
                    <td align="right" style="padding:6px 0;color:#064e3b;font-weight:900;font-size:13px;">{{ $booking->payment_reference ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;color:#065f46;font-weight:700;font-size:13px;">Amount</td>
                    <td align="right" style="padding:6px 0;color:#064e3b;font-weight:900;font-size:13px;">${{ number_format((float) $booking->total_price, 2) }}</td>
                </tr>
            </table>
        </div>

        <p style="margin:14px 0 0 0;">Thank you for choosing LAU Paradise Adventure.</p>
    </div>
@endsection
