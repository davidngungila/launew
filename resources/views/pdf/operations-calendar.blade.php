<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Operations Calendar Export</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; color: #0f172a; font-size: 12px; }
        .muted { color: #64748b; }
        .title { font-size: 18px; font-weight: 800; letter-spacing: 0.02em; }
        .subtitle { font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: #64748b; }
        .chip { display: inline-block; padding: 4px 8px; border-radius: 999px; font-size: 10px; font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase; }
        .chip-confirmed { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
        .chip-pending { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
        .chip-completed { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .chip-cancelled { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
        table { width: 100%; border-collapse: collapse; margin-top: 14px; }
        th { text-align: left; font-size: 10px; letter-spacing: 0.12em; text-transform: uppercase; color: #64748b; padding: 10px 10px; border-bottom: 1px solid #e2e8f0; }
        td { padding: 10px 10px; border-bottom: 1px solid #f1f5f9; vertical-align: top; }
        .right { text-align: right; }
        .nowrap { white-space: nowrap; }
        .small { font-size: 11px; }
        .bold { font-weight: 800; }
        .grid { width: 100%; margin-top: 10px; }
        .grid td { border: none; padding: 2px 0; }
    </style>
</head>
<body>
    <div>
        <div class="title">Operations Calendar Export</div>
        <div class="subtitle">
            @if(!empty($rangeLabel))
                Range: {{ $rangeLabel }}
            @else
                Range: All
            @endif
            @if(!empty($statusFilter))
                | Status: {{ strtoupper($statusFilter) }}
            @endif
        </div>

        <table class="grid" role="presentation">
            <tr>
                <td class="muted small">Generated</td>
                <td class="small bold">{{ $generatedAt ? $generatedAt->format('d M Y H:i') : '' }}</td>
                <td class="muted small right">By</td>
                <td class="small bold right">{{ $generatedBy->name ?? 'System' }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th class="nowrap">Date</th>
                <th>Client</th>
                <th>Tour</th>
                <th class="nowrap">Status</th>
                <th class="nowrap">PAX</th>
                <th>Guide</th>
                <th>Driver</th>
                <th class="nowrap">Vehicle</th>
                <th class="right nowrap">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                @php
                    $status = $booking->status ?? 'pending';
                    $chip = 'chip-pending';
                    if ($status === 'confirmed') $chip = 'chip-confirmed';
                    if ($status === 'completed') $chip = 'chip-completed';
                    if ($status === 'cancelled') $chip = 'chip-cancelled';
                @endphp
                <tr>
                    <td class="nowrap bold">{{ $booking->start_date ? date('d M Y', strtotime($booking->start_date)) : 'TBD' }}</td>
                    <td>
                        <div class="bold">{{ $booking->customer_name }}</div>
                        <div class="muted small">BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</div>
                    </td>
                    <td>{{ $booking->tour->name ?? 'Safari' }}</td>
                    <td class="nowrap"><span class="chip {{ $chip }}">{{ $status }}</span></td>
                    <td class="nowrap">{{ (int) ($booking->adults ?? 0) + (int) ($booking->children ?? 0) }}</td>
                    <td>{{ $booking->guide->name ?? 'Unassigned' }}</td>
                    <td>{{ $booking->driver->name ?? 'Unassigned' }}</td>
                    <td class="nowrap">{{ $booking->vehicle->plate_number ?? 'Unassigned' }}</td>
                    <td class="right nowrap bold">${{ number_format((float) ($booking->total_price ?? 0), 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="muted">No bookings found for this range.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
