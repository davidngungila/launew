<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>AR Aging Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #0f172a; }
        .h1 { font-size: 18px; font-weight: 800; margin: 0; }
        .muted { color: #64748b; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border-bottom: 1px solid #e2e8f0; padding: 8px; text-align: left; }
        th { font-size: 10px; text-transform: uppercase; letter-spacing: 0.12em; color: #64748b; }
        .right { text-align: right; }
        .kpi td { border: 1px solid #e2e8f0; padding: 10px; }
    </style>
</head>
<body>
    <div>
        <div class="h1">Accounts Receivable - Aging Report</div>
        <div class="muted">Basis: {{ $basis ?? 'created_at' }} · Generated {{ now()->format('d M Y H:i') }}</div>
    </div>

    <table class="kpi" style="width:100%; border-collapse:collapse; margin-top:10px;">
        <tr>
            <td><div class="muted" style="font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.12em;">0-7</div><div style="font-size:14px; font-weight:800;">${{ number_format((float) ($buckets['0_7'] ?? 0), 2) }}</div></td>
            <td><div class="muted" style="font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.12em;">8-14</div><div style="font-size:14px; font-weight:800;">${{ number_format((float) ($buckets['8_14'] ?? 0), 2) }}</div></td>
            <td><div class="muted" style="font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.12em;">15-30</div><div style="font-size:14px; font-weight:800;">${{ number_format((float) ($buckets['15_30'] ?? 0), 2) }}</div></td>
            <td><div class="muted" style="font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.12em;">31+</div><div style="font-size:14px; font-weight:800;">${{ number_format((float) ($buckets['31_plus'] ?? 0), 2) }}</div></td>
            <td><div class="muted" style="font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.12em;">Total</div><div style="font-size:14px; font-weight:800;">${{ number_format((float) ($stats['outstanding_total'] ?? 0), 2) }}</div></td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Booking</th>
                <th>Customer</th>
                <th>Tour</th>
                <th>Status</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $b)
                <tr>
                    <td>BK-{{ str_pad($b->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $b->customer_name }}</td>
                    <td>{{ $b->tour->name ?? 'Safari' }}</td>
                    <td>{{ strtoupper($b->payment_status ?? 'N/A') }}</td>
                    <td class="right">${{ number_format((float) $b->total_price, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="muted">No rows</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
