<?php

namespace App\Http\Controllers;

use App\Facades\EmbedConverterFacade;
use App\Models\Video;
use App\Repositories\VideoRepository;
use App\Libraries\SchemaOrg\SchemaMapper;
use Carbon\CarbonInterval;

class ShortsController extends FrontController
{
    // See frontend/js/functions/core/shortsPlayer.js
    public const SHORTS_PLAYER_ID = 'shorts-player-iframe';

    protected $repository;

    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    // Redirect to most recently published short
    public function index()
    {
        if (
            $video = $this->repository
                ->published()
                ->where('is_short', true)
                ->orderBy('uploaded_at', 'desc')
                ->first()
        ) {
            return to_route('shorts.show', [
                'video' => $video,
                'slug' => $video->getSlug(),
            ]);
        }
        abort(404);
    }

    public function show(Video $video)
    {
        if (!($video->published && $video->is_short)) {
            abort(404);
        }
        $canonicalPath = route('shorts.show', ['video' => $video]);
        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $previousShorts = $this->getPreviousVideos($video, 5);
        $nextShorts = $this->getNextVideos($video, 5);

        $dataAttributes = collect([$previousShorts, $video, $nextShorts])
            ->flatten()
            ->mapWithKeys(function ($short) {
                // Keyed by video id
                return [$short->id => $this->dataAttributes([
                    'id' => $short->id,
                    'title' => $short->title,
                    'embedId' => self::SHORTS_PLAYER_ID,
                    'loadVideoById' => $short->youtube_id,
                    'fullVideoUrl' => EmbedConverterFacade::sanitizeUrl($short->embedUrl, ['autoplay' => true])
                ])];
            });

        $this->seo->nofollow = true;
        $this->seo->noindex = true;

        $embed = EmbedConverterFacade::createYouTubeEmbed(
            attributes: [
                'id' => self::SHORTS_PLAYER_ID,
                'src' => $video->embed_url,
            ],
            parameters: [
                'autoplay' => true
            ]
        );

        $this->addJsonLd($video);

        return view('site.shortsDetail', [
            'item' => $video,
            'embed' => $embed,
            'previousItems' => $previousShorts,
            'nextItems' => $nextShorts,
            'dataAttributes' => $dataAttributes,
            'canonicalUrl' => $canonicalPath,
            'darkMode' => true,
        ]);
    }

    public function previous(Video $video)
    {
        $videos = $this->getPreviousVideos($video, 5);
        $dataAttributes = $videos->mapWithKeys(function ($short) {
            // Keyed by video id
            return [$short->id => $this->dataAttributes([
                'id' => $short->id,
                'title' => $short->title,
                'embedId' => self::SHORTS_PLAYER_ID,
                'loadVideoById' => $short->youtube_id,
                'fullVideoUrl' => EmbedConverterFacade::sanitizeUrl($short->embedUrl, ['autoplay' => true])
            ])];
        });

        $this->seo->nofollow = true;
        $this->seo->noindex = true;

        return view('site.moreShorts', [
            'items' => $videos,
            'dataAttributes' => $dataAttributes,
        ]);
    }

    public function next(Video $video)
    {
        $videos = $this->getNextVideos($video, 5);
        $dataAttributes = $videos->mapWithKeys(function ($short) {
            // Keyed by video id
            return [$short->id => $this->dataAttributes([
                'id' => $short->id,
                'title' => $short->title,
                'embedId' => self::SHORTS_PLAYER_ID,
                'loadVideoById' => $short->youtube_id,
                'fullVideoUrl' => EmbedConverterFacade::sanitizeUrl($short->embedUrl, ['autoplay' => true])
            ])];
        });

        $this->seo->nofollow = true;
        $this->seo->noindex = true;

        return view('site.moreShorts', [
            'items' => $videos,
            'dataAttributes' => $dataAttributes,
        ]);
    }

    private function getPreviousVideos(Video $video, int $count = 3)
    {
        return $this->repository
            ->published()
            ->where('is_short', true)
            ->where('uploaded_at', '>', $video->uploaded_at)
            ->orderBy('uploaded_at', 'asc')
            ->limit($count)
            ->get()
            ->reverse();
    }

    private function getNextVideos(Video $video, int $count = 3)
    {
        return $this->repository
            ->published()
            ->where('is_short', true)
            ->where('uploaded_at', '<', $video->uploaded_at)
            ->orderBy('uploaded_at', 'desc')
            ->limit($count)
            ->get();
    }

    /**
     * Convert an array into a data-attribute string.
     */
    private function dataAttributes(array $data): string
    {
        return collect($data)->map(function ($value, $key) {
            if (is_numeric($key)) {
                $attribute = str($value)->kebab()->prepend('data-');
            } else {
                $attribute = str($key)->kebab()->prepend('data-')->append("='$value'");
            }
            return $attribute;
        })->join(' ');
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

        return array_merge(
            parent::jsonLdDefinition($model),
            [
                '@type' => 'VideoObject',
                'inLanguage' => SchemaMapper::inLanguage(),
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
            ]
        );
    }
}
