<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $order->receipt_number ?? 'Receipt' }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #111827; font-size: 12px; line-height: 1.45; }
        .header { border-bottom: 3px solid #ff7a00; padding-bottom: 14px; margin-bottom: 22px; }
        .brand { font-size: 24px; font-weight: 700; color: #111827; }
        .muted { color: #6b7280; }
        .grid { width: 100%; margin-bottom: 18px; }
        .grid td { vertical-align: top; width: 50%; }
        .box { border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 16px; }
        table.items th { text-align: left; border-bottom: 1px solid #d1d5db; padding: 9px 6px; }
        table.items td { border-bottom: 1px solid #f3f4f6; padding: 9px 6px; }
        .right { text-align: right; }
        .center { text-align: center; }
        .total { font-size: 16px; font-weight: 700; }
        .footer { margin-top: 24px; color: #6b7280; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="brand">Printify &amp; Co.</div>
        <div class="muted">Customer payment receipt</div>
    </div>

    <table class="grid">
        <tr>
            <td>
                <div class="box">
                    <strong>Receipt</strong><br>
                    Receipt No: {{ $order->receipt_number ?? 'Pending' }}<br>
                    Order Ref: {{ $order->order_reference ?? ('#' . $order->id) }}<br>
                    Paid At: {{ optional($order->paid_at)->format('M d, Y h:i A') ?? 'Pending' }}<br>
                    Payment Ref: {{ $order->payment_reference ?? 'Pending' }}
                </div>
            </td>
            <td>
                <div class="box">
                    <strong>Customer</strong><br>
                    {{ $order->customer_name }}<br>
                    {{ $order->customer_email }}<br>
                    {{ $order->customer_phone }}
                </div>
            </td>
        </tr>
    </table>

    <div class="box">
        <strong>Delivery</strong><br>
        {{ data_get($order->checkout_details, 'delivery.name', ucfirst((string) $order->delivery_method)) }}<br>
        @if ($order->delivery_address)
            <span class="muted">{{ $order->delivery_address }}</span>
        @else
            <span class="muted">Store pickup. No shipping address required.</span>
        @endif
    </div>

    <table class="items">
        <thead>
            <tr>
                <th>Item</th>
                <th class="center">Qty</th>
                <th class="right">Unit Price</th>
                <th class="right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->service_name }}</strong>
                        @if ($item->variation_label)
                            <br><span class="muted">{{ $item->variation_label }}</span>
                        @endif
                        @if ($item->service_item_id)
                            <br><span class="muted">Service ID: {{ $item->service_item_id }}</span>
                        @endif
                    </td>
                    <td class="center">{{ $item->quantity }}</td>
                    <td class="right">PHP {{ number_format((float) $item->unit_price, 2) }}</td>
                    <td class="right">PHP {{ number_format((float) $item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="right total">Total</td>
                <td class="right total">PHP {{ number_format((float) $order->total_price, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        This PDF is a customer payment receipt generated from the saved Printify &amp; Co. order record.
        Official tax invoicing and BIR reporting can be implemented as a separate compliance module.
    </div>
</body>
</html>
