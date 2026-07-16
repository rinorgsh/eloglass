<x-mail::message>
# Nouvelle demande de devis

Une nouvelle demande a été envoyée depuis le site **{{ config('app.name') }}**.

**Nom :** {{ $data['name'] }}
@if(!empty($data['company']))
**Société :** {{ $data['company'] }}
@endif
**Email :** {{ $data['email'] }}
@if(!empty($data['phone']))
**Téléphone :** {{ $data['phone'] }}
@endif
@if(!empty($data['service']))
**Prestation souhaitée :** {{ $data['service'] }}
@endif

**Message :**

{{ $data['message'] }}

<x-mail::button :url="'mailto:'.$data['email']">
Répondre au client
</x-mail::button>

Merci,<br>
Site {{ config('app.name') }}
</x-mail::message>
