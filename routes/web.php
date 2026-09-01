<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

/*
| Pages locales — le levier principal du référencement local.
| /lavage-de-vitres/{commune}
*/
Route::get('/lavage-de-vitres', [PageController::class, 'zones'])->name('zones');
Route::get('/lavage-de-vitres/{slug}', [PageController::class, 'zone'])->name('zone');

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
