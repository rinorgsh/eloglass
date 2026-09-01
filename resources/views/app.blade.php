<!DOCTYPE html>
@php
    $seo = $seo ?? [];
    $title = $seo['title'] ?? 'Elo Glass — Lavage de vitres et nettoyage de bureaux à Bruxelles';
    $description = $seo['description'] ?? 'Lavage de vitres et nettoyage de bureaux pour particuliers et professionnels. Sans traces, à l\'eau osmosée. Devis gratuit sous 24 h.';
    $canonical = $seo['canonical'] ?? url()->current();
    $image = $seo['image'] ?? url('/og-image.jpg');
@endphp
<html lang="fr-BE" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#0a529c">

    <title inertia>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ $canonical }}">

    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="author" content="{{ config('company.legal_name') }}">

    {{-- Ciblage géographique --}}
    <meta name="geo.region" content="BE-WBR">
    <meta name="geo.placename" content="{{ config('company.address.city') }}">
    <meta name="geo.position" content="{{ config('company.geo.lat') }};{{ config('company.geo.lng') }}">
    <meta name="ICBM" content="{{ config('company.geo.lat') }}, {{ config('company.geo.lng') }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:locale" content="fr_BE">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ $image }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Elo Glass — lavage de vitres professionnel">

    {{-- Twitter / X --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image" content="{{ $image }}">

    <link rel="icon" href="/favicon.ico" sizes="32x32">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">

    {{-- Le monogramme est visible dès le premier rendu : on le précharge. --}}
    <link rel="preload" as="image" href="/logo-mark.webp" type="image/webp" fetchpriority="high">

    {{-- Données structurées schema.org, rendues côté serveur --}}
    @isset($jsonLd)
        <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @endisset

    @vite(['resources/js/app.js'])
    @inertiaHead

    {{--
        Mesure d'audience — activée uniquement si un identifiant est présent
        dans le .env. Les formulaires poussent un évènement « lead_submitted »
        dans le dataLayer, utilisable comme conversion Google Ads.
    --}}
    @if($gtm = config('services.gtm_id'))
        <script>window.dataLayer=window.dataLayer||[];</script>
        <script async src="https://www.googletagmanager.com/gtm.js?id={{ $gtm }}"></script>
    @elseif($ga = config('services.ga_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $ga }}');
        </script>
    @else
        <script>window.dataLayer=window.dataLayer||[];</script>
    @endif
</head>
<body class="antialiased">
    @inertia

    {{--
        Contenu de repli : garantit que le nom, l'adresse et le téléphone (NAP)
        restent lisibles même sans exécution du JavaScript.
    --}}
    <noscript>
        <div style="max-width:42rem;margin:0 auto;padding:2rem 1.25rem;font-family:system-ui,sans-serif;line-height:1.6">
            <h1>{{ config('company.name') }} — {{ config('company.tagline') }}</h1>
            <p>{{ $description }}</p>
            <p>
                <strong>{{ config('company.legal_name') }}</strong><br>
                {{ config('company.address.street') }}, {{ config('company.address.postal_code') }} {{ config('company.address.city') }}, {{ config('company.address.country') }}<br>
                Téléphone : <a href="tel:{{ config('company.phone.e164') }}">{{ config('company.phone.display') }}</a><br>
                E-mail : <a href="mailto:{{ config('company.email') }}">{{ config('company.email') }}</a><br>
                TVA {{ config('company.vat') }}
            </p>
        </div>
    </noscript>
</body>
</html>
