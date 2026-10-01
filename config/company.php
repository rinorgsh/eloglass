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

    'legal_name' => 'Clean Company',
    'name' => 'Clean Company',
    'tagline' => 'Nettoyage de maisons, de bureaux et de vitres',

    /*
    | Numéro d'entreprise / TVA (BCE : 1043.205.603)
    */
    'vat' => 'BE 1043.205.603',
    'vat_raw' => 'BE1043205603',
    'bce' => '1043.205.603',
    // Forme juridique à confirmer par le client : laissée vide, elle n'est pas affichée.
    'legal_form' => null,

    'address' => [
        'street' => 'Watermolenstraat 16',
        'postal_code' => '1840',
        'city' => 'Londerzeel',
        'region' => 'Brabant flamand',
        'country' => 'Belgique',
        'country_code' => 'BE',
    ],

    /*
    | Coordonnées approximatives du centre de Londerzeel. À affiner avec les
    | coordonnées exactes de la fiche Google Business Profile.
    */
    'geo' => [
        'lat' => 51.0047,
        'lng' => 4.3003,
    ],

    'phone' => [
        'display' => '0484 15 20 73',
        'e164' => '+32484152073',
        'international' => '+32 484 15 20 73',
    ],

    'phone_secondary' => [
        'display' => '0477 97 27 91',
        'e164' => '+32477972791',
        'international' => '+32 477 97 27 91',
    ],

    'email' => env('MAIL_CONTACT_TO', 'info@eloglass.be'),

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
