<?php

namespace App\Http\Controllers;

use App\Mail\ContactConfirmationMail;
use App\Mail\ContactRequestMail;
use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Formulaire de devis complet.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'company' => ['nullable', 'string', 'max:120'],
            // Le téléphone est requis : c'est le canal qui convertit le mieux.
            // L'e-mail reste facultatif pour réduire la friction du formulaire.
            'phone' => ['required', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:160'],
            'service' => ['nullable', 'string', 'max:80'],
            'property_type' => ['nullable', 'string', 'max:40'],
            'city' => ['nullable', 'string', 'max:80'],
            'message' => ['nullable', 'string', 'max:4000'],
            // Honeypot — doit rester vide.
            'website' => ['nullable', 'size:0'],
        ], [
            'name.required' => 'Merci d\'indiquer votre nom.',
            'phone.required' => 'Un numéro de téléphone nous permet de vous rappeler rapidement.',
            'email.email' => 'Cette adresse e-mail ne semble pas valide.',
        ]);

        return $this->handle($request, $data, 'quote');
    }

    /**
     * Rappel express : nom + téléphone uniquement.
     */
    public function callback(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:40'],
            'website' => ['nullable', 'size:0'],
        ], [
            'name.required' => 'Merci d\'indiquer votre nom.',
            'phone.required' => 'Indiquez votre numéro pour être rappelé.',
        ]);

        return $this->handle($request, $data, 'callback');
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function handle(Request $request, array $data, string $kind): RedirectResponse
    {
        unset($data['website']);

        // Le lead est d'abord persisté : même si l'envoi d'e-mail échoue,
        // la demande n'est jamais perdue.
        $lead = Lead::create([
            ...$data,
            'kind' => $kind,
            'source_page' => substr((string) $request->headers->get('referer'), 0, 255),
            'ip' => $request->ip(),
        ]);

        try {
            Mail::to(config('mail.contact_to'))->send(new ContactRequestMail($data, $kind));

            if (! empty($data['email'])) {
                Mail::to($data['email'])->send(new ContactConfirmationMail($data['name']));
            }

            $lead->update(['mail_sent' => true]);
        } catch (\Throwable $e) {
            // On n'expose pas l'erreur au visiteur : le lead est déjà enregistré.
            Log::error('Envoi du mail de contact impossible', ['lead' => $lead->id, 'error' => $e->getMessage()]);
        }

        return back()->with('contactSuccess', true);
    }
}
