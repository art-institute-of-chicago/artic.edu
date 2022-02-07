<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use App\Models\Page;
use App\Models\Article;
use App\Models\Experience;
use App\Helpers\StringHelpers;

class ArticleController extends FrontController
{
    const ARTICLES_PER_PAGE = 12;
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
                ->paginate(self::ARTICLES_PER_PAGE);
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
            'contrastHeader' => $item->present()->contrastHeader,
            'furtherReadingTitle' => $this->repository->getFurtherReadingTitle($item) ?? null,
            'furtherReadingItems' => $this->repository->getFurtherReadingItems($item) ?? null,
            'canonicalUrl' => $canonicalPath,
        ]);
    }
}
