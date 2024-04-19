<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use App\Models\Page;
use App\Models\Article;
use App\Models\Experience;
use App\Models\Highlight;
use App\Helpers\StringHelpers;
use App\Models\Video;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleController extends FrontController
{
    public const ARTICLES_PER_PAGE = 12;
    protected $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function index()
    {
        $this->seo->setTitle('Articles');

        $page = Page::forType('Articles')->first();

        if (request('category') !== 'interactive-features') {
            $articles = Article::published()
                ->notUnlisted()
                ->byCategories(request('category'))
                ->orderBy('date', 'desc')
                ->get()->map(function ($article) {
                    $article->sort_date = $article->date ?? $article->created_at;
                    return $article;
                });

            $highlights = Highlight::published()
                ->notUnlisted()
                ->byCategories(request('category'))
                ->orderBy('publish_start_date', 'desc')
                ->get()->map(function ($highlight) {
                    $highlight->sort_date = $highlight->publish_start_date ?? $highlight->created_at;
                    return $highlight;
                });

            $experiences = Experience::published()
                ->notUnlisted()
                ->byCategories(request('category'))
                ->orderBy('created_at', 'desc')
                ->get()->map(function ($experience) {
                    $experience->sort_date = $experience->created_at;
                    return $experience;
                });

            $videos = Video::published()
                ->byCategories(request('category'))
                ->where('is_listed', true)
                ->orderBy('date', 'desc')
                ->get()->map(function ($video) {
                    $video->sort_date = $video->date ?? $video->created_at;
                    return $video;
                });

            $items = $articles->concat($highlights)->concat($experiences)->concat($videos)->sortByDesc('sort_date');

            if (request('type')) {
                $items = $items->where('type', (Str::singular(request('type'))));
            }

            $articlesCount = $items->count();

            $perPage = self::ARTICLES_PER_PAGE;
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentItems = $items->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $paginator = new LengthAwarePaginator($currentItems, count($items), $perPage, $currentPage, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

            $articles = $paginator;
        } else {
            // Retrieve experiences entires
            $articles = Experience::webPublished()->articlePublished()->paginate(self::ARTICLES_PER_PAGE);
        }

        $types = [
            [
                'label' => 'All',
                'href' => route('articles', ['category' => request()->query('category')]),
                'active' => empty(request()->all()),
                'ajaxScrollTarget' => 'listing',
            ],
        ];

        $contentTypes = ['Articles', 'Highlights', 'Videos', 'Experiences'];

        foreach ($contentTypes as $type) {
            array_push(
                $types,
                [
                'label' => $type,
                'href' => route('articles', array_merge(['type' => strtolower($type)], null !== request()->query('category') ? ['category' => request()->query('category')] : [])),
                'active' => request()->get('type') == strtolower($type),
                'ajaxScrollTarget' => 'listing',
                ]
            );
        }

        // These should be moved away from the controller.
        $categories = [
            [
                'label' => 'All',
                'href' => route('articles', ['type' => request()->query('type')]),
                'active' => empty(request()->all()),
                'ajaxScrollTarget' => 'listing',
            ]
        ];

        foreach ($page->articlesCategories as $category) {
            array_push(
                $categories,
                [
                    'label' => $category->name,
                    'href' => route('articles', array_merge(['category' => $category->id], null !== request()->query('type') ? ['type' => request()->query('type')] : [])),
                    'active' => request()->get('category') == $category->id,
                    'ajaxScrollTarget' => 'listing',
                    'id' => $category->id,
                ]
            );
        }

        if (Experience::webPublished()->articlePublished()->count() > 0) {
            array_push(
                $categories,
                [
                    'label' => 'Interactive Features',
                    'href' => route('articles', ['category' => 'interactive-features']),
                    'active' => request()->get('category') == 'interactive-features',
                    'ajaxScrollTarget' => 'listing',
                ]
            );
        }

        return view('site.articles', [
            'primaryNavCurrent' => 'collection',
            'page' => $page,
            'articles' => $articles,
            'articlesCount' => $articlesCount,
            'categories' => $categories,
            'types' => $types,
        ]);
    }

    public function show($id, $slug = null)
    {
        $item = $this->repository->published()->find((int) $id);

        if (!$item) {
            abort(404);
        }

        $canonicalPath = route('articles.show', ['id' => $item->id, 'slug' => $item->getSlug()]);

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->heading ?: StringHelpers::truncateStr(strip_tags($item->present()->copy()), 297));
        $this->seo->setImage($item->imageFront('hero'));

        if ($item->is_unlisted) {
            $this->seo->nofollow = true;
            $this->seo->noindex = true;
        }

        $this->seo->citationTitle = $item->meta_title ?: $item->title;
        $this->seo->citationPublisher = 'The Art Institute of Chicago';

        foreach ($item->authors as $author) {
            $this->seo->citationAuthor[] = $author->title;
        }

        if (empty($this->seo->citationAuthor)) {
            $this->seo->citationAuthor[] = $item->author_display;
        }
        $this->seo->citationPublicationDate = $item->date->toDateString();
        $this->seo->citationOnlineDate = $item->date->toDateString();

        if ($item->categories->first()) {
            $item->topics = $item->categories;
        }

        return view('site.articleDetail', [
            'item' => $item,
            'autoRelated' => $this->getAutoRelated($item),
            'featuredRelated' => $this->getFeatureRelated($item),
            'contrastHeader' => $item->present()->contrastHeader,
            'furtherReadingTitle' => $this->repository->getFurtherReadingTitle($item) ?? null,
            'furtherReadingItems' => $this->repository->getFurtherReadingItems($item) ?? null,
            'canonicalUrl' => $canonicalPath,
            'pageMetaData' => $this->getPageMetaData($item),
        ]);
    }

    protected function setPageMetaData($item)
    {
        return [
            'type' => 'article',
            'tags' => $item->categories->implode(','),
            'authors' => implode(',', $this->seo->citationAuthor),
            'publish-date' => $item->date->toDateString(),
        ];
    }
}
