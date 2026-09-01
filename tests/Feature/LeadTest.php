<?php

namespace Tests\Feature;

use App\Mail\ContactConfirmationMail;
use App\Mail\ContactRequestMail;
use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LeadTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_quote_request_is_stored_and_notified(): void
    {
        Mail::fake();

        $response = $this->post('/contact', [
            'name' => 'Marie Dupont',
            'phone' => '0470 11 22 33',
            'email' => 'marie@exemple.be',
            'city' => 'Waterloo',
            'property_type' => 'Maison',
            'message' => 'Douze fenêtres et une véranda.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('contactSuccess');

        $lead = Lead::sole();
        $this->assertSame('Marie Dupont', $lead->name);
        $this->assertSame('quote', $lead->kind);
        $this->assertTrue($lead->mail_sent);

        Mail::assertSent(ContactRequestMail::class);
        // Accusé de réception envoyé au prospect quand l'e-mail est fourni.
        Mail::assertSent(ContactConfirmationMail::class);
    }

    public function test_a_callback_request_needs_only_a_name_and_a_phone(): void
    {
        Mail::fake();

        $this->post('/rappel', ['name' => 'Luc', 'phone' => '0499 00 11 22'])
            ->assertSessionHas('contactSuccess');

        $this->assertSame('callback', Lead::sole()->kind);
        Mail::assertNotSent(ContactConfirmationMail::class);
    }

    public function test_the_phone_number_is_required(): void
    {
        Mail::fake();

        $this->post('/contact', ['name' => 'Sans téléphone'])
            ->assertSessionHasErrors('phone');

        $this->assertSame(0, Lead::count());
    }

    public function test_the_honeypot_rejects_bots(): void
    {
        Mail::fake();

        $this->post('/contact', [
            'name' => 'Robot',
            'phone' => '0470 00 00 00',
            'website' => 'http://spam.example',
        ])->assertSessionHasErrors('website');

        $this->assertSame(0, Lead::count());
    }

    public function test_the_lead_survives_a_mail_failure(): void
    {
        Mail::shouldReceive('to')->andThrow(new \RuntimeException('SMTP down'));

        $this->post('/contact', ['name' => 'Sophie', 'phone' => '0470 12 34 56'])
            ->assertSessionHas('contactSuccess');

        $lead = Lead::sole();
        $this->assertSame('Sophie', $lead->name);
        $this->assertFalse($lead->mail_sent);
    }
}
