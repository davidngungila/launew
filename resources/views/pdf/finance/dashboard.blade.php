<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Finance Dashboard</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #0f172a; }
        .h1 { font-size: 18px; font-weight: 800; margin: 0; }
        .muted { color: #64748b; }
        .grid { width: 100%; border-collapse: collapse; }
        .grid th, .grid td { border-bottom: 1px solid #e2e8f0; padding: 8px; text-align: left; }
        .kpi { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .kpi td { border: 1px solid #e2e8f0; padding: 10px; }
        .label { font-size: 10px; text-transform: uppercase; letter-spacing: 0.12em; color: #64748b; font-weight: 800; }
        .value { font-size: 16px; font-weight: 800; margin-top: 6px; }
        .right { text-align: right; }
    </style>
</head>
<body>
    <div>
        <div class="h1">Finance Dashboard</div>
        <div class="muted">Generated {{ now()->format('d M Y H:i') }}</div>
    </div>

    <table class="kpi">
        <tr>
            <td>
                <div class="label">Income (MTD)</div>
                <div class="value">${{ number_format((float) ($stats['income_mtd'] ?? 0), 2) }}</div>
            </td>
            <td>
                <div class="label">Expenses (MTD)</div>
                <div class="value">-${{ number_format((float) ($stats['expense_mtd'] ?? 0), 2) }}</div>
            </td>
            <td>
                <div class="label">Net Cashflow (MTD)</div>
                <div class="value">${{ number_format((float) ($stats['net_cashflow_mtd'] ?? 0), 2) }}</div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label">Deposit Due (Estimate)</div>
                <div class="value">${{ number_format((float) ($stats['deposit_estimate'] ?? 0), 2) }}</div>
            </td>
            <td>
                <div class="label">Outstanding (Estimate)</div>
                <div class="value">${{ number_format((float) ($stats['outstanding_estimate'] ?? 0), 2) }}</div>
            </td>
            <td>
                <div class="label">Period</div>
                <div class="value">{{ ($stats['month_start'] ?? now()->startOfMonth())->format('d M') }} - {{ ($stats['month_end'] ?? now()->endOfMonth())->format('d M Y') }}</div>
            </td>
        </tr>
    </table>

    <h3 style="margin-top:18px; margin-bottom:6px;">Recent Transactions</h3>
    <table class="grid">
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Description</th>
                <th>Category</th>
                <th class="right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentTransactions as $t)
                <tr>
                    <td>{{ $t->transaction_date ? date('d M Y', strtotime($t->transaction_date)) : '' }}</td>
                    <td>{{ strtoupper($t->type) }}</td>
                    <td>{{ $t->description }}</td>
                    <td>{{ $t->category }}</td>
                    <td class="right">{{ $t->type === 'income' ? '+' : '-' }}${{ number_format((float) $t->amount, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="muted">No transactions</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
