<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Accusé de réception envoyé au prospect : rassure et réduit les demandes
 * envoyées en parallèle à un concurrent.
 */
class ContactConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $name)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre demande de devis a bien été reçue — '.config('app.name'),
            replyTo: [config('mail.contact_to')],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.confirmation',
            with: ['name' => $this->name],
        );
    }
}
