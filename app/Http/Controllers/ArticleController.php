<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use App\Models\Page;
use App\Models\Article;
use App\Models\Experience;

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

        $featuredItems = $page->getRelatedWithApiModels("featured_items", [], [
            'articles' => false,
            'interactiveFeatures.experiences' => false
        ]);

        $heroArticle = $featuredItems->first();

        // $articles = new \Illuminate\Pagination\LengthAwarePaginator(collect(), 0, self::ARTICLES_PER_PAGE);

        if (request('category') !== 'interactive-features') {
            $articles = Article::published()
                ->byCategory(request('category'))
                ->whereNotIn('id', $featuredItems->pluck('id'))
                ->orderBy('date', 'desc')
                ->paginate(self::ARTICLES_PER_PAGE);
        } else {
            // Retrieve experiences entires
            $experiencesCount = Experience::query('published', true)->paginate()->count();
            $articles = Experience::query('published', true)->paginate(self::ARTICLES_PER_PAGE);
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
            array_push($categories,
                [
                    'label'  => $category->name,
                    'href'   => route('articles', ['category' => $category->id]),
                    'active' => request()->get('category') == $category->id,
                    'ajaxScrollTarget' => 'listing',
                ]
            );
        }

        array_push($categories,
            [
                'label' => 'Interactive Features',
                'href' => route('articles', ['category' => 'interactive-features']),
                'active' => request()->get('category') == 'interactive-features',
                'ajaxScrollTarget' => 'listing',
            ]
        );


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
        $item = $this->repository->published()->find((Integer) $id);

        if (!$item) {
            abort(404);
        }

        // Redirect to the canonical page if it wasn't requested
        $canonicalPath = route('articles.show', ['id' => $item->id, 'slug' => $item->getSlug()], false);
        if ('/' .request()->path() != $canonicalPath) {
            return redirect($canonicalPath, 301);
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->heading ?: truncateStr(strip_tags($item->present()->copy()), 297));
        $this->seo->setImage($item->imageFront('hero'));

        if ($item->categories->first()) {
            $item->topics = $item->categories;
        }

        $featuredArticles = $item->getRelatedWithApiModels("further_reading_items", [], [
            'articles' => false,
            'interactiveFeatures.experiences' => false
        ]) ?? null;

        return view('site.articleDetail', [
            'contrastHeader' => $item->present()->contrastHeader,
            'item' => $item,
            'featuredArticles'     => $featuredArticles ?? null,
            'canonicalUrl' => route('articles.show', ['id' => $item->id, 'slug' => $item->getSlug()]),
        ]);
    }
}
