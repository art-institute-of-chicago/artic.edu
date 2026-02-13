<?php

namespace App\Http\Controllers;

use App\Facades\EmbedConverterFacade;
use App\Helpers\ImageHelpers;
use App\Helpers\StringHelpers;
use App\Models\Playlist;
use App\Models\Video;
use App\Models\VideoCategory;
use App\Repositories\VideoRepository;
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
        if (!$video->published) {
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
}
