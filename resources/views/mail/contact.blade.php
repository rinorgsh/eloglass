<x-mail::message>
# {{ $kind === 'callback' ? 'Demande de rappel' : 'Nouvelle demande de devis' }}

@if($kind === 'callback')
Un visiteur demande à être rappelé. **Rappelez-le rapidement : un lead contacté dans l'heure convertit bien mieux.**
@else
Une nouvelle demande a été envoyée depuis le site **{{ config('app.name') }}**.
@endif

**Nom :** {{ $data['name'] }}
@if(!empty($data['company']))
**Société :** {{ $data['company'] }}
@endif
@if(!empty($data['phone']))
**Téléphone :** {{ $data['phone'] }}
@endif
@if(!empty($data['email']))
**Email :** {{ $data['email'] }}
@endif
@if(!empty($data['city']))
**Localité :** {{ $data['city'] }}
@endif
@if(!empty($data['property_type']))
**Type de bien :** {{ $data['property_type'] }}
@endif
@if(!empty($data['service']))
**Prestation souhaitée :** {{ $data['service'] }}
@endif

@if(!empty($data['message']))
**Message :**

{{ $data['message'] }}
@endif

@if(!empty($data['phone']))
<x-mail::button :url="'tel:'.preg_replace('/\s+/', '', $data['phone'])">
Appeler {{ $data['name'] }}
</x-mail::button>
@elseif(!empty($data['email']))
<x-mail::button :url="'mailto:'.$data['email']">
Répondre au client
</x-mail::button>
@endif

Site {{ config('app.name') }}
</x-mail::message>
