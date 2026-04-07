<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use App\Models\Video;

class VideoTest extends BaseTestCase
{
    public function test_unlisted_videos_404(): void
    {
        $video = Video::factory()->create(['privacy' => 'unlisted']);

        $response = $this->get("/videos/$video->id");
        $response->assertNotFound();
    }

    public function test_private_videos_404(): void
    {
        $video = Video::factory()->create(['privacy' => 'private']);

        $response = $this->get("/videos/$video->id");
        $response->assertNotFound();
    }

    public function test_public_videos_200(): void
    {
        $video = Video::factory()->create(['privacy' => 'public']);

        $response = $this->get("/videos/$video->id/$video->slug");
        $response->assertOk();
    }
}
