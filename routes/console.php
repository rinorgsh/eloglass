<?php

use App\Support\GoogleReviews;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
| Avis Google : à lancer à la main (`php artisan reviews:refresh`) quand de
| nouveaux avis sont à afficher. En cas d'échec, les avis déjà enregistrés
| restent affichés.
*/
Artisan::command('reviews:refresh', function () {
    if (! GoogleReviews::configured()) {
        $this->warn('Avis Google non configurés : renseignez les variables GOOGLE_BP_* dans le .env.');

        return 0;
    }

    try {
        $data = GoogleReviews::refresh();
    } catch (\Throwable $e) {
        $this->error('Récupération des avis Google impossible : '.$e->getMessage());

        return 1;
    }

    $this->info(sprintf('%d avis affichés, note %.1f sur %d avis.', count($data['reviews']), $data['rating'], $data['count']));

    return 0;
})->purpose('Récupère les avis de la fiche Google Business Profile');
