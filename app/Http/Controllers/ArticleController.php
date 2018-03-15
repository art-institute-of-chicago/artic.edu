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

        $heroArticle = Article::first();

        $articles = Article::all();

        return view('site.articles', [
            'page' => $page,
            'heroArticle' => $heroArticle,
            'articles' => $articles
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
