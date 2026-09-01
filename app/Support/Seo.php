<?php

namespace App\Support;

/**
 * Construit les métadonnées et les données structurées schema.org.
 *
 * Tout est généré côté serveur puis injecté dans le layout Blade : les
 * robots n'ont pas besoin d'exécuter le JavaScript pour lire le title,
 * la description, le canonical ou le JSON-LD.
 */
class Seo
{
    /**
     * Métadonnées d'une page.
     *
     * @param  list<array{name: string, url: string}>  $breadcrumbs
     * @return array<string, mixed>
     */
    public static function meta(
        string $title,
        string $description,
        string $path = '/',
        array $breadcrumbs = [],
        ?string $image = null,
    ): array {
        $url = self::url($path);

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $url,
            'image' => $image ? self::url($image) : self::url('/og-image.jpg'),
            'breadcrumbs' => $breadcrumbs,
        ];
    }

    public static function url(string $path = '/'): string
    {
        return rtrim(config('app.url'), '/').'/'.ltrim($path, '/');
    }

    /**
     * Le graphe schema.org du site : entreprise locale + site web.
     * Réutilisé sur toutes les pages via un @id stable.
     *
     * @return array<string, mixed>
     */
    public static function organizationGraph(): array
    {
        $company = config('company');
        $siteUrl = rtrim(config('app.url'), '/');
        $businessId = $siteUrl.'/#business';

        $openingHours = [];
        foreach ($company['hours'] as $slot) {
            $openingHours[] = [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => $slot['days'],
                'opens' => $slot['opens'],
                'closes' => $slot['closes'],
            ];
        }

        $areaServed = [];
        foreach (config('site.zones') as $zone) {
            $areaServed[] = [
                '@type' => 'City',
                'name' => $zone['city'],
                'address' => [
                    '@type' => 'PostalAddress',
                    'postalCode' => $zone['postal'],
                    'addressCountry' => 'BE',
                ],
            ];
        }

        $offers = [];
        foreach (config('site.services') as $service) {
            $offers[] = [
                '@type' => 'Offer',
                'itemOffered' => [
                    '@type' => 'Service',
                    'name' => $service['title'],
                    'description' => $service['text'],
                    'serviceType' => 'Lavage de vitres',
                ],
            ];
        }

        return [
            '@type' => ['LocalBusiness', 'HomeAndConstructionBusiness'],
            '@id' => $businessId,
            'name' => $company['name'],
            'legalName' => $company['legal_name'],
            'alternateName' => $company['name'].' — '.$company['tagline'],
            'description' => 'Entreprise de lavage de vitres pour particuliers et professionnels à Bruxelles et en périphérie. Vitres de maison, vitrines, bureaux, vérandas et panneaux solaires. Devis gratuit.',
            'url' => $siteUrl.'/',
            'logo' => [
                '@type' => 'ImageObject',
                '@id' => $siteUrl.'/#logo',
                'url' => $siteUrl.'/logo.jpg',
                'width' => 1254,
                'height' => 1254,
                'caption' => $company['name'],
            ],
            'image' => $siteUrl.'/logo.jpg',
            'telephone' => $company['phone']['international'],
            'email' => $company['email'],
            'vatID' => $company['vat_raw'],
            'taxID' => $company['bce'],
            'priceRange' => $company['price_range'],
            'currenciesAccepted' => 'EUR',
            'paymentAccepted' => 'Virement bancaire, Bancontact, Espèces',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $company['address']['street'],
                'postalCode' => $company['address']['postal_code'],
                'addressLocality' => $company['address']['city'],
                'addressRegion' => $company['address']['region'],
                'addressCountry' => 'BE',
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $company['geo']['lat'],
                'longitude' => $company['geo']['lng'],
            ],
            'openingHoursSpecification' => $openingHours,
            'areaServed' => $areaServed,
            'knowsLanguage' => ['fr-BE', 'nl-BE'],
            'sameAs' => $company['social'],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'Prestations de lavage de vitres',
                'itemListElement' => $offers,
            ],
            'potentialAction' => [
                '@type' => 'ReserveAction',
                'name' => 'Demander un devis gratuit',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => $siteUrl.'/#devis',
                    'inLanguage' => 'fr-BE',
                    'actionPlatform' => [
                        'http://schema.org/DesktopWebPlatform',
                        'http://schema.org/MobileWebPlatform',
                    ],
                ],
            ],
        ];
    }

    /**
     * Assemble le @graph complet d'une page.
     *
     * @param  array<string, mixed>  $meta
     * @param  list<array<string, mixed>>  $extra
     * @return array<string, mixed>
     */
    public static function graph(array $meta, array $extra = []): array
    {
        $siteUrl = rtrim(config('app.url'), '/');
        $company = config('company');

        $nodes = [
            self::organizationGraph(),
            [
                '@type' => 'WebSite',
                '@id' => $siteUrl.'/#website',
                'url' => $siteUrl.'/',
                'name' => $company['name'],
                'inLanguage' => 'fr-BE',
                'publisher' => ['@id' => $siteUrl.'/#business'],
            ],
            [
                '@type' => 'WebPage',
                '@id' => $meta['canonical'].'#webpage',
                'url' => $meta['canonical'],
                'name' => $meta['title'],
                'description' => $meta['description'],
                'inLanguage' => 'fr-BE',
                'isPartOf' => ['@id' => $siteUrl.'/#website'],
                'about' => ['@id' => $siteUrl.'/#business'],
                'primaryImageOfPage' => ['@id' => $siteUrl.'/#logo'],
            ],
        ];

        if (! empty($meta['breadcrumbs'])) {
            $items = [];
            foreach ($meta['breadcrumbs'] as $i => $crumb) {
                $items[] = [
                    '@type' => 'ListItem',
                    'position' => $i + 1,
                    'name' => $crumb['name'],
                    'item' => self::url($crumb['url']),
                ];
            }

            $nodes[] = [
                '@type' => 'BreadcrumbList',
                '@id' => $meta['canonical'].'#breadcrumb',
                'itemListElement' => $items,
            ];
        }

        foreach ($extra as $node) {
            $nodes[] = $node;
        }

        return [
            '@context' => 'https://schema.org',
            '@graph' => $nodes,
        ];
    }

    /**
     * Bloc FAQPage — éligible aux résultats enrichis Google.
     *
     * @param  list<array{q: string, a: string}>  $faq
     * @return array<string, mixed>
     */
    public static function faqNode(array $faq, string $canonical): array
    {
        $entities = [];
        foreach ($faq as $item) {
            $entities[] = [
                '@type' => 'Question',
                'name' => $item['q'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['a'],
                ],
            ];
        }

        return [
            '@type' => 'FAQPage',
            '@id' => $canonical.'#faq',
            'mainEntity' => $entities,
        ];
    }

    /**
     * Bloc Service pour une page locale.
     *
     * @param  array<string, mixed>  $zone
     * @return array<string, mixed>
     */
    public static function localServiceNode(array $zone, string $canonical): array
    {
        $siteUrl = rtrim(config('app.url'), '/');

        return [
            '@type' => 'Service',
            '@id' => $canonical.'#service',
            'name' => 'Lavage de vitres à '.$zone['city'],
            'serviceType' => 'Lavage de vitres',
            'provider' => ['@id' => $siteUrl.'/#business'],
            'areaServed' => [
                '@type' => 'City',
                'name' => $zone['city'],
                'address' => [
                    '@type' => 'PostalAddress',
                    'postalCode' => $zone['postal'],
                    'addressLocality' => $zone['city'],
                    'addressRegion' => $zone['province'],
                    'addressCountry' => 'BE',
                ],
            ],
            'description' => $zone['intro'],
            'offers' => [
                '@type' => 'Offer',
                'availability' => 'https://schema.org/InStock',
                'priceCurrency' => 'EUR',
                'description' => 'Devis gratuit et sans engagement',
            ],
        ];
    }
}
