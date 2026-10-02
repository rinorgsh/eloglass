<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array<string, mixed>  $data
     * @param  string  $kind  'quote' (formulaire complet) ou 'callback' (rappel express)
     */
    public function __construct(public array $data, public string $kind = 'quote')
    {
    }

    public function envelope(): Envelope
    {
        $prefix = $this->kind === 'callback' ? 'Demande de rappel' : 'Nouvelle demande de devis';

        return new Envelope(
            // Le nom d'expéditeur vient de la fiche société, pas de APP_NAME :
            // un .env resté sur « Laravel » ne doit pas apparaître chez le client.
            from: new Address(config('mail.from.address'), config('company.name')),
            subject: $prefix.' — '.($this->data['name'] ?? 'Contact').' · '.($this->data['phone'] ?? ''),
            replyTo: array_filter([$this->data['email'] ?? null]),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.contact',
            with: ['data' => $this->data, 'kind' => $this->kind],
        );
    }
}
