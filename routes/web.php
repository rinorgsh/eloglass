<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

/*
| Pages locales — le levier principal du référencement local.
| /nettoyage/{commune}
*/
Route::get('/nettoyage', [PageController::class, 'zones'])->name('zones');
Route::get('/nettoyage/{slug}', [PageController::class, 'zone'])->name('zone');

/*
| Anciennes adresses (site Elo Glass) : redirigées définitivement pour ne
| perdre ni les liens existants ni ce que Google a déjà indexé.
*/
Route::permanentRedirect('/lavage-de-vitres', '/nettoyage');
Route::permanentRedirect('/lavage-de-vitres/{slug}', '/nettoyage/{slug}');

Route::get('/mentions-legales', [PageController::class, 'legal'])->name('legal');

/*
| Formulaires — limités en débit pour éviter le spam.
*/
Route::middleware('throttle:8,1')->group(function () {
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    Route::post('/rappel', [ContactController::class, 'callback'])->name('contact.callback');
});

/*
| SEO technique — servis par l'application pour rester synchronisés
| avec le contenu et le domaine configuré.
*/
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');
