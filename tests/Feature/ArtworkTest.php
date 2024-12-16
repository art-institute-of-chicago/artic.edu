<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use App\Models\Api\Artwork;
use App\Models\Article;
use Illuminate\Foundation\Testing\WithFaker;
use Aic\Hub\Foundation\Testing\MockApi;

class ArtworkTest extends BaseTestCase
{
    use MockApi;
    use WithFaker;

    protected $seed = true;

    public function setUp(): void
    {
        parent::setUp();
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
        ]);

        $response = $this->get(route('artworks.show', ['id' => $artwork->id, 'slug' => $artwork->titleSlug]));
        $response->assertStatus(200);
        $response->assertSee('Title');
        $response->assertSee($artwork->title);
        $response->assertSee('Edition');
        $response->assertSee($artwork->edition);
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
}
