<?php

namespace Tests\Feature;

use App\Support\GoogleReviews;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class GoogleReviewsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');

        // Les tests ne dépendent pas des identifiants réels du .env.
        config(['services.google_business' => [
            'client_id' => null,
            'client_secret' => null,
            'refresh_token' => null,
            'account_id' => null,
            'location_id' => null,
            'max_reviews' => 6,
        ]]);
    }

    private function configure(): void
    {
        config(['services.google_business' => [
            'client_id' => 'id',
            'client_secret' => 'secret',
            'refresh_token' => 'refresh',
            'account_id' => 'accounts/111',
            'location_id' => '222',
            'max_reviews' => 6,
        ]]);
    }

    public function test_the_section_is_hidden_until_reviews_are_fetched(): void
    {
        $this->get('/')->assertInertia(
            fn (AssertableInertia $page) => $page->where('googleReviews', null),
        );
    }

    public function test_the_command_does_nothing_without_credentials(): void
    {
        Http::fake();

        $this->artisan('reviews:refresh')->assertExitCode(0);

        Http::assertNothingSent();
        $this->assertNull(GoogleReviews::cached());
    }

    public function test_reviews_are_fetched_filtered_and_shown(): void
    {
        $this->configure();

        Http::fake([
            'oauth2.googleapis.com/*' => Http::response(['access_token' => 'token']),
            'mybusiness.googleapis.com/v4/accounts/111/locations/222/reviews*' => Http::response([
                'averageRating' => 4.66,
                'totalReviewCount' => 3,
                'reviews' => [
                    ['reviewer' => ['displayName' => 'Marie'], 'starRating' => 'FIVE', 'comment' => '(Translated by Google) Very clean (Original) Très propre', 'createTime' => '2026-09-12T10:00:00Z'],
                    ['reviewer' => ['displayName' => 'Luc'], 'starRating' => 'FIVE', 'createTime' => '2026-09-01T10:00:00Z'],
                    ['reviewer' => ['displayName' => 'Paul'], 'starRating' => 'TWO', 'comment' => 'Bof', 'createTime' => '2026-08-01T10:00:00Z'],
                ],
            ]),
            'mybusinessbusinessinformation.googleapis.com/*' => Http::response([
                'metadata' => ['newReviewUri' => 'https://g.page/r/abc/review', 'mapsUri' => 'https://maps.google.com/?cid=1'],
            ]),
        ]);

        $this->artisan('reviews:refresh')->assertExitCode(0);

        $data = GoogleReviews::cached();

        // La note moyenne porte sur tous les avis ; seuls les avis rédigés de 4 étoiles et plus sont listés.
        $this->assertSame(4.7, $data['rating']);
        $this->assertSame(3, $data['count']);
        $this->assertCount(1, $data['reviews']);
        $this->assertSame('Très propre', $data['reviews'][0]['text']);
        $this->assertSame('https://g.page/r/abc/review', $data['reviewUrl']);

        $this->get('/')->assertInertia(
            fn (AssertableInertia $page) => $page->where('googleReviews.reviews.0.author', 'Marie'),
        );
    }

    public function test_a_google_failure_keeps_the_previous_reviews(): void
    {
        $this->configure();

        Storage::disk('local')->put('google-reviews.json', json_encode([
            'rating' => 5.0, 'count' => 1, 'reviewUrl' => null, 'mapsUrl' => null,
            'reviews' => [['author' => 'Marie', 'photo' => null, 'rating' => 5, 'text' => 'Parfait', 'date' => '2026-09-12']],
        ]));

        Http::fake(['*' => Http::response(['error' => 'invalid_grant'], 400)]);

        $this->artisan('reviews:refresh')->assertExitCode(1);

        $this->assertSame('Parfait', GoogleReviews::cached()['reviews'][0]['text']);
    }
}
