<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bank Accounts</title>
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
        <div class="h1">Bank Accounts</div>
        <div class="muted">Generated {{ now()->format('d M Y H:i') }}</div>
    </div>

    <div class="muted" style="margin-top:6px;">Accounts: {{ $stats['count'] ?? 0 }} · Total balance: ${{ number_format((float) ($stats['balance_total'] ?? 0), 2) }}</div>

    <table>
        <thead>
            <tr>
                <th>Account</th>
                <th>Currency</th>
                <th>Institution</th>
                <th class="right">Balance</th>
            </tr>
        </thead>
        <tbody>
            @forelse($accounts as $a)
                <tr>
                    <td>{{ $a->name }}</td>
                    <td>{{ $a->currency }}</td>
                    <td>{{ $a->institution ?? '—' }}</td>
                    <td class="right">${{ number_format((float) ($a->calculated_balance ?? 0), 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="muted">No rows</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
