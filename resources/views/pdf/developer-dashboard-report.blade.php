<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Developer Dashboard Report</title>
    <style>
        body{font-family:DejaVu Sans,Arial,sans-serif;color:#111827;font-size:11px;margin:24px}
        h1{font-size:20px;margin:0 0 4px}
        p{margin:0 0 14px;color:#475569}
        .summary{width:100%;border-collapse:collapse;margin:0 0 16px}
        .summary td{border:1px solid #d8dee8;padding:7px 8px;width:25%}
        .summary small{display:block;color:#64748b;text-transform:uppercase;font-size:8px;font-weight:bold}
        .summary strong{display:block;margin-top:3px;font-size:13px}
        table.report{width:100%;border-collapse:collapse}
        .report th{background:#f1f5f9;border:1px solid #d8dee8;padding:7px 6px;text-align:left;font-size:9px;text-transform:uppercase}
        .report td{border:1px solid #e5e7eb;padding:6px}
        .number{text-align:right}
    </style>
</head>
<body>
    <h1>Developer Dashboard Report</h1>
    <p>Generated {{ $generatedAt->format('F d, Y h:i A') }}</p>

    <table class="summary">
        @foreach(collect($dashboard['kpis'] ?? [])->chunk(4) as $chunk)
            <tr>
                @foreach($chunk as $kpi)
                    <td>
                        <small>{{ $kpi['label'] }}</small>
                        <strong>{{ is_numeric($kpi['value']) ? number_format($kpi['value']) : $kpi['value'] }}</strong>
                    </td>
                @endforeach
                @for($i = $chunk->count(); $i < 4; $i++)
                    <td></td>
                @endfor
            </tr>
        @endforeach
    </table>

    <table class="report">
        <thead>
            <tr>
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
                <tr>
                    @foreach($headers as $header)
                        <td class="{{ in_array($header, ['Customers', 'Orders', 'Completed', 'Cancelled', 'Sales', 'Revenue', 'Payment Issues'], true) ? 'number' : '' }}">
                            {{ $row[$header] ?? '' }}
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) }}">No businesses match the selected filters.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
