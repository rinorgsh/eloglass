# Clean Company — site vitrine

Site de génération de demandes de devis pour **Clean Company**, société de **nettoyage**
(maisons, bureaux, commerces, vitres, après chantier) établie Watermolenstraat 16,
1840 Londerzeel (TVA BE 1043.205.603). Le site remplace l'ancien site Elo Glass.

Zone couverte : les **19 communes de la Région de Bruxelles-Capitale** et la **périphérie**
(Londerzeel, Grimbergen, Dilbeek, Zaventem, Kraainem, Wezembeek-Oppem, Tervuren, Overijse,
Hoeilaart, Rhode-Saint-Genèse, La Hulpe, Lasne, Waterloo) — soit 32 pages locales.

Laravel 12 · Inertia · Vue 3 · Tailwind CSS 4.

## Démarrer

```bash
composer install
npm install
php artisan migrate
npm run dev        # ou npm run build en production
php artisan serve
```

## Où modifier le contenu

| Ce que vous voulez changer | Fichier |
| --- | --- |
| Téléphone, adresse, TVA, horaires, réseaux sociaux | `config/company.php` |
| Prestations (trois familles : `maison`, `entreprise`, `ponctuel`), communes desservies, FAQ | `config/site.php` |
| Textes de la page d'accueil | `resources/js/Pages/Landing.vue` |
| Textes des pages communes | `resources/js/Pages/Zone.vue` + le champ `intro` de chaque zone |
| Palette, typographie, composants visuels | `resources/css/app.css` |

Ajouter une commune dans `config/site.php` crée automatiquement sa page
`/nettoyage/{slug}`, son entrée de sitemap, ses liens internes et son balisage
schema.org. Les anciennes adresses `/lavage-de-vitres/…` redirigent en 301. Le champ `intro` doit rester **unique** d'une commune à l'autre : deux textes
identiques seraient traités par Google comme du contenu dupliqué.

## Référencement

- Métadonnées, `canonical`, Open Graph et JSON-LD sont générés **côté serveur**
  (`app/Support/Seo.php` → `resources/views/app.blade.php`), donc lisibles sans JavaScript.
- `/sitemap.xml` et `/robots.txt` sont dynamiques et suivent le domaine défini par `APP_URL`.
- Données structurées : `LocalBusiness`, `WebSite`, `WebPage`, `BreadcrumbList`, `Service`, `FAQPage`.

Le NAP (nom, adresse, téléphone) affiché sur le site doit rester **identique au caractère près**
à celui de la fiche Google Business Profile.

## Demandes de devis

Les formulaires écrivent dans la table `leads` **avant** l'envoi des e-mails : une panne SMTP
ne fait perdre aucune demande.

```bash
php artisan tinker --execute="App\Models\Lead::latest()->take(20)->get(['created_at','name','phone','city','kind'])->each(fn(\$l) => print(\$l->toJson().PHP_EOL));"
```

Deux points d'entrée : `/contact` (devis complet) et `/rappel` (rappel express, nom + téléphone).
Les deux sont protégés par un honeypot et limités à 8 envois par minute et par IP.

## Variables d'environnement utiles

```
APP_URL=https://companyclean.be     # sert de base aux canonical, sitemap et JSON-LD
MAIL_CONTACT_TO=info@companyclean.be
COMPANY_WHATSAPP=32484152073
GTM_ID=                          # ou GA_ID pour GA4 — laisser vide pour désactiver
SOCIAL_GOOGLE_PROFILE=           # URL de la fiche Google Business Profile
```

## Tests

```bash
php artisan test
```

Couvre les métadonnées SEO, le sitemap, les pages locales et le parcours de génération de leads
(y compris la persistance en cas d'échec d'envoi d'e-mail).
