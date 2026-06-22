<?php

namespace App\Services;

use App\Mail\OrderReceiptMail;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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

        $order = $this->ensurePdfReceipt($order->fresh('items') ?? $order);

        Mail::to($order->customer_email)->send(new OrderReceiptMail($order->fresh('items') ?? $order));

        $order->forceFill(['receipt_sent_at' => now()])->save();
    }

    private function ensurePdfReceipt(Order $order): Order
    {
        if (filled($order->receipt_pdf_path) && Storage::disk('local')->exists($order->receipt_pdf_path)) {
            return $order;
        }

        $path = 'receipts/' . now()->format('Y/m') . '/' . ($order->receipt_number ?: $this->makeReceiptNumber($order)) . '.pdf';
        $pdf = Pdf::loadView('pdf.orders.receipt', [
            'order' => $order->fresh('items') ?? $order,
        ])->setPaper('a4');

        Storage::disk('local')->put($path, $pdf->output());

        $order->forceFill(['receipt_pdf_path' => $path])->save();

        return $order->fresh('items') ?? $order;
    }

    private function makeReceiptNumber(Order $order): string
    {
        return 'RCPT-' . now()->format('Ymd') . '-' . Str::padLeft((string) $order->id, 6, '0');
    }
}
