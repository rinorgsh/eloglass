<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $company = config('company');

        return [
            ...parent::share($request),
            'company' => [
                'name' => $company['name'],
                'legalName' => $company['legal_name'],
                'tagline' => $company['tagline'],
                'vat' => $company['vat'],
                'bce' => $company['bce'],
                'address' => $company['address'],
                'hours' => array_map(
                    fn ($slot) => ['label' => $slot['label'], 'opens' => $slot['opens'], 'closes' => $slot['closes']],
                    $company['hours'],
                ),
                'responseTime' => $company['response_time'],
            ],
            'contactEmail' => $company['email'],
            'contactPhone' => $company['phone']['display'],
            'contactPhoneE164' => $company['phone']['e164'],
            'whatsapp' => $company['whatsapp'],
            // Maillage interne : un extrait des communes dans le pied de page,
            // la liste complète vivant sur /lavage-de-vitres.
            'footerZones' => array_map(
                fn ($zone) => ['slug' => $zone['slug'], 'city' => $zone['city']],
                array_slice(config('site.zones'), 0, 12),
            ),
            'flash' => [
                'contactSuccess' => fn () => $request->session()->get('contactSuccess'),
            ],
        ];
    }
}
