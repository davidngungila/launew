<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reconciliation</title>
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
        <div class="h1">Reconciliation</div>
        <div class="muted">Generated {{ now()->format('d M Y H:i') }}</div>
        <div class="muted" style="margin-top:4px;">Count: {{ $stats['count'] ?? 0 }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Statement Date</th>
                <th>Account</th>
                <th class="right">Statement</th>
                <th class="right">System</th>
                <th class="right">Diff</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reconciliations as $r)
                @php $diff = (float) $r->statement_balance - (float) $r->system_balance; @endphp
                <tr>
                    <td>{{ $r->statement_date ? date('d M Y', strtotime($r->statement_date)) : '' }}</td>
                    <td>{{ $r->account->name ?? '—' }}</td>
                    <td class="right">${{ number_format((float) $r->statement_balance, 2) }}</td>
                    <td class="right">${{ number_format((float) $r->system_balance, 2) }}</td>
                    <td class="right">{{ $diff >= 0 ? '+' : '' }}${{ number_format($diff, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="muted">No rows</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
