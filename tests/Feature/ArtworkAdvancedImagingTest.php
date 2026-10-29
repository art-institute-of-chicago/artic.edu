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
        $artwork->save();

        return $artwork;
    }

    private function createMultimediaItemBlock(Artwork $artwork, $selected, string $title, string $description, array $extraContent = []): Block
    {
        $block = Block::firstOrNew([
            'blockable_id' => $artwork->id,
            'blockable_type' => Artwork::class,
            'type' => 'multimedia_item',
            'position' => 1,
        ]);
        $block->content = array_merge([
            'section_title' => $title,
            'description' => $description,
        ], $extraContent);
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

    public function test_mirador_block_default_view_overrides_record(): void
    {
        $apiArtwork = ApiArtwork::factory()->make();
        $this->mockArtworkApi($apiArtwork);

        $artwork = $this->createArtwork($apiArtwork);

        $mirador = Mirador::create(
            [
            'published' => true,
            'title' => 'Mirador Viewer Title',
            'object_id' => $apiArtwork->id,
            'default_view' => Mirador::BOOK_VIEW,
            ]
        );

        $this->createMultimediaItemBlock(
            $artwork,
            $mirador,
            'Mirador Section Title',
            'Mirador section description',
            ['mirador_settings' => true, 'default_view' => Mirador::SINGLE_VIEW]
        );

        $response = $this->get(route('artworks.show', ['id' => $apiArtwork->id, 'slug' => $apiArtwork->titleSlug]));

        $response->assertOk();
        $response->assertSee('data-view="single"', false);
    }

    public function test_mirador_block_default_manifest_url_uses_selected_record_object_id(): void
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
            'Mirador section description',
            ['mirador_settings' => true, 'default_manifest_url' => true]
        );

        $response = $this->get(route('artworks.show', ['id' => $apiArtwork->id, 'slug' => $apiArtwork->titleSlug]));

        $response->assertOk();
        $response->assertSee(
            config('api.public_uri') . '/api/v1/artworks/' . $apiArtwork->id . '/manifest.json'
        );
    }

    public function test_mirador_block_is_skipped_when_no_manifest(): void
    {
        $apiArtwork = ApiArtwork::factory()->make();
        $this->mockArtworkApi($apiArtwork);

        $artwork = $this->createArtwork($apiArtwork);

        $mirador = Mirador::create(
            [
            'published' => true,
            'title' => 'Mirador Viewer Title',
            'object_id' => null,
            'default_view' => Mirador::SINGLE_VIEW,
            ]
        );

        $this->createMultimediaItemBlock(
            $artwork,
            $mirador,
            'Manifestless Mirador Section Title',
            'Manifestless section description'
        );

        $response = $this->get(route('artworks.show', ['id' => $apiArtwork->id, 'slug' => $apiArtwork->titleSlug]));

        $response->assertOk();
        $response->assertDontSee('Manifestless Mirador Section Title');
    }

    public function test_mirador_block_ignores_settings_when_toggle_is_off(): void
    {
        $apiArtwork = ApiArtwork::factory()->make();
        $this->mockArtworkApi($apiArtwork);

        $artwork = $this->createArtwork($apiArtwork);

        $mirador = Mirador::create(
            [
            'published' => true,
            'title' => 'Mirador Viewer Title',
            'object_id' => $apiArtwork->id,
            'default_view' => Mirador::BOOK_VIEW,
            ]
        );

        $this->createMultimediaItemBlock(
            $artwork,
            $mirador,
            'Mirador Section Title',
            'Mirador section description',
            ['default_view' => Mirador::SINGLE_VIEW]
        );

        $response = $this->get(route('artworks.show', ['id' => $apiArtwork->id, 'slug' => $apiArtwork->titleSlug]));

        $response->assertOk();
        // The record wins while the block's settings toggle is off.
        $response->assertSee('data-view="book"', false);
    }
}
