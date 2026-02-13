<?php

namespace App\Http\Controllers;

use App\Facades\EmbedConverterFacade;
use App\Helpers\ImageHelpers;
use App\Helpers\StringHelpers;
use App\Models\Playlist;
use App\Models\Video;
use App\Repositories\PlaylistVideoRepository;
use App\Repositories\VideoRepository;
use Illuminate\Http\Request;

class PlaylistVideoController extends FrontController
{
    protected $repository;

    public function __construct(PlaylistVideoRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function show(Request $request, Playlist $playlist, Video $video, $slug = null)
    {
        if (!($playlist->published && $video->published)) {
            abort(404);
        }
        $canonicalPath = route('playlists.videos.show', [
            'playlist' => $playlist,
            'video' => $video,
            'slug' => $video->getSlug(),
        ]);
        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($video->meta_title ?: $video->title);
        $this->seo->setDescription(
            $video->meta_description ?: (
                $video->list_description ?: (
                    $video->heading ?: StringHelpers::truncateStr(strip_tags($video->present()->copy()), 297)
                )
            )
        );
        $this->seo->setImage($video->imageFront('hero'));

        $relatedVideos = app(VideoRepository::class)->getRelatedVideos($video);

        $poster = null;
        if (!$video->is_short) {
            $poster = $video->imageFront('hero') ?? ImageHelpers::youtubeItemAsArray($video);
        }

        $embed = $video->embed;
        $transcript = null;
        if ($video->is_captioned && $video->standardCaption?->hasActiveTranslation()) {
            $transcript = $video->standardCaption->transcript;
            if ($request->has('transcript')) {
                $poster = null;
                $embed = EmbedConverterFacade::createYouTubeEmbed(
                    attributes: [
                        'id' => $video->youtube_id,
                        'src' => $video->embed_url,
                    ],
                    parameters: [
                        'start' => $request->get('start'),
                        'autoplay' => true,
                    ]
                );
            }
        }

        return view('site.videoDetail', [
            'playlist' => $playlist,
            'item' => $video,
            'poster' => $poster,
            'embed' => $embed,
            'transcript' => $transcript,
            'showTranscript' => $request->query('transcript') === 'true',
            'relatedVideos' => $relatedVideos,
            'contrastHeader' => true,
            'unstickyHeader' => true,
            'darkMode' => true,
            'canonicalUrl' => $canonicalPath,
        ]);
    }
}
