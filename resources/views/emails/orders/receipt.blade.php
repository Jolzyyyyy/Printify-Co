<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Printify & Co. Receipt</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111827; line-height: 1.5;">
    <h1 style="font-size: 22px; margin-bottom: 4px;">Payment received</h1>
    <p style="margin-top: 0;">Thank you for your order with Printify &amp; Co.</p>

    <p>
        <strong>Order:</strong> {{ $order->order_reference ?? ('#' . $order->id) }}<br>
        <strong>Receipt:</strong> {{ $order->receipt_number ?? 'Pending' }}<br>
        <strong>Total:</strong> PHP {{ number_format((float) $order->total_price, 2) }}<br>
        <strong>Delivery:</strong> {{ data_get($order->checkout_details, 'delivery.name', ucfirst((string) $order->delivery_method)) }}
    </p>

    <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse; margin-top: 18px;">
        <thead>
            <tr>
                <th align="left" style="border-bottom: 1px solid #e5e7eb;">Item</th>
                <th align="center" style="border-bottom: 1px solid #e5e7eb;">Qty</th>
                <th align="right" style="border-bottom: 1px solid #e5e7eb;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td style="border-bottom: 1px solid #f3f4f6;">
                        {{ $item->service_name }}
                        @if ($item->variation_label)
                            <br><small style="color: #6b7280;">{{ $item->variation_label }}</small>
                        @endif
                    </td>
                    <td align="center" style="border-bottom: 1px solid #f3f4f6;">{{ $item->quantity }}</td>
                    <td align="right" style="border-bottom: 1px solid #f3f4f6;">PHP {{ number_format((float) $item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 18px; color: #4b5563;">
        This is a customer receipt for your successful payment. Official tax invoice handling can be added separately if required by your accounting workflow.
    </p>
</body>
</html>
