{{--
    Gabarit commun des e-mails Clean Company.
    Mise en page en tableaux et styles en ligne : c'est ce que les messageries
    (Gmail, Outlook, Apple Mail) affichent de façon fiable.
--}}
@php
    $company = config('company');
    $marine = '#06234f';
    $sauge = '#597455';
    $ivoire = '#fdfcfa';
    $filet = '#dfe1d6';
    $encre = '#4a5567';
    $serif = "Georgia, 'Times New Roman', serif";
    $sans = "-apple-system, 'Segoe UI', Helvetica, Arial, sans-serif";
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <title>{{ $title }}</title>
</head>
<body style="margin:0; padding:0; background-color:#f3f4ed; -webkit-text-size-adjust:100%;">
    {{-- Texte d'aperçu affiché dans la liste des messages. --}}
    <div style="display:none; max-height:0; overflow:hidden; opacity:0;">{{ $preview ?? $title }}</div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f3f4ed;">
        <tr>
            <td align="center" style="padding:32px 12px;">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="width:100%; max-width:600px; background-color:{{ $ivoire }}; border:1px solid {{ $filet }}; border-radius:4px;">
                    <tr>
                        <td align="center" style="padding:28px 24px 20px; border-bottom:1px solid {{ $filet }};">
                            <a href="{{ config('app.url') }}" style="text-decoration:none;">
                                <img src="{{ rtrim(config('app.url'), '/') }}/logo-mail.png" width="170" alt="{{ $company['name'] }}" style="display:block; width:170px; height:auto; border:0; font-family:{{ $serif }}; font-size:24px; color:{{ $marine }};">
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:36px 36px 12px; font-family:{{ $sans }}; font-size:16px; line-height:1.6; color:{{ $encre }};">
                            <h1 style="margin:0 0 18px; font-family:{{ $serif }}; font-weight:normal; font-size:28px; line-height:1.2; color:{{ $marine }};">{{ $title }}</h1>
                            {{ $slot }}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:20px 36px 32px; font-family:{{ $sans }}; font-size:13px; line-height:1.6; color:{{ $encre }};">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="border-top:1px solid {{ $filet }}; padding-top:20px;">
                                        <strong style="color:{{ $marine }};">{{ $company['legal_name'] }}</strong><br>
                                        {{ $company['address']['street'] }}, {{ $company['address']['postal_code'] }} {{ $company['address']['city'] }}<br>
                                        <a href="tel:{{ $company['phone']['e164'] }}" style="color:{{ $marine }}; text-decoration:none;">{{ $company['phone']['display'] }}</a>
                                        &nbsp;/&nbsp;
                                        <a href="tel:{{ $company['phone_secondary']['e164'] }}" style="color:{{ $marine }}; text-decoration:none;">{{ $company['phone_secondary']['display'] }}</a><br>
                                        <a href="mailto:{{ $company['email'] }}" style="color:{{ $sauge }};">{{ $company['email'] }}</a>
                                        &nbsp;·&nbsp; TVA {{ $company['vat'] }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
