<?php

namespace App\Mail;

use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PurchaseReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public Sale $sale;

    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Play Games Now - Purchase Receipt #' . $this->sale->id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.purchase-receipt',
            with: [
                'sale' => $this->sale,
            ],
        );
    }

    public function attachments(): array
    {
        $pdf = Pdf::loadView('pdf.purchase-receipt', [
            'sale' => $this->sale,
        ]);

        return [
            Attachment::fromData(
                fn () => $pdf->output(),
                'purchase-receipt-' . $this->sale->id . '.pdf'
            )->withMime('application/pdf'),
        ];
    }
}
