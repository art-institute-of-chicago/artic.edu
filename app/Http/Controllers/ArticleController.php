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

    public function show($id)
    {
        $item = $this->repository->getById($id);

        return view('site.articleDetail', [
            'item' => $item
        ]);
    }

}
