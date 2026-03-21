<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Dompdf\Dompdf;

class OrderReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $items;
    public $customer;
    public string $emailTitle;
    public string $emailMessage;

    public function __construct($order, $items, $customer, string $emailTitle, string $emailMessage)
    {
        $this->order = $order;
        $this->items = $items;
        $this->customer = $customer;
        $this->emailTitle = $emailTitle;
        $this->emailMessage = $emailMessage;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply@example.test', 'My Store'),
            subject: $this->emailTitle,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'email.order_receipt',
            with: [
                'order' => $this->order,
                'items' => $this->items,
                'customer' => $this->customer,
                'emailMessage' => $this->emailMessage,
            ],
        );
    }

    public function attachments(): array
    {
        $html = view('pdf.receipt', [
            'order' => $this->order,
            'items' => $this->items,
            'customer' => $this->customer,
        ])->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfOutput = $dompdf->output();

        return [
            Attachment::fromData(fn () => $pdfOutput, 'order-receipt.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
