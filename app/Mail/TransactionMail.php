<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
class TransactionMail extends Mailable
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
    //         from: new Address('jeanlobo94@gmail.com', 'Custom Sender Name'), // Different 'from' address
    //         to: [new Address($this->details['email'])],
    //         subject: 'Promotion Transaction Mail'
    //     );

        // return new Envelope(
            // from: ['address' => 'lobojeanz@gmail.com', 'name' => 'Makita-ERP'], 
            // from: new Address('lobojeanz@gmail.com', 'Makita-ERP'),
        //     subject: 'Promotion Transaction Mail',
        // );

        // return new Envelope(
        //     // from: new Address('lobojeanz@gmail.com', 'Makita-ERP'),
        //     sender: new Address('lobojeanz@gmail.com', 'Makita-ERP'),
        //     to: [new Address($this->details['email'])], 
        //     cc: [new Address($this->details['cc'])], 
        //     bcc : [new Address($this->details['bcc'])],
        //     subject: 'Promotion Transaction Mail',
        // );
    // }

    /**
     * Get the message content definition.
     */

    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'mails.transactionmail',
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
        return $this->from(TEST_PROMO_TRANSACTION_FROM_EMAILS,'RM')  // SMTP sender for sending
                    //->replyTo(TEST_PROMO_TRANSACTION_FROM_EMAILS, 'Custom Sender Name') // Reply-to email displayed to receiver
                    ->subject('Promotion Transaction Mail')
                    ->view('mails.transactionmail')
                    ->with(['details' => $this->details])
                    ->withSwiftMessage(function ($message) {
                        $message->getHeaders()
                                ->addTextHeader('RM', TEST_PROMO_TRANSACTION_FROM_EMAILS);  // Add custom "Sender" header
                    });
    }

 
}
