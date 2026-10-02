<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

/**
 * Avis de la fiche Google Business Profile.
 *
 * Les avis sont récupérés par la commande `reviews:refresh` (lancée à la
 * main) puis enregistrés dans un fichier : les pages ne contactent
 * jamais Google, et une panne de l'API laisse simplement les avis déjà enregistrés.
 */
class GoogleReviews
{
    private const FILE = 'google-reviews.json';

    private const STARS = ['ONE' => 1, 'TWO' => 2, 'THREE' => 3, 'FOUR' => 4, 'FIVE' => 5];

    /**
     * Les cinq valeurs du .env sont-elles renseignées ?
     */
    public static function configured(): bool
    {
        $config = config('services.google_business');

        foreach (['client_id', 'client_secret', 'refresh_token', 'account_id', 'location_id'] as $key) {
            if (empty($config[$key])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Les avis enregistrés, ou null tant qu'aucune récupération n'a réussi.
     *
     * @return array{rating: float, count: int, reviewUrl: ?string, mapsUrl: ?string, reviews: list<array<string, mixed>>}|null
     */
    public static function cached(): ?array
    {
        $disk = Storage::disk('local');

        if (! $disk->exists(self::FILE)) {
            return null;
        }

        $data = json_decode((string) $disk->get(self::FILE), true);

        return is_array($data) && ! empty($data['reviews']) ? $data : null;
    }

    /**
     * Interroge Google et enregistre le résultat.
     *
     * @return array<string, mixed>
     */
    public static function refresh(): array
    {
        if (! self::configured()) {
            throw new RuntimeException('Les variables GOOGLE_BP_* ne sont pas toutes renseignées dans le .env.');
        }

        $config = config('services.google_business');
        // Accepte « 123 » comme « accounts/123 » : les deux formes circulent dans la console Google.
        $account = 'accounts/'.basename($config['account_id']);
        $location = 'locations/'.basename($config['location_id']);

        $token = Http::asForm()
            ->post('https://oauth2.googleapis.com/token', [
                'client_id' => $config['client_id'],
                'client_secret' => $config['client_secret'],
                'refresh_token' => $config['refresh_token'],
                'grant_type' => 'refresh_token',
            ])
            ->throw()
            ->json('access_token');

        $payload = Http::withToken($token)
            ->get("https://mybusiness.googleapis.com/v4/{$account}/{$location}/reviews", [
                'pageSize' => 50,
                'orderBy' => 'updateTime desc',
            ])
            ->throw()
            ->json();

        // Liens « laisser un avis » et « voir la fiche » : facultatifs, on s'en passe en cas d'échec.
        $metadata = Http::withToken($token)
            ->get("https://mybusinessbusinessinformation.googleapis.com/v1/{$location}", ['readMask' => 'metadata'])
            ->json('metadata') ?? [];

        $reviews = [];

        foreach ($payload['reviews'] ?? [] as $review) {
            $rating = self::STARS[$review['starRating'] ?? ''] ?? 0;
            $text = self::originalText($review['comment'] ?? '');

            // On n'affiche que les avis rédigés, de 4 étoiles et plus. La note
            // moyenne, elle, porte sur tous les avis : elle vient telle quelle de Google.
            if ($rating < 4 || $text === '') {
                continue;
            }

            $reviews[] = [
                'author' => $review['reviewer']['displayName'] ?? 'Client Google',
                'photo' => $review['reviewer']['profilePhotoUrl'] ?? null,
                'rating' => $rating,
                'text' => $text,
                'date' => substr((string) ($review['createTime'] ?? ''), 0, 10),
            ];

            if (count($reviews) === (int) $config['max_reviews']) {
                break;
            }
        }

        $data = [
            'rating' => round((float) ($payload['averageRating'] ?? 0), 1),
            'count' => (int) ($payload['totalReviewCount'] ?? 0),
            'reviewUrl' => $metadata['newReviewUri'] ?? null,
            'mapsUrl' => $metadata['mapsUri'] ?? null,
            'reviews' => $reviews,
            'fetchedAt' => now()->toIso8601String(),
        ];

        Storage::disk('local')->put(self::FILE, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        return $data;
    }

    /**
     * Google préfixe les avis traduits : « (Translated by Google) … (Original) … ».
     * On ne garde que le texte écrit par le client.
     */
    private static function originalText(string $comment): string
    {
        if (str_contains($comment, '(Original)')) {
            $comment = substr($comment, strpos($comment, '(Original)') + strlen('(Original)'));
        } elseif (str_contains($comment, '(Translated by Google)')) {
            $comment = substr($comment, 0, strpos($comment, '(Translated by Google)'));
        }

        return trim($comment);
    }
}
