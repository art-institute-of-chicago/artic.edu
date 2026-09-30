<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use Aic\Hub\Foundation\Testing\MockApi;
use App\Jobs\GeneratePdf;
use App\Models\MyMuseumTour;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\DataProvider;

class MyMuseumTourStoreTest extends BaseTestCase
{
    use MockApi;

    private array $apiArtwork = [
        'id' => 28560,
        'title' => 'The Bedroom',
        'artist_title' => 'Vincent van Gogh',
        'date_display' => '1889',
        'short_description' => '<p>Van Gogh’s bedroom in Arles.</p>',
        'description' => '<p>Full description.</p>',
        'image_id' => '25c31d8d-21a4-9ea1-1d73-6a2eca4dda7e',
        'thumbnail' => [
            'lqip' => 'data:image/gif;base64,R0lGODlhBQAFAPQAAA==',
            'width' => 3000,
            'height' => 2365,
            'alt_text' => 'A painting of a bedroom.',
        ],
        'gallery_title' => 'Gallery 241',
        'gallery_id' => 2147475902,
    ];

    protected function setUp(): void
    {
        parent::setUp();
        Queue::fake();
    }

    public function test_artwork_details_are_reloaded_from_the_api(): void
    {
        $this->addMockApiResponses($this->mockApiCollectionResponse([$this->apiArtwork]));

        $response = $this->postJson('/api/v1/my-museum-tour', $this->payload([
            'artworks' => [
                [
                    'id' => 28560,
                    'title' => 'Tampered title',
                    'description' => '<img src=x onerror=alert(1)>',
                    'image_id' => 'tampered',
                    'objectNote' => 'My favorite',
                ],
            ],
        ]));

        $response->assertCreated();
        $artwork = MyMuseumTour::find($response->json('my_museum_tour.id'))->tour_json['artworks'][0];

        $this->assertEquals('The Bedroom', $artwork['title']);
        $this->assertEquals('<p>Van Gogh’s bedroom in Arles.</p>', $artwork['description']);
        $this->assertEquals($this->apiArtwork['image_id'], $artwork['image_id']);
        $this->assertEquals('1889', $artwork['display_date']);
        $this->assertEquals(3000, $artwork['thumbnail']['width']);
        $this->assertEquals('My favorite', $artwork['objectNote']);
        Queue::assertPushed(GeneratePdf::class);
    }

    public function test_unknown_artworks_are_rejected(): void
    {
        $this->addMockApiResponses($this->mockApiCollectionResponse([$this->apiArtwork]));

        $response = $this->postJson('/api/v1/my-museum-tour', $this->payload([
            'artworks' => [['id' => 28560], ['id' => 999999999]],
        ]));

        $response->assertUnprocessable()->assertJsonValidationErrors('tourJson.artworks', null);
        Queue::assertNothingPushed();
    }

    #[DataProvider('markupFieldProvider')]
    public function test_markup_is_rejected(string $field, array $tourJson): void
    {
        $response = $this->postJson('/api/v1/my-museum-tour', $this->payload($tourJson));

        $response->assertUnprocessable()->assertJsonValidationErrors($field, null);
        $this->assertApiRequestCount(0);
    }

    public static function markupFieldProvider(): array
    {
        $markup = '<script>alert(1)</script>';

        return [
            'title' => ['tourJson.title', ['title' => $markup]],
            'description' => ['tourJson.description', ['description' => "Hi <b>there</b>"]],
            'creatorName' => ['tourJson.creatorName', ['creatorName' => '<img src=x onerror=alert(1)>']],
            'recipientName' => ['tourJson.recipientName', ['recipientName' => '</p>Bob']],
            'objectNote' => ['tourJson.artworks.0.objectNote', ['artworks' => [['id' => 28560, 'objectNote' => '<!-- x -->']]]],
        ];
    }

    public function test_plain_text_with_angle_brackets_is_allowed(): void
    {
        $this->addMockApiResponses($this->mockApiCollectionResponse([$this->apiArtwork]));

        $response = $this->postJson('/api/v1/my-museum-tour', $this->payload([
            'title' => 'I <3 art',
            'description' => 'Paintings < sculptures',
        ]));

        $response->assertCreated();
        $this->assertEquals('I <3 art', $response->json('my_museum_tour.tour_json.title'));
    }

    private function payload(array $tourJson = []): array
    {
        return [
            'creatorEmail' => 'test@example.com',
            'marketingOptIn' => false,
            'tourJson' => array_merge([
                'title' => 'My tour',
                'description' => 'A tour',
                'creatorName' => 'Alex',
                'recipientName' => 'Sam',
                'artworks' => [['id' => 28560, 'objectNote' => 'A note']],
            ], $tourJson),
        ];
    }

    private function mockApiCollectionResponse(array $data): Response
    {
        return new Response(200, [], json_encode([
            'pagination' => [
                'total' => count($data),
                'limit' => 12,
                'offset' => 0,
                'total_pages' => 1,
                'current_page' => 1,
            ],
            'data' => $data,
        ]));
    }
}
