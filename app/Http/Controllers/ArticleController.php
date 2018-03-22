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

        $featuredArticles = $page->articlesArticles;
        $heroArticle = $featuredArticles->first();

        $articles = Article::published()->whereNotIn('id', $featuredArticles->pluck('id'));
        if (request('category')) {
            $articles = $articles->whereHas('categories', function ($query) use ($page){
                $query->where('category_id', request('category'));
            });
        }
        $baseurl = route('articles');
        $categories = array(array('label' => 'All', 'href' => $baseurl, 'active' => true));

        foreach ($page->articlesCategories as $category) {
            array_push($categories,
                array('label' => $category->name, 'href' => $baseurl.'?category='.$category->id)
            );
        }

        return view('site.articles', [
            'page' => $page,
            'heroArticle' => $heroArticle,
            'articles' => $articles->get(),
            'categories' => $categories,
            'featuredArticles' => $featuredArticles->forget(0)
        ]);
    }

    public function show($id)
    {
        $item = $this->repository->find($id);

        if ($item->categories->first()) {
            $item->topics = $item->categories;
        }

        return view('site.articleDetail', [
            'contrastHeader' => $item->present()->contrastHeader,
            'item' => $item
        ]);
    }

}
