<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
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
            // Le nom d'expéditeur vient de la fiche société, pas de APP_NAME :
            // un .env resté sur « Laravel » ne doit pas apparaître chez le client.
            from: new Address(config('mail.from.address'), config('company.name')),
            subject: 'Votre demande de devis a bien été reçue — '.config('company.name'),
            replyTo: [config('mail.contact_to')],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.confirmation',
            with: ['name' => $this->name],
        );
    }
}
