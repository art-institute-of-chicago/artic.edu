<?php

namespace Tests\Unit\Stubs;

use Carbon\Carbon;

class StubVideo
{
    public $id = 21;

    public $title = 'Inside the Studio';

    public $list_description = '<p>A look behind the scenes.</p>';

    public $is_short = false;

    public $is_captioned = true;

    public $duration = 185;

    public $youtube_id = 'abc123';

    public $thumbnail_url = 'https://img.youtube.com/vi/abc123/hqdefault.jpg';

    public $uploaded_at;

    public $standardCaption;

    public function __construct()
    {
        $this->uploaded_at = Carbon::parse('2024-02-10 12:00:00');
        $this->standardCaption = (object) ['transcript' => 'Welcome to the studio. This is the transcript.'];
    }

    public function getSlug()
    {
        return 'inside-the-studio';
    }

    public function __get($key)
    {
        if ($key === 'video_url') {
            return 'https://youtube.com/watch?v=abc123';
        }

        if ($key === 'embed_url') {
            return 'https://www.youtube.com/embed/abc123';
        }

        return null;
    }
}
