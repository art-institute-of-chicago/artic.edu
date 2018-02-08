<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use A17\CmsToolkit\Http\Controllers\Front\Controller;

class ArticleController extends Controller
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

        return view('site.articles', [
            'page' => $page
        ]);
    }

    public function show($slug)
    {
        $item = $this->repository->forSlug($slug);
        if (empty($item)) {
            $item = $this->repository->getById($slug);
        }

        return view('site.articleDetail', [
            'item' => $item
        ]);
    }

}
