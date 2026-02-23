<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $booking->id }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.6;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #10b981;
            padding-bottom: 20px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #10b981;
        }
        .company-info {
            text-align: right;
        }
        .invoice-details {
            margin-bottom: 40px;
        }
        .invoice-details table {
            width: 100%;
        }
        .details-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .table th {
            background-color: #f9fafb;
            text-align: left;
            padding: 12px;
            border-bottom: 2px solid #e5e7eb;
            color: #4b5563;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.05em;
        }
        .table td {
            padding: 12px;
            border-bottom: 1px solid #f3f4f6;
        }
        .total-section {
            text-align: right;
            margin-top: 20px;
        }
        .total-row {
            display: flex;
            justify-content: flex-end;
            gap: 20px;
            margin-bottom: 5px;
        }
        .grand-total {
            font-size: 20px;
            font-weight: bold;
            color: #10b981;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            border-top: 1px solid #f3f4f6;
            padding-top: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-paid {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-unpaid {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table style="width: 100%; margin-bottom: 40px;">
            <tr>
                <td style="text-align: center;">
                    <img src="{{ public_path('header-mfumo-lau.png') }}" style="width: 100%; max-height: 110px; object-fit: contain;">
                </td>
            </tr>
        </table>

        <div class="section-title">Invoice Information</div>
        <table style="width: 100%; margin-bottom: 30px;">
            <tr>
                <td>
                    <strong>Bill To:</strong><br>
                    {{ $booking->customer_name }}<br>
                    {{ $booking->customer_email }}<br>
                    {{ $booking->customer_phone }}
                </td>
                <td style="text-align: right;">
                    <strong>Invoice #:</strong> BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}<br>
                    <strong>Date:</strong> {{ date('d M, Y') }}<br>
                    <strong>Status:</strong> 
                    <span class="status-badge {{ $booking->payment_status === 'paid' ? 'status-paid' : 'status-unpaid' }}">
                        {{ strtoupper($booking->payment_status) }}
                    </span>
                </td>
            </tr>
        </table>

        <div class="section-title">Expedition Details</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Participants</th>
                    <th>Rate</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- Adult Pricing -->
                <tr>
                    <td>
                        <strong>{{ $booking->tour->name }} - Adult Packages</strong><br>
                        <small>Full premium safari experience</small>
                    </td>
                    <td>
                        {{ $booking->adults }} Adults
                    </td>
                    <td>
                        ${{ number_format($booking->tour->base_price, 2) }}
                    </td>
                    <td style="text-align: right;">
                        ${{ number_format($booking->adults * $booking->tour->base_price, 2) }}
                    </td>
                </tr>

                <!-- Child Pricing (if applicable) -->
                @if($booking->children > 0)
                <tr>
                    <td>
                        <strong>Child Expedition Package (50% Disc.)</strong><br>
                        <small>Specialized child-friendly amenities included</small>
                    </td>
                    <td>
                        {{ $booking->children }} Children
                    </td>
                    <td>
                        ${{ number_format($booking->tour->base_price * 0.5, 2) }}
                    </td>
                    <td style="text-align: right;">
                        ${{ number_format($booking->children * ($booking->tour->base_price * 0.5), 2) }}
                    </td>
                </tr>
                @endif
                
                @if($booking->special_requests)
                <tr>
                    <td colspan="4" style="background-color: #f9fafb; font-size: 11px;">
                        <strong>Special Requests:</strong> {{ $booking->special_requests }}
                    </td>
                </tr>
                @endif
            </tbody>
        </table>

        <div class="total-section">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="text-align: right; padding: 5px 0;">Subtotal:</td>
                    <td style="text-align: right; width: 120px; padding: 5px 0;">${{ number_format($booking->total_price, 2) }}</td>
                </tr>
                <tr>
                    <td style="text-align: right; padding: 5px 0;">Tax (VAT 0%):</td>
                    <td style="text-align: right; width: 120px; padding: 5px 0;">$0.00</td>
                </tr>
                <tr>
                    <td style="text-align: right; padding: 10px 0; font-size: 18px; font-weight: bold; color: #10b981;">Grand Total:</td>
                    <td style="text-align: right; width: 120px; padding: 10px 0; font-size: 18px; font-weight: bold; color: #10b981;">
                        ${{ number_format($booking->total_price, 2) }}
                    </td>
                </tr>
                
                @if($booking->payment_status === 'partially_paid')
                <tr style="color: #059669;">
                    <td style="text-align: right; padding: 5px 0;">Deposit Paid:</td>
                    <td style="text-align: right; padding: 5px 0;">-${{ number_format($booking->deposit_amount, 2) }}</td>
                </tr>
                <tr style="font-weight: bold; text-decoration: underline;">
                    <td style="text-align: right; padding: 5px 0;">Balance Remaining:</td>
                    <td style="text-align: right; padding: 5px 0;">${{ number_format($booking->balance_amount, 2) }}</td>
                </tr>
                @elseif($booking->payment_status === 'paid')
                <tr style="color: #059669; font-weight: bold; font-size: 14px;">
                    <td style="text-align: right; padding: 10px 0;">Total Amount Paid:</td>
                    <td style="text-align: right; padding: 10px 0;">${{ number_format($booking->total_price, 2) }}</td>
                </tr>
                @endif
            </table>
        </div>

        @if($booking->payment_reference)
        <div style="margin-top: 30px; font-size: 11px; color: #6b7280;">
            <strong>Payment Reference:</strong> {{ $booking->payment_reference }} (Via Flutterwave)
        </div>
        @endif

        <div class="footer">
            Thank you for booking your African dream with LAU Paradise Adventure. <br>
            Please present this invoice upon arrival or during your pre-safari briefing.
        </div>
    </div>
</body>
</html>
