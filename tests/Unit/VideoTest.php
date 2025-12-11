<?php

namespace Tests\Unit;

use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class VideoTest extends BaseTestCase
{
    use RefreshDatabase;

    public function test_video_url_accessor_returns_expected_url_with_known_youtube_id(): void
    {
        $youtubeId = 'dQw4w9WgXcQ';
        $video = Video::factory()->withYoutubeId($youtubeId)->create();

        $expectedUrl = "https://youtube.com/watch?v={$youtubeId}";
        $this->assertEquals($expectedUrl, $video->video_url);
    }

    public function test_video_url_accessor_formats_url_correctly(): void
    {
        $testCases = [
            'abc123def45' => 'https://youtube.com/watch?v=abc123def45',
            'XyZ_-AbCdEf' => 'https://youtube.com/watch?v=XyZ_-AbCdEf',
            '1234567890a' => 'https://youtube.com/watch?v=1234567890a',
        ];

        foreach ($testCases as $youtubeId => $expectedUrl) {
            $video = Video::factory()->withYoutubeId($youtubeId)->create();
            $this->assertEquals($expectedUrl, $video->video_url, "URL format incorrect for YouTube ID: {$youtubeId}");
        }
    }

    public function test_video_url_accessor_with_empty_youtube_id(): void
    {
        $video = Video::factory()->create(['youtube_id' => '']);

        $this->assertNull($video->video_url);
    }

    public function test_video_url_is_included_in_array_output(): void
    {
        $youtubeId = 'testId1';
        $video = Video::factory()->withYoutubeId($youtubeId)->create();

        $videoArray = $video->transform();
        $this->assertArrayHasKey('video_url', $videoArray);
        $this->assertEquals("https://youtube.com/watch?v={$youtubeId}", $videoArray['video_url']);
    }

    public function test_video_url_accessor_present_when_retrieved_via_eloquent_query(): void
    {
        $youtubeId = 'testIdQuery';
        $createdVideo = Video::factory()->withYoutubeId($youtubeId)->create();

        $retrievedVideo = Video::query()->find($createdVideo->id);

        $this->assertNotNull($retrievedVideo);
        $this->assertEquals("https://youtube.com/watch?v={$youtubeId}", $retrievedVideo->video_url);
    }

    public function test_video_url_accessor_consistent_across_create_and_retrieve(): void
    {
        $youtubeId = 'testIdConst';
        $createdVideo = Video::factory()->withYoutubeId($youtubeId)->create();
        $createdVideoUrl = $createdVideo->video_url;

        $retrievedVideo = Video::query()->findOrFail($createdVideo->id);
        $retrievedVideoUrl = $retrievedVideo->video_url;

        $this->assertEquals($createdVideoUrl, $retrievedVideoUrl);
        $this->assertEquals("https://youtube.com/watch?v={$youtubeId}", $retrievedVideoUrl);
    }
}
