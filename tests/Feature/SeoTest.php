<?php

namespace Tests\Feature;

use Tests\TestCase;

class SeoTest extends TestCase
{
    public function test_home_page_carries_its_seo_tags_in_the_initial_html(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('<link rel="canonical"', false);
        $response->assertSee('og:image', false);
        $response->assertSee('application/ld+json', false);
        // Le NAP doit rester lisible sans exécuter le JavaScript.
        $response->assertSee('0484 15 20 73');
    }

    public function test_every_zone_page_answers_and_is_indexable(): void
    {
        foreach (config('site.zones') as $zone) {
            $response = $this->get('/lavage-de-vitres/'.$zone['slug']);

            $response->assertOk();
            $response->assertSee('Lavage de vitres à '.e($zone['city']), false);
            $response->assertSee('https://eloglass.be/lavage-de-vitres/'.$zone['slug'], false);
        }
    }

    public function test_local_pages_do_not_share_duplicate_content(): void
    {
        $zones = config('site.zones');

        foreach (['slug', 'intro', 'focus'] as $field) {
            $values = array_column($zones, $field);

            $this->assertCount(
                count($zones),
                array_unique($values),
                "Le champ « {$field} » est dupliqué entre deux communes : Google le traiterait comme du contenu dupliqué.",
            );
        }
    }

    public function test_unknown_zone_returns_404(): void
    {
        $this->get('/lavage-de-vitres/marrakech')->assertNotFound();
    }

    public function test_structured_data_describes_the_local_business(): void
    {
        $html = $this->get('/')->getContent();

        preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $matches);
        $graph = json_decode($matches[1], true);

        $types = array_column($graph['@graph'], '@type');
        $this->assertContains('FAQPage', $types);

        $business = $graph['@graph'][0];
        $this->assertSame('BE0475199436', $business['vatID']);
        $this->assertSame('1380', $business['address']['postalCode']);
        $this->assertSame('+32 484 15 20 73', $business['telephone']);
    }

    public function test_sitemap_lists_every_public_page(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        foreach (config('site.zones') as $zone) {
            $response->assertSee('/lavage-de-vitres/'.$zone['slug'], false);
        }
    }

    public function test_robots_points_to_the_sitemap(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Sitemap: https://eloglass.be/sitemap.xml', false);
    }
}
