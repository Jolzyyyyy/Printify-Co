<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Developer Dashboard Report</title>
    <style>
        body{font-family:DejaVu Sans,Arial,sans-serif;color:#111827;font-size:11px;margin:24px}
        h1{font-size:20px;margin:0 0 4px}
        h2{font-size:13px;margin:18px 0 8px;color:#111827}
        p{margin:0 0 14px;color:#475569}
        .summary{width:100%;border-collapse:collapse;margin:0 0 16px}
        .summary td{border:1px solid #d8dee8;padding:7px 8px;width:25%}
        .summary small{display:block;color:#64748b;text-transform:uppercase;font-size:8px;font-weight:bold}
        .summary strong{display:block;margin-top:3px;font-size:13px}
        table.report{width:100%;border-collapse:collapse}
        .report th{background:#f1f5f9;border:1px solid #d8dee8;padding:7px 6px;text-align:left;font-size:9px;text-transform:uppercase}
        .report td{border:1px solid #e5e7eb;padding:6px}
        .number{text-align:right}
        .muted{color:#64748b}
        .empty{border:1px dashed #d8dee8;padding:10px;color:#64748b;margin-bottom:10px}
    </style>
</head>
<body>
    <h1>Developer Dashboard Report</h1>
    <p>
        Generated {{ $generatedAt->format('F d, Y h:i A') }}
        @if(($filters['date_from'] ?? null) || ($filters['date_to'] ?? null))
            | Date range:
            {{ optional($filters['date_from'] ?? null)->format('M d, Y') ?: 'Start' }}
            to
            {{ optional($filters['date_to'] ?? null)->format('M d, Y') ?: 'Today' }}
        @endif
        @if($filters['search'] ?? null)
            | Search: {{ $filters['search'] }}
        @endif
        @if($filters['status'] ?? null)
            | Status: {{ \Illuminate\Support\Str::headline($filters['status']) }}
        @endif
    </p>

    @foreach([
        'Business Health Summary' => $report['businessHealth'] ?? [],
        'Access and Users Summary' => $report['accessUsers'] ?? [],
        'Operations Summary' => $report['operations'] ?? [],
        'Financial Summary' => $report['financial'] ?? [],
    ] as $title => $items)
        <h2>{{ $title }}</h2>
        <table class="summary">
            @foreach(collect($items)->chunk(4) as $chunk)
                <tr>
                    @foreach($chunk as $label => $value)
                        <td>
                            <small>{{ $label }}</small>
                            <strong>{{ is_numeric($value) ? number_format($value) : $value }}</strong>
                        </td>
                    @endforeach
                    @for($i = $chunk->count(); $i < 4; $i++)
                        <td></td>
                    @endfor
                </tr>
            @endforeach
            @if(empty($items))
                <tr><td>No summary data available.</td></tr>
            @endif
        </table>
    @endforeach

    <h2>All Dashboard KPIs</h2>
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

    <h2>Top Businesses</h2>
    <table class="report">
        <thead><tr><th>Business</th><th>Admin Client</th><th>Status</th><th class="number">Orders</th><th class="number">Revenue</th></tr></thead>
        <tbody>
            @forelse($report['topBusinesses'] ?? [] as $businessRow)
                <tr>
                    <td>{{ $businessRow['business_name'] }}</td>
                    <td>{{ $businessRow['admin_client'] }}</td>
                    <td>{{ $businessRow['status'] }}</td>
                    <td class="number">{{ number_format($businessRow['orders']) }}</td>
                    <td class="number">PHP {{ number_format((float) $businessRow['revenue'], 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="5">No business records found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Business Performance Table</h2>
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

    <h2>Recent Payment Issues</h2>
    <table class="report">
        <thead><tr><th>Reference</th><th>Business / Customer</th><th>Status</th><th class="number">Amount</th></tr></thead>
        <tbody>
            @forelse($report['recentPayments'] ?? [] as $payment)
                @php($isPayment = $payment instanceof \App\Models\Payment)
                <tr>
                    <td>{{ $isPayment ? ($payment->gateway_reference ?: $payment->order?->order_reference ?: '#'.$payment->id) : ($payment->payment_reference ?: $payment->order_reference ?: '#'.$payment->id) }}</td>
                    <td>{{ $isPayment ? ($payment->business?->name ?: $payment->customer?->name ?: 'Unassigned') : ($payment->adminClient?->name ?: $payment->customer_name ?: 'Unassigned') }}</td>
                    <td>{{ \Illuminate\Support\Str::headline($isPayment ? $payment->status : $payment->status) }}</td>
                    <td class="number">PHP {{ number_format((float) ($isPayment ? $payment->amount : $payment->total_price), 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No payments found for this period.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Recent Cancellations</h2>
    <table class="report">
        <thead><tr><th>Order</th><th>Customer</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
            @forelse($report['recentCancellations'] ?? [] as $order)
                <tr><td>{{ $order->order_reference ?: '#'.$order->id }}</td><td>{{ $order->user?->name ?: $order->customer_name ?: 'Customer' }}</td><td>{{ \Illuminate\Support\Str::headline($order->status) }}</td><td>{{ optional($order->created_at)->format('M d, Y') }}</td></tr>
            @empty
                <tr><td colspan="4">No cancellations found for this period.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Recent Deliveries</h2>
    <table class="report">
        <thead><tr><th>Tracking</th><th>Customer</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
            @forelse($report['recentDeliveries'] ?? [] as $delivery)
                @php($isDelivery = $delivery instanceof \App\Models\Delivery)
                <tr>
                    <td>{{ $isDelivery ? ($delivery->tracking_reference ?: $delivery->order?->order_reference ?: '#'.$delivery->id) : ($delivery->delivery_tracking_number ?: $delivery->order_reference ?: '#'.$delivery->id) }}</td>
                    <td>{{ $isDelivery ? ($delivery->customer?->name ?: 'Customer') : ($delivery->user?->name ?: $delivery->customer_name ?: 'Customer') }}</td>
                    <td>{{ \Illuminate\Support\Str::headline($isDelivery ? $delivery->status : ($delivery->delivery_booking_status ?: $delivery->lalamove_status ?: 'Recorded')) }}</td>
                    <td>{{ optional($isDelivery ? ($delivery->booked_at ?: $delivery->created_at) : ($delivery->delivery_booked_at ?: $delivery->created_at))->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No deliveries found for this period.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Audit Log Summary</h2>
    <table class="report">
        <thead><tr><th>Action</th><th>Actor</th><th>Business</th><th>Date</th></tr></thead>
        <tbody>
            @forelse($report['recentAuditLogs'] ?? [] as $log)
                <tr><td>{{ \Illuminate\Support\Str::headline($log->action ?? 'Activity') }}</td><td>{{ $log->actor?->name ?: 'System' }}</td><td>{{ $log->business?->name ?: 'Platform' }}</td><td>{{ optional($log->created_at)->format('M d, Y') }}</td></tr>
            @empty
                <tr><td colspan="4">No audit logs found.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
