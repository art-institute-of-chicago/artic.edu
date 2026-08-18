<?php

namespace Tests\Unit\Stubs;

class StubPlaylist
{
    public $id = 31;

    public $title = 'Artist Talks';

    public $description = '<p>Conversations with artists.</p>';

    public $videos;

    public function __construct()
    {
        $this->videos = collect([
            new StubVideo(),
            (function () {
                $video = new StubVideo();
                $video->id = 22;
                $video->title = 'A Second Talk';
                $video->youtube_id = 'def456';

                return $video;
            })(),
        ]);
    }
}
