<?php

namespace App\Http\Controllers;

use App\Support\Seo;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $lastmod = date('Y-m-d');

        $urls = [
            ['loc' => Seo::url('/'), 'priority' => '1.0', 'freq' => 'weekly'],
            ['loc' => Seo::url('/lavage-de-vitres'), 'priority' => '0.8', 'freq' => 'monthly'],
        ];

        foreach (config('site.zones') as $zone) {
            $urls[] = [
                'loc' => Seo::url('/lavage-de-vitres/'.$zone['slug']),
                'priority' => ($zone['primary'] ?? false) ? '0.9' : '0.8',
                'freq' => 'monthly',
            ];
        }

        $urls[] = ['loc' => Seo::url('/mentions-legales'), 'priority' => '0.2', 'freq' => 'yearly'];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>'.htmlspecialchars($url['loc'], ENT_XML1).'</loc>'."\n";
            $xml .= '    <lastmod>'.$lastmod.'</lastmod>'."\n";
            $xml .= '    <changefreq>'.$url['freq'].'</changefreq>'."\n";
            $xml .= '    <priority>'.$url['priority'].'</priority>'."\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    public function robots(): Response
    {
        $body = implode("\n", [
            'User-agent: *',
            'Allow: /',
            'Disallow: /build/',
            '',
            'Sitemap: '.Seo::url('/sitemap.xml'),
            '',
        ]);

        return response($body, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
