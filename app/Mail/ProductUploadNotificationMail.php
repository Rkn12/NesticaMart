<?php

namespace App\Mail;

use App\Models\Seller;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProductUploadNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $seller;
    public $product;

    /**
     * Create a new message instance.
     */
    public function __construct(Seller $seller, Product $product)
    {
        $this->seller = $seller;
        $this->product = $product;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📦 Produk Berhasil Diupload - MartPlace',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.product-upload-notification',
            with: [
                'seller' => $this->seller,
                'product' => $this->product,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
