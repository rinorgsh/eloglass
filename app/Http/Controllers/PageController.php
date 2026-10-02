<?php

namespace App\Http\Controllers;

use App\Support\GoogleReviews;
use App\Support\Seo;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function home(): Response
    {
        $meta = Seo::meta(
            title: 'Nettoyage de maisons, de bureaux et de vitres à Bruxelles | Clean Company',
            description: 'Clean Company nettoie les maisons, les bureaux, les commerces et les vitres à Bruxelles et en périphérie. Ménage régulier, grand nettoyage, après chantier. Devis gratuit sous 24 h : 0484 15 20 73.',
            path: '/',
        );

        $this->shareSeo($meta, [
            Seo::faqNode(config('site.faq'), $meta['canonical']),
        ]);

        return Inertia::render('Landing', [
            'seo' => $meta,
            'services' => config('site.services'),
            'families' => config('site.families'),
            'partners' => config('site.partners'),
            'googleReviews' => GoogleReviews::cached(),
            'zones' => $this->zoneLinks(),
            'faq' => config('site.faq'),
        ]);
    }

    public function zone(string $slug): Response
    {
        $zone = collect(config('site.zones'))->firstWhere('slug', $slug);

        abort_if($zone === null, 404);

        $path = '/nettoyage/'.$zone['slug'];

        $meta = Seo::meta(
            title: 'Nettoyage à '.$zone['city'].' ('.$zone['postal'].') : maisons, bureaux, vitres | Clean Company',
            description: 'Société de nettoyage à '.$zone['city'].' : ménage, grand nettoyage, bureaux, commerces, parties communes et vitres. Devis gratuit sous 24 h : 0484 15 20 73.',
            path: $path,
            breadcrumbs: [
                ['name' => 'Accueil', 'url' => '/'],
                ['name' => 'Communes desservies', 'url' => '/nettoyage'],
                ['name' => $zone['city'], 'url' => $path],
            ],
        );

        $faq = $this->localFaq($zone);

        $this->shareSeo($meta, [
            Seo::localServiceNode(
                $zone,
                $meta['canonical'],
                description: 'Nettoyage de maisons, de bureaux, de commerces et de parties communes à '.$zone['city']
                    .' : ménage régulier, grand nettoyage, sanitaires, sols et nettoyage après chantier.',
            ),
            Seo::localServiceNode(
                $zone,
                $meta['canonical'],
                serviceType: 'Lavage de vitres',
                anchor: 'service-vitres',
            ),
            Seo::faqNode($faq, $meta['canonical']),
        ]);

        return Inertia::render('Zone', [
            'seo' => $meta,
            'zone' => $zone,
            'services' => config('site.services'),
            'families' => config('site.families'),
            'faq' => $faq,
            'zones' => $this->zoneLinks($zone),
        ]);
    }

    public function zones(): Response
    {
        $meta = Seo::meta(
            title: 'Communes desservies : nettoyage à Bruxelles et en périphérie | Clean Company',
            description: 'Clean Company intervient dans les 19 communes bruxelloises et en périphérie : Londerzeel, Grimbergen, Dilbeek, Zaventem, Tervuren, Overijse, Waterloo. Maisons, bureaux, commerces et vitres. Devis gratuit sous 24 h.',
            path: '/nettoyage',
            breadcrumbs: [
                ['name' => 'Accueil', 'url' => '/'],
                ['name' => 'Communes desservies', 'url' => '/nettoyage'],
            ],
        );

        $this->shareSeo($meta);

        return Inertia::render('Zones', [
            'seo' => $meta,
            'zones' => config('site.zones'),
        ]);
    }

    public function legal(): Response
    {
        $meta = Seo::meta(
            title: 'Mentions légales | Clean Company',
            description: 'Mentions légales et informations d\'entreprise de Clean Company, société de nettoyage établie à Londerzeel (BCE 1043.205.603).',
            path: '/mentions-legales',
            breadcrumbs: [
                ['name' => 'Accueil', 'url' => '/'],
                ['name' => 'Mentions légales', 'url' => '/mentions-legales'],
            ],
            index: false,
        );

        $this->shareSeo($meta);

        return Inertia::render('Legal', ['seo' => $meta]);
    }

    /**
     * Liens vers les autres pages locales (maillage interne).
     *
     * @return list<array{slug: string, city: string, postal: string}>
     */
    private function zoneLinks(?array $current = null): array
    {
        return collect(config('site.zones'))
            ->when($current !== null, fn ($c) => $c
                ->where('slug', '!=', $current['slug'])
                // Les communes de la même zone remontent en premier : ce sont
                // celles qui intéressent réellement le visiteur.
                ->sortByDesc(fn ($z) => $z['province'] === $current['province'] ? 1 : 0)
            )
            ->map(fn ($z) => [
                'slug' => $z['slug'],
                'city' => $z['city'],
                'postal' => $z['postal'],
                'province' => $z['province'],
            ])
            ->values()
            ->all();
    }

    /**
     * FAQ locale : deux questions propres à la commune, puis le socle commun.
     * Cela évite un contenu strictement identique d'une page locale à l'autre.
     *
     * @param  array<string, mixed>  $zone
     * @return list<array{q: string, a: string}>
     */
    private function localFaq(array $zone): array
    {
        $city = $zone['city'];
        $areas = implode(', ', $zone['areas']);

        $local = [
            [
                'q' => 'Intervenez-vous dans tous les quartiers de '.$city.' ?',
                'a' => 'Oui, nous couvrons l\'ensemble de la commune de '.$city.' ('.$zone['postal'].'), y compris '.$areas.'. Le déplacement est compris dans le prix annoncé, sans frais kilométriques.',
            ],
            [
                'q' => 'Sous quel délai pouvez-vous intervenir à '.$city.' ?',
                'a' => 'Nous répondons à votre demande sous 24 h ouvrables et proposons généralement un créneau dans la semaine. Pour un nettoyage urgent à '.$city.', appelez-nous directement au '.config('company.phone.display').'.',
            ],
        ];

        return array_merge($local, config('site.faq'));
    }

    /**
     * Rend les métadonnées disponibles au layout Blade, afin que les balises
     * SEO et le JSON-LD soient présents dans le HTML initial.
     *
     * @param  array<string, mixed>  $meta
     * @param  list<array<string, mixed>>  $extraNodes
     */
    private function shareSeo(array $meta, array $extraNodes = []): void
    {
        View::share('seo', $meta);
        View::share('jsonLd', Seo::graph($meta, $extraNodes));
    }
}
