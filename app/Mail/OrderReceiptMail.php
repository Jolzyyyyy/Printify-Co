<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Printify & Co. receipt - ' . ($this->order->order_reference ?: 'Order #' . $this->order->id),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.orders.receipt',
        );
    }

    public function attachments(): array
    {
        if (blank($this->order->receipt_pdf_path)) {
            return [];
        }

        return [
            Attachment::fromStorageDisk('local', $this->order->receipt_pdf_path)
                ->as(($this->order->receipt_number ?: 'printify-receipt') . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
