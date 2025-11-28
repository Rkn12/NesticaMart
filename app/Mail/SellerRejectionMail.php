<?php

namespace App\Mail;

use App\Models\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SellerRejectionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $seller;
    public $rejectionReason;

    /**
     * Create a new message instance.
     */
    public function __construct(Seller $seller, string $rejectionReason = '')
    {
        $this->seller = $seller;
        $this->rejectionReason = $rejectionReason;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pemberitahuan Penolakan - Registrasi Penjual MartPlace',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.seller-rejection',
            with: [
                'seller' => $this->seller,
                'rejectionReason' => $this->rejectionReason,
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
