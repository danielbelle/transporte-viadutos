<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use \Illuminate\Mail\Mailables\Attachment;

class ContactUs extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $attachSigned;
    public $attachCollege;

    /**
     * Create a new message instance.
     */
    public function __construct($data, $attachSigned, $attachCollege)
    {
        $this->data = $data;
        $this->attachSigned = $attachSigned;
        $this->attachCollege = $attachCollege;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Formulário Transporte - ' . $this->data['name'] . ' - Mês: ' . $this->data['month'],
            from: new Address('2025014190@aluno.erechim.ifrs.edu.br', 'Formulário Transporte Viadutos'),
            cc: $this->data['email'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.contact',
            with: [
                $this->data['name'],
                $this->data['email'],
                $this->data['month']
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

        return [
            Attachment::fromPath($this->attachSigned),
            Attachment::fromPath($this->attachCollege),
        ];
    }
}
