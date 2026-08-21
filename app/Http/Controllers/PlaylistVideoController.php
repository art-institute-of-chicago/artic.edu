<?php

namespace App\Http\Controllers;

use App\Facades\EmbedConverterFacade;
use App\Helpers\ImageHelpers;
use App\Helpers\StringHelpers;
use App\Models\Playlist;
use App\Models\Video;
use App\Repositories\PlaylistVideoRepository;
use App\Repositories\VideoRepository;
use App\Libraries\SchemaOrg\SchemaMapper;
use Carbon\CarbonInterval;
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
        }

        // The playlist ItemList renders on this page (playlists.show redirects)
        $this->addJsonLd($playlist);
        $this->addJsonLd($video);

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

    /**
     * The schema.org definition for the given model.
     *
     * Shared defaults (e.g. inLanguage) come from the parent; page-specific
     * properties defined here are merged over them.
     *
     * @param mixed $model The model to map.
     *
     * @return array<string, mixed>
     */
    protected function jsonLdDefinition(mixed $model): array
    {
        // The playlist's item list maps each video through the Video
        // definition, so both are defined here.
        $videoThumbnail = static function ($m, $mapper) {
            try {
                $thumbnail = $m->thumbnail_url ?? null;
            } catch (\Throwable $e) {
                $thumbnail = null;
            }

            if (is_string($thumbnail) && str_starts_with($thumbnail, 'http')) {
                return $thumbnail;
            }

            return $mapper->imageUrl();
        };

        $videoDuration = static function ($m) {
            $duration = $m->duration ?? null;

            if (!is_numeric($duration) || (int) $duration <= 0) {
                return null;
            }

            return CarbonInterval::seconds((int) $duration)->cascade()->spec();
        };

        $videoTranscript = static function ($m) {
            if (empty($m->is_captioned)) {
                return null;
            }

            try {
                $caption = $m->standardCaption;
            } catch (\Throwable $e) {
                return null;
            }

            if (!$caption) {
                return null;
            }

            // The raw caption file is plain text (SRT/SubViewer); the
            // transcript accessor returns an HTML transcript built for the
            // video page, which does not belong in JSON-LD.
            try {
                $transcript = $caption->file;
            } catch (\Throwable $e) {
                return null;
            }

            if (is_string($transcript) && trim($transcript) !== '') {
                return trim($transcript);
            }

            return null;
        };

        $videoDefinition = [
            '@type' => 'VideoObject',
            'name' => 'title',
            'description' => SchemaMapper::text('list_description', 'heading', 'description'),
            'thumbnailUrl' => $videoThumbnail,
            'uploadDate' => SchemaMapper::iso('uploaded_at'),
            'duration' => $videoDuration,
            'contentUrl' => 'video_url',
            'embedUrl' => 'embed_url',
            'url' => SchemaMapper::videoUrl(),
            'mainEntityOfPage' => SchemaMapper::videoUrl(),
            'publisher' => SchemaMapper::orgRef(),
            'transcript' => $videoTranscript,
        ];

        $playlistUrl = static function ($m) {
            if (empty($m->id)) {
                return null;
            }

            try {
                return route('playlists.show', ['playlist' => $m->id]);
            } catch (\Throwable $e) {
                return null;
            }
        };

        $playlistItems = static function ($m, $mapper) use ($videoDefinition) {
            try {
                $videos = $m->videos ?? collect();
            } catch (\Throwable $e) {
                $videos = collect();
            }

            if (!$videos instanceof \Traversable) {
                return null;
            }

            $elements = [];
            $position = 1;

            foreach ($videos as $video) {
                $entity = $mapper->mapWith($video, $videoDefinition);

                if (empty($entity['name'])) {
                    continue;
                }

                $pivotPosition = is_object($video) && isset($video->pivot)
                    ? ($video->pivot->position ?? null)
                    : null;

                $elements[] = [
                    '@type' => 'ListItem',
                    'position' => is_numeric($pivotPosition) ? (int) $pivotPosition : $position,
                    'item' => $entity,
                ];

                $position++;
            }

            return empty($elements) ? null : $elements;
        };

        if ($model instanceof Playlist) {
            return array_merge(
                parent::jsonLdDefinition($model),
                [
                    '@type' => 'ItemList',
                    'url' => $playlistUrl,
                    'itemListElement' => $playlistItems,
                ]
            );
        }

        return array_merge(parent::jsonLdDefinition($model), $videoDefinition);
    }
}
