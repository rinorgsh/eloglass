@php
    $title = $kind === 'callback' ? 'Demande de rappel' : 'Nouvelle demande de devis';
    $rows = array_filter([
        'Nom' => $data['name'] ?? null,
        'Société' => $data['company'] ?? null,
        'Téléphone' => $data['phone'] ?? null,
        'E-mail' => $data['email'] ?? null,
        'Commune' => $data['city'] ?? null,
        'Type de lieu' => $data['property_type'] ?? null,
        'Prestation' => $data['service'] ?? null,
    ]);
    $phoneHref = ! empty($data['phone']) ? 'tel:'.preg_replace('/[^0-9+]/', '', $data['phone']) : null;
@endphp
<x-mail.layout :title="$title" :preview="($data['name'] ?? 'Contact').' · '.($data['phone'] ?? '')">
    <p style="margin:0 0 22px;">
        @if($kind === 'callback')
            Un visiteur du site demande à être rappelé.
        @else
            Une demande vient d'être envoyée depuis le site.
        @endif
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-top:1px solid #dfe1d6;">
        @foreach($rows as $label => $value)
            <tr>
                <td width="130" valign="top" style="padding:11px 12px 11px 0; border-bottom:1px solid #dfe1d6; font-size:14px; color:#7a8394;">{{ $label }}</td>
                <td valign="top" style="padding:11px 0; border-bottom:1px solid #dfe1d6; font-size:16px; color:#121b2b;">
                    @if($label === 'Téléphone' && $phoneHref)
                        <a href="{{ $phoneHref }}" style="color:#06234f; font-weight:bold; text-decoration:none;">{{ $value }}</a>
                    @elseif($label === 'E-mail')
                        <a href="mailto:{{ $value }}" style="color:#06234f;">{{ $value }}</a>
                    @else
                        {{ $value }}
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

    @if(! empty($data['message']))
        <p style="margin:24px 0 8px; font-size:14px; color:#7a8394;">Message</p>
        <p style="margin:0; padding:16px 18px; background-color:#f3f4ed; border-left:3px solid #597455; color:#121b2b; white-space:pre-line;">{{ $data['message'] }}</p>
    @endif

    @if($phoneHref)
        <table role="presentation" cellpadding="0" cellspacing="0" style="margin:30px 0 8px;">
            <tr>
                <td style="background-color:#06234f; border-radius:999px;">
                    <a href="{{ $phoneHref }}" style="display:inline-block; padding:14px 28px; font-size:16px; font-weight:bold; color:#ffffff; text-decoration:none;">Appeler {{ $data['name'] }}</a>
                </td>
            </tr>
        </table>
    @endif
</x-mail.layout>
