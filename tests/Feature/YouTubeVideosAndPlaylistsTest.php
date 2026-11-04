<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use App\Models\Playlist;
use App\Models\Video;
use App\Services\OAuth\GoogleOAuthService;
use App\Services\YouTube\YouTubeService;
use Google\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use Mockery;

class YouTubeVideosAndPlaylistsTest extends BaseTestCase
{
    private array $sourceVideos;

    protected function setUp(): void
    {
        parent::setUp();
        Video::factory()->withYoutubeId('duplicate01')->create(['title' => 'Same Title']);
        Video::factory()->withYoutubeId('duplicate02')->create(['title' => 'Same Title']);
        $this->sourceVideos = [
            $this->sourceVideo('duplicate01', 'Same Title'),
            $this->sourceVideo('duplicate02', 'Same Title'),
            $this->sourceVideo('newvideo001', 'New Video'),
            $this->sourceVideo('private0001', 'Private Video', privacy: 'private'),
        ];
        $this->mockServices();
    }

    public function test_it_imports_new_uploads(): void
    {
        $this->artisan('youtube:videos-and-playlists')->assertSuccessful();

        $video = Video::firstWhere('youtube_id', 'newvideo001');
        $this->assertNotNull($video);
        $this->assertEquals('New Video', $video->title);
        $this->assertEquals(90, $video->duration);
        $this->assertEquals('1:30', $video->duration_display);
        $this->assertFalse($video->is_captioned);
    }

    public function test_it_deletes_deleted_and_private_videos(): void
    {
        $this->artisan('youtube:videos-and-playlists')->assertSuccessful();

        $this->assertTrue(Video::withoutGlobalScopes()->withTrashed()->firstWhere('youtube_id', 'deleted0001')->trashed());
        $this->assertTrue(Video::withoutGlobalScopes()->withTrashed()->firstWhere('youtube_id', 'private0001')->trashed());
    }

    public function test_it_syncs_playlists(): void
    {
        $this->artisan('youtube:videos-and-playlists')->assertSuccessful();

        $playlist = Playlist::firstWhere('youtube_id', 'playlist001');
        $this->assertEquals(
            ['newvideo001', 'duplicate01'],
            $playlist->videos->pluck('youtube_id')->all(),
        );
        $this->assertDatabaseHas('playlist_video', [
            'playlist_id' => $playlist->id,
            'video_id' => $playlist->videos->first()->id,
            'youtube_id' => 'item002',
        ]);
    }

    public function test_rerunning_does_not_add_slugs(): void
    {
        $this->artisan('youtube:videos-and-playlists')->assertSuccessful();
        $slugCount = DB::table('video_slugs')->count();

        $this->artisan('youtube:videos-and-playlists')->assertSuccessful();

        $this->assertEquals($slugCount, DB::table('video_slugs')->count());
    }

    public function test_rerunning_does_not_save_unchanged_videos(): void
    {
        $this->artisan('youtube:videos-and-playlists')->assertSuccessful();
        $updatedAt = Video::firstWhere('youtube_id', 'duplicate01')->updated_at;

        $this->travel(1)->hour();
        $this->artisan('youtube:videos-and-playlists')->assertSuccessful();

        $this->assertEquals($updatedAt, Video::firstWhere('youtube_id', 'duplicate01')->updated_at);
    }

    public function test_it_saves_changed_videos(): void
    {
        $this->artisan('youtube:videos-and-playlists')->assertSuccessful();

        $this->sourceVideos[0] = $this->sourceVideo('duplicate01', 'Changed Title | Art Institute Shorts');
        $this->artisan('youtube:videos-and-playlists')->assertSuccessful();

        $this->assertEquals('Changed Title', Video::firstWhere('youtube_id', 'duplicate01')->title);
    }

    private function mockServices(): void
    {
        $oAuth = Mockery::mock(GoogleOAuthService::class);
        $oAuth->client = new Client();
        $oAuth->shouldReceive('setApplicationName', 'refreshAccess', 'authorizeAccess');
        $this->app->instance(GoogleOAuthService::class, $oAuth);

        $uploads = collect($this->sourceVideos)
            ->map(fn ($video) => $this->playlistItem($video['id'], $video['snippet']['title']))
            ->push($this->playlistItem('deleted0001', 'Deleted video', 'This video is unavailable.'));
        $playlistItems = [
            ['id' => 'item001', 'snippet' => ['resourceId' => ['videoId' => 'duplicate01'], 'position' => 1]],
            ['id' => 'item002', 'snippet' => ['resourceId' => ['videoId' => 'newvideo001'], 'position' => 0]],
        ];
        $playlist = [
            'id' => 'playlist001',
            'snippet' => [
                'title' => 'Playlist',
                'thumbnails' => [],
                'publishedAt' => '2026-01-01T00:00:00Z',
            ],
        ];

        $youtube = Mockery::mock(YouTubeService::class);
        $youtube->shouldReceive('setLogger');
        $youtube->shouldReceive('clearSession')->andReturnSelf();
        $youtube->shouldReceive('session')->andReturnUsing(fn ($run) => $run());
        $youtube->shouldReceive('getRequestCount', 'getSessionUsage')->andReturn(0);
        $youtube->shouldReceive('getRemainingQuota')->andReturn(YouTubeService::QUOTA_LIMIT);
        $youtube->shouldReceive('uploadCount')->andReturn($uploads->count());
        $youtube->shouldReceive('uploads')->andReturnUsing(fn () => LazyCollection::make($uploads));
        $youtube->shouldReceive('videosByIds')->andReturnUsing(
            fn (Collection $ids) => LazyCollection::make(
                collect($this->sourceVideos)->whereIn('id', $ids->values())->values(),
            ),
        );
        $youtube->shouldReceive('shortsCount')->andReturn(0);
        $youtube->shouldReceive('shorts')->andReturn(LazyCollection::empty());
        $youtube->shouldReceive('playlistCount')->andReturn(1);
        $youtube->shouldReceive('playlists')->andReturnUsing(fn () => LazyCollection::make([$playlist]));
        $youtube->shouldReceive('itemsInPlaylist')->andReturnUsing(fn () => LazyCollection::make($playlistItems));
        $this->app->bind(YouTubeService::class, fn () => $youtube);
    }

    private function sourceVideo(string $id, string $title, string $privacy = 'public'): array
    {
        return [
            'id' => $id,
            'contentDetails' => ['caption' => 'false', 'duration' => 'PT1M30S'],
            'snippet' => [
                'title' => $title,
                'description' => "Description of $title",
                'publishedAt' => '2026-01-01T00:00:00Z',
                'thumbnails' => ['high' => ['url' => "https://i.ytimg.com/vi/$id/hqdefault.jpg", 'height' => 360, 'width' => 480]],
            ],
            'status' => ['privacyStatus' => $privacy],
        ];
    }

    private function playlistItem(string $videoId, string $title, ?string $description = null): array
    {
        return [
            'snippet' => [
                'resourceId' => ['videoId' => $videoId],
                'title' => $title,
                'description' => $description ?? "Description of $title",
            ],
        ];
    }
}
