<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt #{{ $booking->id }}</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; font-size: 13px; color: #111827; }
        .box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; }
        .header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom: 20px; border-bottom: 2px solid #10b981; padding-bottom: 14px; }
        .brand { font-size: 22px; font-weight: 800; color: #10b981; }
        .muted { color: #6b7280; font-size: 11px; }
        table { width:100%; border-collapse: collapse; }
        th { text-align:left; background:#f9fafb; color:#6b7280; font-size:10px; letter-spacing:.08em; text-transform:uppercase; padding:10px; border-bottom:1px solid #e5e7eb; }
        td { padding:10px; border-bottom:1px solid #f3f4f6; }
        .right { text-align:right; }
        .total { font-size: 18px; font-weight: 800; color:#10b981; }
        .badge { display:inline-block; padding:4px 10px; border-radius:9999px; font-size:10px; font-weight:800; text-transform:uppercase; }
        .paid { background:#d1fae5; color:#065f46; }
        .unpaid { background:#fee2e2; color:#991b1b; }
        .footer { margin-top: 18px; border-top: 1px solid #f3f4f6; padding-top: 12px; text-align:center; color:#9ca3af; font-size:10px; }
    </style>
</head>
<body>
<div class="box">
    <div class="header">
        <div>
            <div style="margin-bottom: 6px;">
                <img src="{{ public_path('header-mfumo-lau.png') }}" style="width: 360px; height: auto; display: block;">
            </div>
        </div>
        <div class="right">
            <div><strong>Receipt #</strong> BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</div>
            <div class="muted"><strong>Date:</strong> {{ date('d M, Y') }}</div>
            <div style="margin-top:6px;">
                <span class="badge {{ $booking->payment_status === 'paid' ? 'paid' : 'unpaid' }}">{{ strtoupper($booking->payment_status) }}</span>
            </div>
        </div>
    </div>

    <table style="margin-bottom: 16px;">
        <tr>
            <td style="width: 50%;">
                <strong>Received From:</strong><br>
                {{ $booking->customer_name }}<br>
                {{ $booking->customer_email }}<br>
                {{ $booking->customer_phone }}
            </td>
            <td style="width: 50%;" class="right">
                <strong>Tour:</strong> {{ $booking->tour->name ?? 'N/A' }}<br>
                <strong>Start Date:</strong> {{ $booking->start_date }}<br>
                <strong>Reference:</strong> {{ $booking->payment_reference ?? 'N/A' }}
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th class="right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Safari booking payment</td>
                <td class="right">${{ number_format($booking->total_price, 2) }}</td>
            </tr>
            <tr>
                <td class="right"><strong>Total</strong></td>
                <td class="right total">${{ number_format($booking->total_price, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        This receipt is system-generated.
    </div>
</div>
</body>
</html>
