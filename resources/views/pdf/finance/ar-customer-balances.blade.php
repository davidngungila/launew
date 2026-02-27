<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>AR Customer Balances</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #0f172a; }
        .h1 { font-size: 18px; font-weight: 800; margin: 0; }
        .muted { color: #64748b; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border-bottom: 1px solid #e2e8f0; padding: 8px; text-align: left; }
        th { font-size: 10px; text-transform: uppercase; letter-spacing: 0.12em; color: #64748b; }
        .right { text-align: right; }
    </style>
</head>
<body>
    <div>
        <div class="h1">Accounts Receivable - Customer Balances</div>
        <div class="muted">Generated {{ now()->format('d M Y H:i') }}</div>
    </div>

    <div class="muted" style="margin-top:6px;">
        Customers: {{ $stats['customers'] ?? 0 }} · Outstanding: ${{ number_format((float) ($stats['outstanding_total'] ?? 0), 2) }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Customer</th>
                <th>Bookings</th>
                <th class="right">Booked</th>
                <th class="right">Paid (Est.)</th>
                <th class="right">Outstanding</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $c)
                <tr>
                    <td>
                        <div style="font-weight:800;">{{ $c['name'] }}</div>
                        <div class="muted" style="font-size:10px;">{{ $c['email'] }}</div>
                    </td>
                    <td>{{ $c['bookings'] }}</td>
                    <td class="right">${{ number_format((float) $c['booked'], 2) }}</td>
                    <td class="right">${{ number_format((float) $c['paid_estimate'], 2) }}</td>
                    <td class="right">${{ number_format((float) $c['outstanding'], 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="muted">No rows</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
