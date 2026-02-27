<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>AP Due Schedule</title>
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
        <div class="h1">Accounts Payable - Due Schedule</div>
        <div class="muted">Next 30 days · Generated {{ now()->format('d M Y H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Category</th>
                <th>Description</th>
                <th class="right">Amount</th>
                <th>Booking</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $t)
                <tr>
                    <td>{{ $t->transaction_date ? date('d M Y', strtotime($t->transaction_date)) : '' }}</td>
                    <td>{{ $t->category }}</td>
                    <td>{{ $t->description }}</td>
                    <td class="right">-${{ number_format((float) $t->amount, 2) }}</td>
                    <td>{{ $t->booking_id ? ('BK-' . str_pad($t->booking_id, 5, '0', STR_PAD_LEFT)) : '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="muted">No rows</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
