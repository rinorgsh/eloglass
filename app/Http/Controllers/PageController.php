<?php

namespace App\Http\Controllers;

use App\Support\Seo;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function home(): Response
    {
        $meta = Seo::meta(
            title: 'Lavage de vitres à Bruxelles et en périphérie | Elo Glass',
            description: 'Elo Glass lave vos vitres sans traces : maisons, vitrines, bureaux, vérandas et panneaux solaires. Les 19 communes de Bruxelles et toute la périphérie. Devis gratuit sous 24 h — 0484 15 20 73.',
            path: '/',
        );

        $this->shareSeo($meta, [
            Seo::faqNode(config('site.faq'), $meta['canonical']),
        ]);

        return Inertia::render('Landing', [
            'seo' => $meta,
            'services' => config('site.services'),
            'zones' => $this->zoneLinks(),
            'faq' => config('site.faq'),
        ]);
    }

    public function zone(string $slug): Response
    {
        $zone = collect(config('site.zones'))->firstWhere('slug', $slug);

        abort_if($zone === null, 404);

        $path = '/lavage-de-vitres/'.$zone['slug'];

        $meta = Seo::meta(
            title: 'Lavage de vitres à '.$zone['city'].' ('.$zone['postal'].') — Devis gratuit | Elo Glass',
            description: 'Laveur de vitres professionnel à '.$zone['city'].' : maisons, vitrines, bureaux et vérandas. Sans traces, à l\'eau osmosée. Devis gratuit sous 24 h — 0484 15 20 73.',
            path: $path,
            breadcrumbs: [
                ['name' => 'Accueil', 'url' => '/'],
                ['name' => 'Zones d\'intervention', 'url' => '/lavage-de-vitres'],
                ['name' => $zone['city'], 'url' => $path],
            ],
        );

        $faq = $this->localFaq($zone);

        $this->shareSeo($meta, [
            Seo::localServiceNode($zone, $meta['canonical']),
            Seo::faqNode($faq, $meta['canonical']),
        ]);

        return Inertia::render('Zone', [
            'seo' => $meta,
            'zone' => $zone,
            'services' => config('site.services'),
            'faq' => $faq,
            'zones' => $this->zoneLinks($zone),
        ]);
    }

    public function zones(): Response
    {
        $meta = Seo::meta(
            title: "Zones d'intervention — lavage de vitres à Bruxelles et en périphérie | Elo Glass",
            description: "Elo Glass intervient dans les 19 communes bruxelloises — Uccle, Ixelles, Woluwe, Schaerbeek, Etterbeek… — et en périphérie : Rhode-Saint-Genèse, Kraainem, Tervuren, Overijse, Zaventem, Dilbeek. Devis gratuit sous 24 h.",
            path: '/lavage-de-vitres',
            breadcrumbs: [
                ['name' => 'Accueil', 'url' => '/'],
                ['name' => "Zones d'intervention", 'url' => '/lavage-de-vitres'],
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
            title: 'Mentions légales | Elo Glass',
            description: 'Mentions légales et informations d\'entreprise d\'Elo Glass SRL, société de lavage de vitres établie à Lasne (BCE 0475.199.436).',
            path: '/mentions-legales',
            breadcrumbs: [
                ['name' => 'Accueil', 'url' => '/'],
                ['name' => 'Mentions légales', 'url' => '/mentions-legales'],
            ],
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
                'a' => 'Nous répondons à votre demande sous 24 h ouvrables et proposons généralement un créneau dans la semaine. Pour une vitrine ou un nettoyage après chantier urgent à '.$city.', appelez-nous directement au '.config('company.phone.display').'.',
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
