<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PromoMail extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    /**
     * Create a new message instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Promotion Mail',
    //     );
    // }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
        // return new Content(
        //     view: 'mails.promomail',
        // );

    //     return new Content(
    //         view: 'mails.promomail',
    //         with: ['details' => $this->details], 
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this->from(PROMO_FROM,'MD')  // SMTP sender for sending
                    ->replyTo(PROMO_FROM, 'MD') // Reply-to email displayed to receiver
                    ->subject('MakitaERP - Promotion Mail')
                    ->view('mails.promomail')
                    ->with(['details' => $this->details])
                    ->withSwiftMessage(function ($message) {
                        $message->getHeaders()
                                ->addTextHeader('MD', PROMO_FROM);  // Add custom "Sender" header
                    });
    }
}


