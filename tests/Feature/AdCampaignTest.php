<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use App\Models\Api\Artist;
use App\Models\Api\Artwork;
use Aic\Hub\Foundation\Testing\MockApi;
use App\Models\AdCampaign;
use App\Models\ApiRelation;

class AdCampaignTest extends BaseTestCase
{
    use MockApi;

    public Artist $artist;
    public Artwork $artwork;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->artist = Artist::factory()->make();
        $this->artwork = Artwork::factory()->make();
    }

    public function test_findPriorityForArtwork_finds_first_position_campaign(): void
    {
        $campaigns = AdCampaign::factory()->count(3)->ordered()->published()->create();

        $priorityCampaign = AdCampaign::findPriorityForArtwork($this->artwork->id);
        $this->assertTrue(
            $priorityCampaign->is($campaigns->first()),
            'The campaign with the lowest position is prioritized',
        );
        $this->assertEquals(1, $campaigns->first()->position);
    }

    public function test_findPriorityForArtwork_skips_inactive_campaigns(): void
    {
        AdCampaign::factory()->count(3)->ordered()->sequence(
            [
                'title' => 'Unpublished',
                'published' => false,
            ],
            [
                'title' => 'Expired',
                'published' => true,
                'start_date' => now()->subMonth(),
                'end_date' => now()->subDay(),
            ],
            [
                'title' => 'Upcoming',
                'published' => true,
                'start_date' => now()->addMonth(),
                'end_date' => now()->addMonths(2),
            ],
        );

        $priorityCampaign = AdCampaign::findPriorityForArtwork($this->artwork->id);
        $this->assertNull($priorityCampaign, 'No priority campaign is found when all campaigns are inactive');
    }

    public function test_findPriorityForArtwork_finds_campaign_with_artwork(): void
    {
        $campaigns = AdCampaign::factory()->count(3)->ordered()->published()->create();
        $campaignWithArtwork = $campaigns->pop(); // Pull the last position
        $campaignWithArtwork->artworks()->attach(
            ApiRelation::create(['datahub_id' => $this->artwork->id]),
            ['relation' => 'artworks', 'position' => 1],
        );

        $priorityCampaign = AdCampaign::findPriorityForArtwork($this->artwork->id);
        $this->assertTrue(
            $priorityCampaign->is($campaignWithArtwork),
            'The campaign with the associated artwork is prioritized',
        );
    }

    public function test_findPriorityForArtwork_skips_campaign_with_nonmatching_artwork(): void
    {
        $nonmatchingArtwork = Artwork::factory(['id' => $this->artwork->id + 1])->make();
        $campaigns = AdCampaign::factory()->count(3)->ordered()->published()->create();
        $campaignWithArtwork = $campaigns->shift(); // Pull the first position
        $campaignWithArtwork->artworks()->attach(
            ApiRelation::create(['datahub_id' => $nonmatchingArtwork->id]),
            ['relation' => 'artworks', 'position' => 1],
        );

        $priorityCampaign = AdCampaign::findPriorityForArtwork($this->artwork->id);
        $this->assertTrue(
            $priorityCampaign->isNot($campaignWithArtwork),
            'Campaigns with nonmatching associated artworks are skipped',
        );
        $this->assertTrue(
            $priorityCampaign->is($campaigns->first()),
            'The next campaign with the lowest position is prioritized',
        );
    }

    public function test_findPriorityForArtwork_finds_campaign_with_artist(): void
    {
        $campaigns = AdCampaign::factory()->count(3)->ordered()->published()->create();
        $campaignWithArtist = $campaigns->pop(); // Pull the last position
        $campaignWithArtist->artists()->attach(
            ApiRelation::create(['datahub_id' => $this->artist->id]),
            ['relation' => 'artists', 'position' => 1],
        );
        $this->addMockApiResponses($this->mockApiModelReponse($this->artist));
        $this->addMockApiResponses($this->mockApiSearchResponse([$this->artwork]));

        $priorityCampaign = AdCampaign::findPriorityForArtwork($this->artwork->id);
        $this->assertApiRequestCount(2);
        $this->assertApiRequestReceived(
            'POST',
            "/api/v1/artists/{$this->artist->id}",
            'The API received a request for the specified artists',
        );
        $this->assertApiRequestReceived(
            'POST',
            '/api/v1/search',
            "The API received a request for the artists' artworks",
        );
        $this->assertTrue(
            $priorityCampaign->is($campaignWithArtist),
            'The campaign with an artwork by the associated artist is prioritized',
        );
    }

    public function test_findPriorityForArtwork_skips_campaign_with_nonmatching_artist(): void
    {
        $nonmatchingArtist = Artist::factory(['id' => $this->artist->id + 1])->make();
        $nonmatchingArtwork = Artwork::factory(['id' => $this->artwork->id + 1])->make();
        $campaigns = AdCampaign::factory()->count(3)->ordered()->published()->create();
        $campaignWithArtist = $campaigns->shift(); // Pull the first position
        $campaignWithArtist->artists()->attach(
            ApiRelation::create(['datahub_id' => $nonmatchingArtist->id]),
            ['relation' => 'artists', 'position' => 1],
        );
        $this->addMockApiResponses($this->mockApiModelReponse($nonmatchingArtist));
        $this->addMockApiResponses($this->mockApiSearchResponse([$nonmatchingArtwork]));

        $priorityCampaign = AdCampaign::findPriorityForArtwork($this->artwork->id);
        $this->assertApiRequestCount(2);
        $this->assertApiRequestReceived(
            'POST',
            "/api/v1/artists/{$nonmatchingArtist->id}",
            'The API received a request for the specified artists',
        );
        $this->assertApiRequestReceived(
            'POST',
            '/api/v1/search',
            "The API received a request for the artists' artworks",
        );
        $this->assertTrue(
            $priorityCampaign->isNot($campaignWithArtist),
            'Campaigns with nonmatching artworks by the associated artist are skipped',
        );
        $this->assertTrue(
            $priorityCampaign->is($campaigns->first()),
            'The next campaign with the lowest position is prioritized',
        );
    }

    public function test_findPriorityForArtwork_continues_on_api_error(): void
    {
        $campaigns = AdCampaign::factory()->count(3)->ordered()->published()->create();
        $campaignWithArtist = $campaigns->shift(); // Pull the first position
        $campaignWithArtist->artists()->attach(
            ApiRelation::create(['datahub_id' => $this->artist->id]),
            ['relation' => 'artists', 'position' => 1],
        );
        $this->addMockApiResponses($this->mockApiModelReponse(statusCode: 404));

        $priorityCampaign = AdCampaign::findPriorityForArtwork($this->artwork->id);
        $this->assertApiRequestReceived(
            'POST',
            "/api/v1/artists/{$this->artist->id}",
            'The API received a request for the specified artists',
        );
        $this->assertTrue(
            $priorityCampaign->is($campaigns->first()),
            'The next campaign with the lowest position is prioritized',
        );
    }
}
