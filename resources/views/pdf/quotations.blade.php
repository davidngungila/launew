<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quotations Export</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #111827; }
        .header { border-bottom: 2px solid #10b981; padding-bottom: 12px; margin-bottom: 18px; }
        .brand { font-size: 20px; font-weight: 800; color: #10b981; }
        .muted { color: #6b7280; font-size: 11px; }
        .meta { margin-top: 6px; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; background: #f9fafb; color: #6b7280; font-size: 10px; letter-spacing: .08em; text-transform: uppercase; padding: 10px; border-bottom: 1px solid #e5e7eb; }
        td { padding: 10px; border-bottom: 1px solid #f3f4f6; vertical-align: top; }
        .status { display: inline-block; padding: 4px 10px; border-radius: 999px; font-size: 10px; font-weight: 700; background: #eef2ff; color: #3730a3; }
        .right { text-align: right; }
        .footer { margin-top: 22px; border-top: 1px solid #f3f4f6; padding-top: 12px; text-align: center; color: #9ca3af; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div style="margin-bottom: 6px;">
            <img src="{{ public_path('header-mfumo-lau.png') }}" style="width: 100%; max-height: 90px; object-fit: contain;">
        </div>
        <div class="muted meta">
            Generated at: {{ $generatedAt->format('d M, Y H:i') }}
            @if(!empty($generatedBy))
                · By: {{ $generatedBy->name ?? 'System' }}
            @endif
        </div>
    </div>

    <h2 style="margin:0 0 10px 0; font-size: 14px; font-weight: 800;">Quotations</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 15%;">Quote ID</th>
                <th style="width: 25%;">Client</th>
                <th>Itinerary Brief</th>
                <th style="width: 15%;" class="right">Value</th>
                <th style="width: 15%;" class="right">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach(($quotes ?? []) as $q)
            <tr>
                <td><strong>{{ $q['id'] ?? '' }}</strong></td>
                <td>{{ $q['client'] ?? '' }}</td>
                <td>{{ $q['brief'] ?? '' }}</td>
                <td class="right"><strong>{{ $q['val'] ?? '' }}</strong></td>
                <td class="right"><span class="status">{{ $q['status'] ?? '' }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        This document is system-generated. For support: lauparadiseadventure@gmail.com
    </div>
</body>
</html>
