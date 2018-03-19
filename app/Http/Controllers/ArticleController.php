<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use App\Models\Page;
use App\Models\Article;

class ArticleController extends FrontController
{
    protected $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function index()
    {
        $page = Page::forType('Articles')->first();

        $heroArticle = $page->articlesArticles->first();

        $articles = Article::all();
        $featuredArticles = $page->articlesArticles->forget(0);

        $categories = array(array('label' => 'All', 'href' => '#', 'active' => true));
        foreach ($page->articlesCategories as $category) {
            array_push($categories,
                array('label' => $category->name, 'href' => '#')
            );
        }

        return view('site.articles', [
            'page' => $page,
            'heroArticle' => $heroArticle,
            'articles' => $articles,
            'categories' => $categories,
            'featuredArticles' => $featuredArticles
        ]);
    }

    public function show($slug)
    {
        $item = $this->repository->forSlug($slug);
        if (empty($item)) {
            $item = $this->repository->getById($slug);
        }

        if ($item->categories->first()) {
            $item->topics = $item->categories;
        }

        return view('site.articleDetail', [
            'item' => $item
        ]);
    }

}
