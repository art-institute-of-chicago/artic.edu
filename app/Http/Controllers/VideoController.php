<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelpers;
use App\Helpers\StringHelpers;
use App\Models\Playlist;
use App\Models\Video;
use App\Models\VideoCategory;
use App\Repositories\VideoRepository;
use App\Libraries\SchemaOrg\SchemaMapper;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class VideoController extends FrontController
{
    public const VIDEOS_PER_PAGE = 12;

    protected $repository;

    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function show(Request $request, Video $video, $slug = null)
    {
        if (!$video->published || $video->privacy != 'public') {
            abort(404);
        }
        $canonicalPath = route('videos.show', ['video' => $video, 'slug' => $video->getSlug()]);
        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        if ($video->categories->first()) {
            $video->topics = $video->categories;
        }

        $this->seo->setTitle($video->meta_title ?: $video->title);
        $this->seo->setDescription($video->meta_description ?: ($video->list_description ?: ($video->heading ?: StringHelpers::truncateStr(strip_tags($video->present()->copy()), 297))));
        $this->seo->setImage($video->imageFront('hero'));

        $relatedVideos = $this->repository->getRelatedVideos($video);

        $poster = null;
        if (!$video->is_short) {
            $poster = $video->imageFront('hero') ?? ImageHelpers::youtubeItemAsArray($video);
        }

        $embed = $video->embed;
        $transcript = null;
        if ($video->is_captioned && $video->standardCaption?->hasActiveTranslation()) {
            $transcript = $video->standardCaption->transcript;
        }

        $this->addJsonLd($video);

        return view('site.videoDetail', [
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

    public function index()
    {
        $this->seo->setTitle('Videos');

        $videos = Video::published()
            ->byDuration(request('duration'))
            ->byVideoCategories(filter_var(request('category'), FILTER_VALIDATE_INT) !== false ? (int) request('category') : null)
            ->where('is_short', false)
            ->orderBy('uploaded_at', 'desc')
            ->get()->map(function ($video) {
                $video->sort_date = $video->uploaded_at;
                return $video;
            });

        $shorts = Video::published()
            ->byDuration(request('duration'))
            ->byVideoCategories(filter_var(request('category'), FILTER_VALIDATE_INT) !== false ? (int) request('category') : null)
            ->where('is_short', true)
            ->orderBy('uploaded_at', 'desc')
            ->get()->map(function ($video) {
                $video->sort_date = $video->uploaded_at;
                return $video;
            });

        $playlists = Playlist::published()
            ->whereHas('videos', function (Builder $query) {
                $query->published();
            })
            ->orderBy('published_at', 'desc')
            ->get()->map(function ($video) {
                $video->sort_date = $video->published_at;
                return $video;
            });

        if (request('category') == 'videos') {
            $items = $videos;
        } elseif (request('category') == 'shorts') {
            $items = $shorts;
        } elseif (request('category') == 'playlists') {
            $items = $playlists;
        } else {
            $items = $videos->concat($shorts);
            if (!request('duration') && !request('category')) {
                $items = $items->concat($playlists);
            }
        }
        $items = $items->sortByDesc('sort_date');

        $videosCount = $items->count();

        $perPage = self::VIDEOS_PER_PAGE;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $items->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginator = new LengthAwarePaginator($currentItems, count($items), $perPage, $currentPage, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

        $videos = $paginator;

        $filterCategories = [
            [
                'label' => 'All categories',
                'href' => route('videos.archive', ['duration' => request()->query('duration')]),
                'active' => empty(request()->query('category')),
                'ajaxScrollTarget' => 'listing',
            ],
            [
                'label' => 'Videos',
                'href' => route('videos.archive', ['category' => 'videos', 'duration' => request()->query('duration')]),
                'active' => request()->query('category') === 'videos',
                'ajaxScrollTarget' => 'listing',
            ],
            [
                'label' => 'Shorts',
                'href' => route('videos.archive', ['category' => 'shorts', 'duration' => request()->query('duration')]),
                'active' => request()->query('category') === 'shorts',
                'ajaxScrollTarget' => 'listing',
            ],
            [
                'label' => 'Playlists',
                'href' => route('videos.archive', ['category' => 'playlists', 'duration' => request()->query('duration')]),
                'active' => request()->query('category') === 'playlists',
                'ajaxScrollTarget' => 'listing',
            ],
        ];

        foreach (VideoCategory::all() as $cat) {
            array_push(
                $filterCategories,
                [
                    'label' => $cat->title,
                    'href' => route('videos.archive', ['category' => $cat->id, 'duration' => request()->query('duration')]),
                    'active' => request()->query('category') == $cat->id,
                    'ajaxScrollTarget' => 'listing',
                ]
            );
        }

        $filterDurations = [
            [
                'label' => 'Any duration',
                'href' => route('videos.archive', ['category' => request()->query('category')]),
                'active' => empty(request()->query('duration')),
                'ajaxScrollTarget' => 'listing',
            ],
        ];

        foreach (Video::$durations as $value => $label) {
            $filterDurations[] = [
                'label' => $label,
                'href' => route('videos.archive', ['category' => request()->query('category'), 'duration' => $value]),
                'active' => request()->query('duration') === $value,
                'ajaxScrollTarget' => 'listing',
            ];
        }

        if (request('category') || request('duration') || request('page')) {
            if (in_array(request()->query('category'), ['videos', 'shorts', 'playlists'], true)) {
                $cat = Str::ucfirst(request()->query('category'));
            } else {
                $cat = VideoCategory::where('id', request()->query('category'))->pluck('name')->first();
            }
            $dur = Video::$durations[request()->query('duration')] ?? '';
            $titles = array_filter([
                'Videos',
                $cat,
                $dur,
                request('page') ? 'Page ' . request('page') : null,
            ]);
            $this->seo->setTitle(implode(', ', $titles));
            $this->seo->nofollow = true;
            $this->seo->noindex = true;
        } else {
            $this->seo->setTitle('Videos');
        }

        return view('site.videos', [
            'primaryNavCurrent' => 'collection',
            'videos' => $videos,
            'videosCount' => $videosCount,
            'filterCategories' => $filterCategories,
            'filterDurations' => $filterDurations,
            'contrastHeader' => true,
            'darkMode' => true,
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
                // The Video model stores its display title on the plain `title`
                // column; declaring it explicitly keeps the entity's name from
                // depending on the parent WebPage fallback chain.
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
            ]
        );
    }
}
