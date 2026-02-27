<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transfers</title>
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
        <div class="h1">Transfers Between Accounts</div>
        <div class="muted">Generated {{ now()->format('d M Y H:i') }}</div>
        <div class="muted" style="margin-top:4px;">Count: {{ $stats['count'] ?? 0 }} · Total: ${{ number_format((float) ($stats['total'] ?? 0), 2) }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>From</th>
                <th>To</th>
                <th>Reference</th>
                <th class="right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transfers as $t)
                <tr>
                    <td>{{ $t->transfer_date ? date('d M Y', strtotime($t->transfer_date)) : '' }}</td>
                    <td>{{ $t->fromAccount->name ?? '—' }}</td>
                    <td>{{ $t->toAccount->name ?? '—' }}</td>
                    <td>{{ $t->reference ?? '—' }}</td>
                    <td class="right">${{ number_format((float) $t->amount, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="muted">No rows</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
