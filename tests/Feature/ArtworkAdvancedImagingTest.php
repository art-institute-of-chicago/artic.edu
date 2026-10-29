<?php

/**
 * AI-generated: Trevin Alonzo (webdevtrev), 2026-10-27, DeepSeek Flash.
 */

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use Aic\Hub\Foundation\Testing\MockApi;
use App\Models\Api\Artwork as ApiArtwork;
use App\Models\Article;
use App\Models\Artwork;
use App\Models\Experience;
use App\Models\Mirador;
use App\Models\Vendor\Block;
use Illuminate\Foundation\Testing\WithFaker;

class ArtworkAdvancedImagingTest extends BaseTestCase
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

    private function mockArtworkApi(ApiArtwork $artwork): void
    {
        $this->addMockApiResponses([
            $this->mockApiModelReponse($artwork),
            $this->mockApiSearchResponse(), // Multisearch for related artworks
            $this->mockApiSearchResponse(), // Search for multimedia resources
            $this->mockApiSearchResponse(), // Search for educational resources
            $this->mockApiAiResponse(), // Nearest neighbors for artwork
        ]);
    }

    private function createArtwork(ApiArtwork $apiArtwork): Artwork
    {
        $artwork = new Artwork();
        $artwork->datahub_id = $apiArtwork->id;
        $artwork->title = $apiArtwork->title;
        $artwork->save();

        return $artwork;
    }

    private function createMultimediaItemBlock(Artwork $artwork, $selected, string $title, string $description): Block
    {
        $block = Block::firstOrNew([
            'blockable_id' => $artwork->id,
            'blockable_type' => Artwork::class,
            'type' => 'multimedia_item',
            'position' => 1,
        ]);
        $block->content = [
            'section_title' => $title,
            'description' => $description,
        ];
        $block->save();

        $block->saveRelated([$selected], 'multimedia_item');

        return $block;
    }

    public function test_mirador_multimedia_block_renders_in_advanced_imaging(): void
    {
        $apiArtwork = ApiArtwork::factory()->make();
        $this->mockArtworkApi($apiArtwork);

        $artwork = $this->createArtwork($apiArtwork);

        $mirador = Mirador::create(
            [
            'published' => true,
            'title' => 'Mirador Viewer Title',
            'object_id' => $apiArtwork->id,
            'default_view' => Mirador::SINGLE_VIEW,
            ]
        );

        $this->createMultimediaItemBlock(
            $artwork,
            $mirador,
            'Mirador Section Title',
            'Mirador section description'
        );

        $response = $this->get(route('artworks.show', ['id' => $apiArtwork->id, 'slug' => $apiArtwork->titleSlug]));

        $response->assertOk();
        $response->assertSee('Mirador Section Title');
        $response->assertSee('Mirador section description');
        $response->assertSee('data-behavior="viewerMirador"', false);
        $response->assertSee(
            config('api.public_uri') . '/api/v1/artworks/' . $apiArtwork->id . '/manifest.json'
        );
    }

    public function test_legacy_interactive_feature_renders_as_related_content_link(): void
    {
        $apiArtwork = ApiArtwork::factory()->make();
        $this->mockArtworkApi($apiArtwork);

        $artwork = $this->createArtwork($apiArtwork);

        $experience = Experience::factory()->create();

        $this->createMultimediaItemBlock(
            $artwork,
            $experience,
            'Interactive Feature Section Title',
            'Interactive feature section description'
        );

        $response = $this->get(route('artworks.show', ['id' => $apiArtwork->id, 'slug' => $apiArtwork->titleSlug]));

        $response->assertOk();
        $response->assertSee('Interactive Feature Section Title');

        $showUrl = route('interactiveFeatures.show', ['slug' => $experience->getSlug()]);
        $kioskUrl = route('interactiveFeatures.show-kiosk', ['slug' => $experience->getSlug()]);

        $response->assertSee($showUrl, false);
        $response->assertDontSee($kioskUrl, false);
    }
}
