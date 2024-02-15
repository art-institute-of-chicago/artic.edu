<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use App\Models\Page;
use App\Models\Article;
use App\Models\Experience;
use App\Models\Highlight;
use App\Helpers\StringHelpers;
use App\Models\Video;
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

        $featuredItems = $page->getRelatedWithApiModels('featured_items', [], [
            'articles' => false,
            'experiences' => false
        ]);

        $heroArticle = $featuredItems->first();

        if (request('category') !== 'interactive-features') {
            $articles = Article::published()
                ->notUnlisted()
                ->byCategories(request('category'))
                ->whereNotIn('id', $featuredItems->pluck('id'))
                ->orderBy('date', 'desc')
                ->get()->map(function ($article) {
                    $article->sort_date = $article->date;
                    return $article;
                });

            $highlights = Highlight::published()
                ->notUnlisted()
                ->byCategories(request('category'))
                ->whereNotIn('id', $featuredItems->pluck('id'))
                ->orderBy('publish_start_date', 'desc')
                ->get()->map(function ($highlight) {
                    $highlight->sort_date = $highlight->publish_start_date;
                    return $highlight;
                });

            $experiences = Experience::published()
                ->notUnlisted()
                ->byCategories(request('category'))
                ->whereNotIn('id', $featuredItems->pluck('id'))
                ->orderBy('created_at', 'desc')
                ->get()->map(function ($experience) {
                    $experience->sort_date = $experience->created_at;
                    return $experience;
                });
            
            $videos = Video::published()
                ->byCategories(request('category'))
                ->whereNotIn('id', $featuredItems->pluck('id'))
                ->orderBy('date', 'desc')
                ->get()->map(function ($video) {
                    $video->sort_date = $video->date;
                    return $video;
                });

            $combined = $articles->concat($highlights)->concat($experiences)->concat($videos)->sortByDesc('sort_date');

            $perPage = self::ARTICLES_PER_PAGE;
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentItems = $combined->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $paginator = new LengthAwarePaginator($currentItems, count($combined), $perPage, $currentPage, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

            $articles = $paginator;
        } else {
            // Retrieve experiences entires
            $articles = Experience::webPublished()->articlePublished()->paginate(self::ARTICLES_PER_PAGE);
        }

        // Featured articles are the selected ones if no filters are applied
        // otherwise those are just the first two from the collection
        if (empty(request()->get('category', null))) {
            $featuredArticles = $featuredItems->slice(1, 2) ?? null;
        } else {
            $featuredArticles = $articles->getCollection()->slice(0, 2);
            $newCollection = $articles->slice(2);

            // Replace pagination collection with
            $articles->setCollection($newCollection);
        }

        // These should be moved away from the controller.
        $categories = [
            [
                'label' => 'All',
                'href' => route('articles'),
                'active' => empty(request()->all()),
                'ajaxScrollTarget' => 'listing',
            ]
        ];

        foreach ($page->articlesCategories as $category) {
            array_push(
                $categories,
                [
                    'label' => $category->name,
                    'href' => route('articles', ['category' => $category->id]),
                    'active' => request()->get('category') == $category->id,
                    'ajaxScrollTarget' => 'listing',
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
            'heroArticle' => $heroArticle,
            'articles' => $articles,
            'categories' => $categories,
            'featuredArticles' => $featuredArticles
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
