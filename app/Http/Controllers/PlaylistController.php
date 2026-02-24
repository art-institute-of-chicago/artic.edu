<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Repositories\PlaylistRepository;

class PlaylistController extends FrontController
{
    protected $repository;

    public function __construct(PlaylistRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    // Redirect to first publisehd video in playlist
    public function show(Playlist $playlist)
    {
        if ($video = $playlist->videos()->published()->first()) {
            return to_route('playlists.videos.show', [
                'playlist' => $playlist,
                'video' => $video,
                'slug' => $video->getSlug(),
                'darkMode' => true,
            ]);
        }
        abort(404);
    }
}
