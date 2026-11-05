<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use App\Models\Api\Artist;
use App\Models\Api\Artwork;
use App\Models\Article;
use Illuminate\Foundation\Testing\WithFaker;
use Aic\Hub\Foundation\Testing\MockApi;
use GuzzleHttp\Psr7\Response;

class ArtworkTest extends BaseTestCase
{
    use MockApi;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        // Artworks require at least six default related items.
        // See `App\Models\Behaviors\HasFeatureRelated::targetItemCount`.
        Article::factory()->count(6)->published()->visible()->notUnlisted()->create();
    }

    public function test_artwork_show_redirects_to_canonical_url_when_missing_slug(): void
    {
        $artwork = Artwork::factory()->make();
        $this->addMockApiResponses($this->mockApiModelReponse($artwork));

        $response = $this->get(route('artworks.show', ['id' => $artwork->id]));
        $response->assertRedirect(route('artworks.show', ['id' => $artwork->id, 'slug' => $artwork->titleSlug]));
    }

    public function test_artwork_show_displays_edition(): void
    {
        $artwork = Artwork::factory()->make();
        $this->addMockApiResponses([
            $this->mockApiModelReponse($artwork),
            $this->mockApiSearchResponse(), // Multisearch for related artworks
            $this->mockApiSearchResponse(), // Search for multimedia resources
            $this->mockApiSearchResponse(), // Search for educational resources
            $this->mockApiAiResponse(), // Nearest neighbors for artwork
        ]);

        $response = $this->get(route('artworks.show', ['id' => $artwork->id, 'slug' => $artwork->titleSlug]));
        $response->assertStatus(200);
        $response->assertSee('Title');
        $response->assertSee($artwork->title);
        $response->assertSee('Edition');
        $response->assertSee($artwork->edition);
    }

    public function test_nearest_neighbors_excludes_deaccessioned_artworks(): void
    {
        $visible = Artwork::factory()->make(['id' => 111, 'title' => 'Visible Artwork']);
        $deaccessioned = Artwork::factory()->make([
            'id' => 222,
            'title' => 'Deaccessioned Artwork',
            'fiscal_year_deaccession' => 2020,
        ]);

        $this->addMockApiResponses([
            new Response(200, [], json_encode(['items' => [
                ['model_id' => 111, 'distance' => 0.1],
                ['model_id' => 222, 'distance' => 0.2],
            ]])),
            new Response(200, [], json_encode(['data' => [
                $visible->toArray(),
                $deaccessioned->toArray(),
            ]])),
        ]);

        $subject = Artwork::factory()->make(['id' => 1]);
        $neighbors = $subject->nearestNeighbors();

        $this->assertEquals([111], $neighbors->pluck('id')->all());
    }

    public function test_artwork_show_tabbed_tombstone_overview_renders_label_value_rows(): void
    {
        $artwork = Artwork::factory()->make([
            'medium_display' => 'Oil on canvas',
            'credit_line' => 'Gift of the Test Foundation',
            'main_reference_number' => '2024.123',
        ]);
        $this->mockArtworkShow($artwork);

        $response = $this->getArtworkShow($artwork);
        $response->assertOk();
        $response->assertSee('Overview');
        $response->assertSee($artwork->title);
        $response->assertSee('Edition');
        $response->assertSee($artwork->edition);
        $response->assertSee('Medium');
        $response->assertSee('Oil on canvas');
        $response->assertSee('Credit Line');
        $response->assertSee('Gift of the Test Foundation');
        $response->assertSee('Reference Number');
        $response->assertSee('2024.123');
    }

    public function test_artwork_show_renders_long_form_tabs_when_data_is_present(): void
    {
        $artwork = Artwork::factory()->make([
            'publication_history' => "First publication\nSecond publication",
            'exhibition_history' => 'Exhibited at the Test Museum, 1999.',
            'provenance_text' => 'Private collection, Chicago.',
            'catalogue_display' => 'Test Catalogue Raisonné, no. 42.',
        ]);
        $this->mockArtworkShow($artwork);

        $response = $this->getArtworkShow($artwork);
        $response->assertOk();
        $response->assertSee('Publication History');
        $response->assertSee('Exhibition History');
        $response->assertSee('Provenance');
        $response->assertSee('Catalogues Raisonnés');
        $response->assertSee('-panel-publication-history', false);
        $response->assertSee('-panel-exhibition-history', false);
        $response->assertSee('-panel-provenance', false);
        $response->assertSee('-panel-catalogues-raisonnes', false);
    }

    public function test_artwork_show_omits_long_form_tabs_when_data_is_missing(): void
    {
        $artwork = Artwork::factory()->make();
        $this->mockArtworkShow($artwork);

        $response = $this->getArtworkShow($artwork);
        $response->assertOk();
        $response->assertSee('Overview');
        $response->assertDontSee('-panel-publication-history', false);
        $response->assertDontSee('-panel-exhibition-history', false);
        $response->assertDontSee('-panel-provenance', false);
        $response->assertDontSee('-panel-catalogues-raisonnes', false);
    }

    public function test_artwork_show_renders_multiline_publication_history_as_list(): void
    {
        $artwork = Artwork::factory()->make([
            'publication_history' => "First publication\nSecond publication",
        ]);
        $this->mockArtworkShow($artwork);

        $response = $this->getArtworkShow($artwork);
        $response->assertOk();
        $response->assertSee('o-tabbed-tombstone__list-item', false);
        $response->assertSee('First publication');
        $response->assertSee('Second publication');
        $response->assertDontSee('o-tabbed-tombstone__prose', false);
    }

    public function test_artwork_show_renders_single_line_publication_history_as_prose(): void
    {
        $artwork = Artwork::factory()->make([
            'publication_history' => 'A single line of publication history.',
        ]);
        $this->mockArtworkShow($artwork);

        $response = $this->getArtworkShow($artwork);
        $response->assertOk();
        $response->assertSee('o-tabbed-tombstone__prose', false);
        $response->assertSee('A single line of publication history.');
        $response->assertDontSee('o-tabbed-tombstone__list-item', false);
    }

    public function test_artwork_show_renders_api_and_linked_data_tab_with_api_and_iiif_rows(): void
    {
        $artwork = Artwork::factory()->make([
            'api_link' => 'https://api.artic.edu/api/v1/artworks/9999',
            'is_public_domain' => true,
        ]);
        $this->mockArtworkShow($artwork);

        $response = $this->getArtworkShow($artwork);
        $response->assertOk();
        $response->assertSee('API and Linked Data');
        $response->assertSee('https://api.artic.edu/api/v1/artworks/9999');
        $response->assertSee('IIIF Manifest');
        $response->assertSee('https://api.artic.edu/api/v1/artworks/' . $artwork->id . '/manifest.json');
    }

    public function test_artwork_show_api_and_linked_data_tab_omits_rows_without_values(): void
    {
        $artwork = Artwork::factory()->make([
            'is_public_domain' => false,
        ]);
        $this->mockArtworkShow($artwork);

        $response = $this->getArtworkShow($artwork);
        $response->assertOk();
        $response->assertSee('API and Linked Data');
        $response->assertSee('https://api.artic.edu/api/v1/artworks/' . $artwork->id);
        $response->assertDontSee('IIIF Manifest');
        $response->assertDontSee('Artist ULAN');
    }

    public function test_artwork_show_tabbed_tombstone_shows_caption_and_copy_affordances(): void
    {
        $artwork = Artwork::factory()->make([
            'medium_display' => 'Oil on canvas',
            'main_reference_number' => '2024.123',
        ]);
        $this->mockArtworkShow($artwork);

        $response = $this->getArtworkShow($artwork);
        $response->assertOk();
        $response->assertSee('Object information is a work in progress');
        $response->assertSee('o-tabbed-tombstone__copy', false);
        $response->assertSee('o-tabbed-tombstone__row-copy', false);
        $response->assertSee('data-copy-value=', false);
        $response->assertSee('data-copy="', false);
        $response->assertSee('2024.123');
        $response->assertSee('Copy Overview information');
    }

    public function test_artwork_show_overview_copy_payload_lists_values_without_labels_in_design_order(): void
    {
        $artwork = Artwork::factory()->make([
            'artist_display' => 'Test Artist (French, 1859-1891)',
            'title' => 'Test Title',
            'date_display' => '1884',
            'place_of_origin' => 'France',
            'medium_display' => 'Oil on canvas',
            'edition' => '3 of 10',
            'inscriptions' => 'Signed lower left',
            'dimensions' => '10 x 20 cm',
            'credit_line' => 'Gift of the Test Foundation',
            'copyright_notice' => 'Public Domain',
            'department_title' => 'Painting and Sculpture of Europe',
            'main_reference_number' => '2024.123',
        ]);
        $this->mockArtworkShow($artwork);

        $expected = implode("\n", [
            'Test Artist (French, 1859-1891)',
            'Test Title, 1884',
            'France',
            'Oil on canvas',
            '3 of 10',
            'Signed lower left',
            '10 x 20 cm',
            'Gift of the Test Foundation',
            'Public Domain',
            'Painting and Sculpture of Europe, 2024.123',
        ]);

        $response = $this->getArtworkShow($artwork);
        $response->assertOk();
        $response->assertSee($expected);
        $response->assertDontSee('Reference Number:');
        $response->assertDontSee('Credit Line:');
    }

    public function test_artwork_show_overview_copy_payload_keeps_artist_display_line_breaks(): void
    {
        $artwork = Artwork::factory()->make([
            'artist_display' => "Adler & Sullivan; American, 1883-1896\nVinci & Kenny; American, 1970-1977",
            'title' => 'Test Title',
            'date_display' => '1884',
        ]);
        $this->mockArtworkShow($artwork);

        $response = $this->getArtworkShow($artwork);
        $response->assertOk();
        $response->assertSee("Adler & Sullivan; American, 1883-1896\nVinci & Kenny; American, 1970-1977");
    }

    public function test_artwork_show_tabbed_tombstone_renders_one_caption_and_keeps_iiif_in_api_tab(): void
    {
        $artwork = Artwork::factory()->make([
            'api_link' => 'https://api.artic.edu/api/v1/artworks/9999',
            'is_public_domain' => true,
        ]);
        $this->mockArtworkShow($artwork);

        $html = $this->getArtworkShow($artwork)->assertOk()->getContent();

        $this->assertSame(1, substr_count($html, 'o-tabbed-tombstone__footer u-hide@small-'));
        // The IIIF manifest row belongs to the API & linked data tab only.
        preg_match('/-panel-overview"(.+?)o-tabbed-tombstone__panel-fade/s', $html, $overviewPanel);
        $this->assertNotEmpty($overviewPanel[1] ?? null, 'Expected an overview panel');
        $this->assertStringNotContainsString('IIIF Manifest', $overviewPanel[1]);
        $this->assertStringContainsString('IIIF Manifest', $html);
        // The licensing line was dropped from the tombstone caption.
        $this->assertSame(0, substr_count($html, 'Information about image downloads and licensing'));
    }

    public function test_artwork_show_overview_artist_row_uses_plain_artist_display(): void
    {
        $artwork = Artwork::factory()->make([
            'artist_display' => "Adler & Sullivan, original architects; American, 1883-1896\nVinci & Kenny, reconstruction architects; American, 1970-1977",
            'artist_pivots' => [
                (object) [
                    'artist_id' => 40810,
                    'artist_title' => 'Adler & Sullivan',
                    'role_id' => 219,
                    'role_title' => 'Architect',
                ],
            ],
        ]);
        $this->mockArtworkShow($artwork);

        $response = $this->getArtworkShow($artwork);
        $response->assertOk();

        preg_match('/<dd class="o-tabbed-tombstone__value">(.+?)<\/dd>/s', $response->getContent(), $artistValue);
        $artistRow = $artistValue[1] ?? '';

        $this->assertStringContainsString('Adler &amp; Sullivan, original architects; American, 1883-1896', $artistRow);
        $this->assertStringContainsString('Vinci &amp; Kenny, reconstruction architects; American, 1970-1977', $artistRow);
        $this->assertStringContainsString('<br>', $artistRow);
        $this->assertStringNotContainsString('<a ', $artistRow);
    }

    public function test_tabbed_tombstone_reads_ulan_id_from_the_artist_record(): void
    {
        $artwork = Artwork::factory()->make([
            'artist_pivots' => [
                (object) [
                    'artist_id' => 40810,
                    'artist_title' => 'Georges Seurat',
                    'role_id' => 219,
                    'role_title' => 'Artist',
                ],
            ],
        ]);

        $artist = Artist::factory()->make([
            'id' => 40810,
            'title' => 'Georges Seurat',
            'ulan_id' => '5000088',
        ]);

        $this->addMockApiResponses(
            new Response(200, [], json_encode(['data' => [$artist->toArray()]]))
        );

        $block = $artwork->presentAdmin()->getTabbedTombstoneBlock();
        $apiTab = collect($block['tabs'])->firstWhere('id', 'api-and-linked-data');

        $this->assertNotEmpty($apiTab, 'Expected an API and linked data tab');
        $this->assertStringContainsString('https://vocab.getty.edu/ulan/5000088', $apiTab['copy']);
    }

    public function test_artwork_show_tabbed_tombstone_copy_payload_has_no_zero_width_characters(): void
    {
        $artwork = Artwork::factory()->make([
            'main_reference_number' => "2024.\u{200B}123",
        ]);
        $this->mockArtworkShow($artwork);

        $html = $this->getArtworkShow($artwork)->assertOk()->getContent();

        preg_match('/data-copy-value="([^"]*2024[^"]*)"/', $html, $matches);

        $this->assertNotEmpty($matches[1] ?? null, 'Expected an overview copy payload');
        $this->assertStringContainsString('2024.123', $matches[1]);
        $this->assertStringNotContainsString("\u{200B}", $matches[1]);
    }

    public function test_artwork_show_retrieves_related_media(): void
    {
        $this->markTestSkipped("We're hiding related content entirely using the SHOW_DEFAULT_RELATED_ITEMS feature flag");
        $artwork = Artwork::factory()->make();
        $this->addMockApiResponses([
            $this->mockApiModelReponse($artwork),
            $this->mockApiSearchResponse(), // Multisearch for related artworks
            $this->mockApiSearchResponse(), // Search for multimedia resources
            $this->mockApiSearchResponse(), // Search for educational resources
        ]);

        $response = $this->get(route('artworks.show', ['id' => $artwork->id, 'slug' => $artwork->titleSlug]));
        $response->assertSee('Discover More');
        $this->assertApiRequestReceived('GET', "/api/v1/artworks/{$artwork->id}");
        $this->assertApiRequestReceived('POST', '/api/v1/msearch');
        $this->assertApiRequestReceived('POST', '/api/v1/search');
        $this->assertApiRequestReceived('POST', '/api/v1/search');
        $this->assertApiRequestCount(4, 'artworks.show requires four requests to the API');
    }

    /**
     * Queue the API responses the artwork detail page needs.
     */
    private function mockArtworkShow(Artwork $artwork): void
    {
        $this->addMockApiResponses([
            $this->mockApiModelReponse($artwork),
            $this->mockApiSearchResponse(), // Multisearch for related artworks
            $this->mockApiSearchResponse(), // Search for multimedia resources
            $this->mockApiSearchResponse(), // Search for educational resources
            $this->mockApiAiResponse(), // Nearest neighbors for artwork
        ]);
    }

    public function test_artwork_show_tabbed_tombstone_shows_every_panel_in_print_mode(): void
    {
        $artwork = Artwork::factory()->make([
            'is_public_domain' => false,
            'publication_history' => '<p>Published in 1886.</p>',
        ]);
        $this->mockArtworkShow($artwork);

        $this->app->instance('printservice', new class () {
            public function isPrintMode()
            {
                return true;
            }
        });

        $html = $this->get(route('artworks.show', [
            'id' => $artwork->id,
            'slug' => $artwork->titleSlug,
        ]))->assertOk()->getContent();

        preg_match_all('/o-tabbed-tombstone__panel(?=[\s"])[^>]*>/s', $html, $panels);

        $this->assertGreaterThan(1, count($panels[0]), 'Expected more than one tombstone panel');

        foreach ($panels[0] as $panel) {
            $this->assertStringNotContainsString('hidden', $panel);
        }
    }

    private function getArtworkShow(Artwork $artwork)
    {
        return $this->get(route('artworks.show', ['id' => $artwork->id, 'slug' => $artwork->titleSlug]));
    }
}
