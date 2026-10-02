<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    | Mesure d'audience. Renseignez l'un des deux dans le .env :
    | GTM_ID pour Google Tag Manager, ou GA_ID pour GA4 directement.
    */
    'gtm_id' => env('GTM_ID'),
    'ga_id' => env('GA_ID'),

    /*
    | Avis Google (API Business Profile). Tant que ces valeurs sont vides,
    | la section « Avis » de la page d'accueil reste masquée.
    */
    'google_business' => [
        'client_id' => env('GOOGLE_BP_CLIENT_ID'),
        'client_secret' => env('GOOGLE_BP_CLIENT_SECRET'),
        'refresh_token' => env('GOOGLE_BP_REFRESH_TOKEN'),
        'account_id' => env('GOOGLE_BP_ACCOUNT_ID'),
        'location_id' => env('GOOGLE_BP_LOCATION_ID'),
        'max_reviews' => env('GOOGLE_BP_MAX_REVIEWS', 6),
    ],

];
