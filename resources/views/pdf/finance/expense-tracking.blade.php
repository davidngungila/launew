<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Expense Tracking</title>
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
        <div class="h1">Expense Tracking</div>
        <div class="muted">Generated {{ now()->format('d M Y H:i') }}</div>
    </div>

    <table class="kpi" style="width:100%; border-collapse:collapse; margin-top:10px;">
        <tr>
            <td><div class="muted" style="font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.12em;">Total</div><div style="font-size:14px; font-weight:800;">${{ number_format((float) ($stats['totalExpenses'] ?? 0), 2) }}</div></td>
            <td><div class="muted" style="font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.12em;">Fuel</div><div style="font-size:14px; font-weight:800;">${{ number_format((float) ($stats['fuel'] ?? 0), 2) }}</div></td>
            <td><div class="muted" style="font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.12em;">Accommodation</div><div style="font-size:14px; font-weight:800;">${{ number_format((float) ($stats['accommodation'] ?? 0), 2) }}</div></td>
            <td><div class="muted" style="font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.12em;">Park fees</div><div style="font-size:14px; font-weight:800;">${{ number_format((float) ($stats['parkFees'] ?? 0), 2) }}</div></td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Category</th>
                <th>Description</th>
                <th class="right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recent as $e)
                <tr>
                    <td>{{ $e->transaction_date ? date('d M Y', strtotime($e->transaction_date)) : '' }}</td>
                    <td>{{ $e->category }}</td>
                    <td>{{ $e->description }}</td>
                    <td class="right">-${{ number_format((float) $e->amount, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="muted">No rows</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
