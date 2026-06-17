<?php

namespace App\Services;

use App\Mail\OrderReceiptMail;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutReceiptService
{
    public function send(Order $order): void
    {
        if ($order->receipt_sent_at || blank($order->customer_email)) {
            return;
        }

        if (blank($order->receipt_number)) {
            $order->forceFill([
                'receipt_number' => $this->makeReceiptNumber($order),
            ])->save();
        }

        Mail::to($order->customer_email)->send(new OrderReceiptMail($order->fresh('items') ?? $order));

        $order->forceFill(['receipt_sent_at' => now()])->save();
    }

    private function makeReceiptNumber(Order $order): string
    {
        return 'RCPT-' . now()->format('Ymd') . '-' . Str::padLeft((string) $order->id, 6, '0');
    }
}
