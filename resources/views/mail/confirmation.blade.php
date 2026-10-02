@php($company = config('company'))
<x-mail.layout :title="'Merci '.$name.', votre demande est bien arrivée'" :preview="'Nous vous répondons sous '.$company['response_time'].' ouvrables.'">
    <p style="margin:0 0 16px;">
        Nous avons bien reçu votre demande de devis. Nous vous répondons sous
        <strong style="color:#06234f;">{{ $company['response_time'] }} ouvrables</strong>, avec un prix clair et sans engagement.
    </p>
    <p style="margin:0 0 6px;">Pour une réponse plus rapide, appelez-nous directement&nbsp;:</p>

    <table role="presentation" cellpadding="0" cellspacing="0" style="margin:20px 0 8px;">
        <tr>
            <td style="background-color:#06234f; border-radius:999px;">
                <a href="tel:{{ $company['phone']['e164'] }}" style="display:inline-block; padding:14px 28px; font-size:16px; font-weight:bold; color:#ffffff; text-decoration:none;">{{ $company['phone']['display'] }}</a>
            </td>
        </tr>
    </table>

    <p style="margin:24px 0 0;">À très vite,<br><span style="color:#06234f;">L'équipe {{ $company['name'] }}</span></p>
</x-mail.layout>
