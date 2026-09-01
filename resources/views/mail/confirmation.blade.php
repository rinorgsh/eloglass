<x-mail::message>
# Merci {{ $name }} !

Nous avons bien reçu votre demande de devis pour le nettoyage de vos vitres.

Un membre de l'équipe **{{ config('app.name') }}** revient vers vous sous **{{ config('company.response_time') }} ouvrables** avec un prix clair et sans engagement.

Besoin d'une réponse plus rapide ? Appelez-nous directement :

<x-mail::button :url="'tel:'.config('company.phone.e164')">
{{ config('company.phone.display') }}
</x-mail::button>

À très vite,<br>
{{ config('company.legal_name') }}<br>
{{ config('company.address.street') }}, {{ config('company.address.postal_code') }} {{ config('company.address.city') }}<br>
TVA {{ config('company.vat') }}
</x-mail::message>
