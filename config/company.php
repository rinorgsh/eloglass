<?php

/*
|--------------------------------------------------------------------------
| Données de l'entreprise (source unique)
|--------------------------------------------------------------------------
|
| Ces informations alimentent le NAP (Name / Address / Phone) du site, les
| données structurées JSON-LD, le sitemap et les pages locales. Elles doivent
| rester STRICTEMENT identiques à celles publiées sur Google Business Profile
| et dans les annuaires : c'est un critère fort de référencement local.
|
*/

return [

    'legal_name' => 'ELO GLASS SRL',
    'name' => 'Elo Glass',
    'tagline' => 'Lavage de vitres professionnel',

    /*
    | Numéro d'entreprise / TVA (BCE : 0475.199.436)
    */
    'vat' => 'BE 0475.199.436',
    'vat_raw' => 'BE0475199436',
    'bce' => '0475.199.436',
    'legal_form' => 'Société à responsabilité limitée',

    'address' => [
        'street' => "Route de l'Etat 11",
        'postal_code' => '1380',
        'city' => 'Lasne',
        'region' => 'Brabant wallon',
        'country' => 'Belgique',
        'country_code' => 'BE',
    ],

    /*
    | Coordonnées approximatives du centre de Lasne. À affiner avec les
    | coordonnées exactes de la fiche Google Business Profile.
    */
    'geo' => [
        'lat' => 50.6833,
        'lng' => 4.4667,
    ],

    'phone' => [
        'display' => '0484 15 20 73',
        'e164' => '+32484152073',
        'international' => '+32 484 15 20 73',
    ],

    'email' => env('MAIL_CONTACT_TO', 'contact@eloglass.be'),

    /*
    | Horaires affichés + données structurées. À confirmer par le client.
    */
    'hours' => [
        ['days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'], 'label' => 'Lundi — Vendredi', 'opens' => '08:00', 'closes' => '18:00'],
        ['days' => ['Saturday'], 'label' => 'Samedi', 'opens' => '09:00', 'closes' => '13:00'],
    ],

    'price_range' => '€€',

    /*
    | Réseaux sociaux — alimente le champ "sameAs" du JSON-LD.
    | Ajoutez l'URL de la fiche Google Business Profile dès qu'elle existe.
    */
    'social' => array_values(array_filter([
        env('SOCIAL_FACEBOOK'),
        env('SOCIAL_INSTAGRAM'),
        env('SOCIAL_GOOGLE_PROFILE'),
    ])),

    'whatsapp' => env('COMPANY_WHATSAPP', '32484152073'),

    /*
    | Délai de réponse annoncé (utilisé dans les CTA et les micro-engagements).
    */
    'response_time' => '24 h',

];
