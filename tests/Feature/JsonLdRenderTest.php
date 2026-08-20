<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use Aic\Hub\Foundation\Testing\MockApi;
use App\Models\Api\Artwork;
use App\Models\Api\Exhibition;
use App\Models\Article;
use App\Models\Event;
use App\Models\EventMeta;
use App\Models\LandingPage;
use App\Models\Playlist;
use App\Models\Video;

/**
 * End-to-end smoke tests for the JSON-LD rendered on real pages.
 *
 * Unit tests with stubs once missed a broken controller path
 * (SchemaMapper::mapWith on nested playlist videos), so these tests render
 * actual pages and assert against the decoded @graph payload of the single
 * <script type="application/ld+json"> tag emitted by the app layout.
 */
class JsonLdRenderTest extends BaseTestCase
{
    use MockApi;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();

        // Match ArtworkTest's fixture pattern: collection pages source default
        // related items from the seeded content pool, so publish a handful of
        // articles with hero media.
        Article::factory()->count(6)->published()->visible()->notUnlisted()->create();
    }

    /**
     * Every page must carry a single ld+json script whose @graph contains the
     * global Organization/Museum entity and the WebSite entity with its
     * SearchAction.
     */
    public function test_global_graph_renders_organization_and_website_on_any_page(): void
    {
        $response = $this->get(route('events'));
        $response->assertOk();

        $graph = $this->jsonLdGraph($response->getContent());

        $organization = $this->graphEntity($graph, 'Organization');
        $this->assertStringContainsString('#organization', (string) ($organization['@id'] ?? ''));

        $website = $this->graphEntity($graph, 'WebSite');
        $this->assertSame('SearchAction', $website['potentialAction']['@type'] ?? null);
    }

    /**
     * Regression: playlists.show redirects to the first published video, and
     * the video page renders the playlist ItemList by mapping each nested
     * video through SchemaMapper::mapWith(). The mapped entries must be
     * VideoObject entities.
     */
    public function test_playlist_page_graph_contains_item_list_of_video_objects(): void
    {
        $playlist = Playlist::factory()->create([
            'published' => true,
            'title' => 'JSON-LD Test Playlist',
            'youtube_id' => 'PL12345678901234567890123456789012',
        ]);
        $videos = Video::factory()->count(2)->create();
        $playlist->videos()->attach([
            $videos[0]->id => ['position' => 1, 'youtube_id' => $videos[0]->youtube_id],
            $videos[1]->id => ['position' => 2, 'youtube_id' => $videos[1]->youtube_id],
        ]);

        $response = $this->get(route('playlists.show', $playlist));
        $response->assertRedirect();
        $response = $this->get($response->headers->get('Location'));
        $response->assertOk();

        $graph = $this->jsonLdGraph($response->getContent());

        $itemList = $this->graphEntity($graph, 'ItemList');
        $this->assertNotEmpty($itemList['itemListElement'] ?? []);

        foreach ($itemList['itemListElement'] as $element) {
            $this->assertSame('ListItem', $element['@type'] ?? null);
            $this->assertSame('VideoObject', $element['item']['@type'] ?? null);
            $this->assertNotEmpty($element['item']['name'] ?? null);
        }
    }

    /**
     * Regression: the home and visit landing pages describe the museum itself.
     * Their @graph must carry exactly one Museum/Organization entity (the
     * global one) plus a WebPage entity whose mainEntity references it. A
     * second, duplicated Museum entity must not be pushed (review comment on
     * LandingPagesController: the previous addMuseumEntity() call added no new
     * JSON-LD because the organization is already part of the global graph).
     */
    public function test_home_page_graph_contains_single_museum_and_web_page_main_entity(): void
    {
        $this->createLandingPage(1, 'Home');

        $response = $this->get(route('home'));
        $response->assertOk();

        $graph = $this->jsonLdGraph($response->getContent());

        $museums = array_values(array_filter(
            $graph,
            static fn (array $entity) => in_array('Museum', (array) ($entity['@type'] ?? []), true)
        ));
        $this->assertCount(1, $museums, 'The Museum entity must appear exactly once');

        $webPage = $this->graphEntity($graph, 'WebPage');
        $this->assertSame(['@id' => 'https://www.artic.edu/#organization'], $webPage['mainEntity'] ?? null);
    }

    /**
     * The visit landing page behaves like the home page: single Museum entity
     * and a WebPage referencing it as mainEntity.
     */
    public function test_visit_page_graph_contains_single_museum_and_web_page_main_entity(): void
    {
        $this->createLandingPage(4, 'Visit');

        $response = $this->get(route('pages.slug', ['slug' => 'visit']));
        $response->assertOk();

        $graph = $this->jsonLdGraph($response->getContent());

        $museums = array_values(array_filter(
            $graph,
            static fn (array $entity) => in_array('Museum', (array) ($entity['@type'] ?? []), true)
        ));
        $this->assertCount(1, $museums, 'The Museum entity must appear exactly once');

        $webPage = $this->graphEntity($graph, 'WebPage');
        $this->assertSame(['@id' => 'https://www.artic.edu/#organization'], $webPage['mainEntity'] ?? null);
    }

    /**
     * Create a minimal landing page record (with labels so the home/visit
     * templates render) for a given type_id.
     */
    private function createLandingPage(int $typeId, string $title): LandingPage
    {
        $page = LandingPage::firstOrNew(['type_id' => $typeId, 'title' => $title, 'published' => true]);
        $page->header_variation = 'default';
        $page->labels = [
            'home_intro' => '<p>Welcome to the Art Institute of Chicago.</p>',
            'home_location_label' => '111 S Michigan Ave',
            'home_location_link' => 'https://goo.gl/maps/example',
            'home_buy_tix_label' => 'Buy Tickets',
            'home_buy_tix_link' => 'https://sales.artic.edu/admissions',
            'visit_nav_buy_tix_label' => 'Buy Tickets',
            'visit_nav_buy_tix_link' => 'https://sales.artic.edu/admissions',
            'visit_members_intro' => '<p>Members enjoy free admission.</p>',
            'visit_admission_intro' => '<p>Free admission opportunities.</p>',
            'visit_admission_tix_label' => 'Buy Tickets',
            'visit_admission_tix_link' => 'https://sales.artic.edu/admissions',
            'visit_admission_members_label' => 'Become a Member',
            'visit_admission_members_link' => 'https://sales.artic.edu/memberships',
            'visit_parking_label' => 'Transit & Parking',
            'visit_parking_link' => '/directions-and-parking',
            'visit_faqs_label' => 'More FAQs',
            'visit_faqs_link' => '/visit/frequently-asked-questions',
            'visit_faq_more_link' => '/visit/frequently-asked-questions',
        ];
        $page->save();

        return $page;
    }

    /**
     * The event detail page must carry a schema.org Event entity with an ISO
     * startDate and a concrete eventStatus.
     */
    public function test_event_detail_graph_contains_event_with_start_date_and_status(): void
    {
        $event = Event::factory()->create(['is_ticketed' => false, 'is_sold_out' => false]);
        $event->eventMetas()->save(
            EventMeta::factory()->make([
                'event_id' => $event->id,
                'date' => now()->addWeek(),
                'date_end' => now()->addWeek()->addDay(),
            ])
        );
        $event->save();

        // The event presenter resolves ticketed-event availability through the
        // API; queue generous empty responses so those lookups stay mocked.
        $this->addMockApiResponses([
            $this->mockApiSearchResponse(),
            $this->mockApiSearchResponse(),
            $this->mockApiSearchResponse(),
            $this->mockApiSearchResponse(),
        ]);

        $response = $this->get(route('events.show', $event));
        $response->assertOk();

        $graph = $this->jsonLdGraph($response->getContent());
        $eventEntity = $this->graphEntity($graph, 'Event');

        $this->assertNotEmpty($eventEntity['startDate'] ?? null);
        $this->assertSame('https://schema.org/EventScheduled', $eventEntity['eventStatus'] ?? null);
    }

    /**
     * The article detail page must carry an Article/BlogPosting entity with a
     * headline and an author.
     */
    public function test_article_detail_graph_contains_article_with_headline_and_author(): void
    {
        $article = Article::factory()->published()->visible()->notUnlisted()->create();

        $response = $this->get(route('articles.show', ['id' => $article->id, 'slug' => $article->getSlug()]));
        $response->assertOk();

        $graph = $this->jsonLdGraph($response->getContent());
        $entity = $this->graphEntityIn($graph, ['Article', 'BlogPosting']);

        $this->assertNotEmpty($entity['headline'] ?? null);
        $this->assertSame($article->title, $entity['headline']);

        $author = $entity['author'] ?? null;
        $this->assertNotEmpty($author);
        $firstAuthor = is_array($author) ? ($author[0] ?? $author) : $author;
        $this->assertSame('Person', $firstAuthor['@type'] ?? null);
        $this->assertNotEmpty($firstAuthor['name'] ?? null);
    }

    /**
     * The artwork detail page must carry a VisualArtwork entity with a
     * creator, following the ArtworkTest MockApi pattern exactly.
     */
    public function test_artwork_detail_graph_contains_visual_artwork_with_creator(): void
    {
        $artwork = Artwork::factory()->make(['artist_title' => 'Test Artist']);
        $this->addMockApiResponses([
            $this->mockApiModelReponse($artwork),
            $this->mockApiSearchResponse(), // Multisearch for related artworks
            $this->mockApiSearchResponse(), // Search for multimedia resources
            $this->mockApiSearchResponse(), // Search for educational resources
        ]);

        $response = $this->get(route('artworks.show', ['id' => $artwork->id, 'slug' => $artwork->titleSlug]));
        $response->assertOk();

        $graph = $this->jsonLdGraph($response->getContent());
        $entity = $this->graphEntity($graph, 'VisualArtwork');

        $creator = $entity['creator'] ?? null;
        $this->assertNotEmpty($creator);
        $firstCreator = is_array($creator) ? ($creator[0] ?? $creator) : $creator;
        $this->assertSame('Person', $firstCreator['@type'] ?? null);
        $this->assertSame('Test Artist', $firstCreator['name'] ?? null);
    }

    /**
     * The exhibition detail page must carry an ExhibitionEvent entity with a
     * concrete eventStatus.
     */
    public function test_exhibition_detail_graph_contains_exhibition_event_with_status(): void
    {
        $exhibition = Exhibition::factory()->make([
            'published' => true,
            'aic_start_at' => now()->subMonths(2)->toIso8601String(),
            'aic_end_at' => now()->addMonths(2)->toIso8601String(),
            'date_start' => now()->subMonths(2)->toIso8601String(),
            'date_end' => now()->addMonths(2)->toIso8601String(),
        ]);
        $this->addMockApiResponses([
            $this->mockApiModelReponse($exhibition),
            $this->mockApiSearchResponse(),
            $this->mockApiSearchResponse(),
        ]);

        $response = $this->get(route('exhibitions.show', ['id' => $exhibition->id, 'slug' => $exhibition->titleSlug]));
        $response->assertOk();

        $graph = $this->jsonLdGraph($response->getContent());
        $entity = $this->graphEntity($graph, 'ExhibitionEvent');

        $this->assertSame('https://schema.org/EventScheduled', $entity['eventStatus'] ?? null);
        $this->assertNotEmpty($entity['startDate'] ?? null);
    }

    /**
     * Decode the single application/ld+json script tag and return the @graph.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function jsonLdGraph(string $content): array
    {
        $this->assertSame(
            1,
            preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $content, $matches),
            'Expected exactly one application/ld+json script tag in the response'
        );

        $payload = json_decode($matches[1][0], true);
        $this->assertIsArray($payload);
        $this->assertSame('https://schema.org', $payload['@context'] ?? null);
        $this->assertIsArray($payload['@graph'] ?? null);

        return $payload['@graph'];
    }

    /**
     * Find the first graph entity carrying the given @type.
     *
     * @param array<int, array<string, mixed>> $graph
     * @return array<string, mixed>
     */
    protected function graphEntity(array $graph, string $type): array
    {
        $entity = $this->findEntity($graph, $type);

        if ($entity === null) {
            $this->fail("No @graph entity of type {$type} was rendered");
        }

        return $entity;
    }

    /**
     * Find the first graph entity carrying any of the given @types.
     *
     * @param array<int, array<string, mixed>> $graph
     * @param array<int, string>               $types
     * @return array<string, mixed>
     */
    protected function graphEntityIn(array $graph, array $types): array
    {
        foreach ($types as $type) {
            $entity = $this->findEntity($graph, $type);

            if ($entity !== null) {
                return $entity;
            }
        }

        $this->fail('No @graph entity of types ' . implode(', ', $types) . ' was rendered');
    }

    /**
     * @param array<int, array<string, mixed>> $graph
     * @return array<string, mixed>|null
     */
    private function findEntity(array $graph, string $type): ?array
    {
        foreach ($graph as $entity) {
            $types = (array) ($entity['@type'] ?? []);

            if (in_array($type, $types, true)) {
                return $entity;
            }
        }

        return null;
    }
}
