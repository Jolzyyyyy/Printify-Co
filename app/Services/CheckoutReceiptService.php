<?php

namespace App\Services;

use App\Mail\OrderReceiptMail;
use App\Models\Order;
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
        Storage::disk('local')->put($path, $this->renderReceiptPdf($order));

        $order->forceFill(['receipt_pdf_path' => $path])->save();

        return $order->fresh('items') ?? $order;
    }

    private function renderReceiptPdf(Order $order): string
    {
        $order = $order->fresh('items') ?? $order;

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.orders.receipt', [
                'order' => $order,
            ])->setPaper('a4')->output();
        }

        return $this->renderBasicPdf($order);
    }

    private function renderBasicPdf(Order $order): string
    {
        $order->loadMissing('items');

        $lines = [
            'Printify & Co. Customer Payment Receipt',
            'Receipt No: ' . ($order->receipt_number ?: $this->makeReceiptNumber($order)),
            'Order Ref: ' . ($order->order_reference ?: '#' . $order->id),
            'Paid At: ' . (optional($order->paid_at)->format('M d, Y h:i A') ?: 'Pending'),
            'Payment Ref: ' . ($order->payment_reference ?: 'Pending'),
            'Customer: ' . trim((string) $order->customer_name),
            'Email: ' . trim((string) $order->customer_email),
            'Phone: ' . trim((string) $order->customer_phone),
            'Delivery: ' . (data_get($order->checkout_details, 'delivery.name') ?: ucfirst((string) $order->delivery_method)),
            'Address: ' . ($order->delivery_address ?: 'Store pickup / no shipping address required'),
            '',
            'Items:',
        ];

        foreach ($order->items as $item) {
            $lines[] = sprintf(
                '- %s | Qty: %s | Unit: PHP %s | Subtotal: PHP %s',
                $item->service_name ?: 'Print Service',
                (int) $item->quantity,
                number_format((float) $item->unit_price, 2),
                number_format((float) $item->subtotal, 2)
            );

            if ($item->variation_label) {
                $lines[] = '  ' . $item->variation_label;
            }
        }

        $lines[] = '';
        $lines[] = 'Total Paid: PHP ' . number_format((float) $order->total_price, 2);
        $lines[] = 'Generated from the saved Printify & Co. order record.';

        return $this->buildBasicPdf($lines);
    }

    private function buildBasicPdf(array $lines): string
    {
        $content = "BT\n/F1 10 Tf\n50 800 Td\n14 TL\n";

        foreach ($lines as $line) {
            $content .= '(' . $this->escapePdfText(mb_substr((string) $line, 0, 110)) . ") Tj\nT*\n";
        }

        $content .= "ET\n";

        $objects = [
            "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n",
            "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n",
            "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>\nendobj\n",
            "4 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n",
            "5 0 obj\n<< /Length " . strlen($content) . " >>\nstream\n" . $content . "endstream\nendobj\n",
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object;
        }

        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";

        foreach (array_slice($offsets, 1) as $offset) {
            $pdf .= sprintf("%010d 00000 n \n", $offset);
        }

        $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\n";
        $pdf .= "startxref\n" . $xrefOffset . "\n%%EOF\n";

        return $pdf;
    }

    private function escapePdfText(string $text): string
    {
        return str_replace(['\\', '(', ')', "\r", "\n"], ['\\\\', '\\(', '\\)', ' ', ' '], $text);
    }
    private function makeReceiptNumber(Order $order): string
    {
        return 'RCPT-' . now()->format('Ymd') . '-' . Str::padLeft((string) $order->id, 6, '0');
    }
}
