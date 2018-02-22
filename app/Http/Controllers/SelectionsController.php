<?php

namespace App\Http\Controllers;

use App\Repositories\SelectionRepository;
use A17\CmsToolkit\Http\Controllers\Front\Controller;
use App\Models\Selection;

use App\Presenters\StaticObjectPresenter;

class SelectionsController extends Controller
{
    protected $repository;

    public function __construct(SelectionRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function index()
    {
    }

    public function show($slug)
    {
        $item = $this->repository->forSlug($slug);
        if (empty($item)) {
            $item = $this->repository->getById($slug);
        }

        // dd($item->image('hero'));

        // dd($item->articles);
        // $item->featuredRelated = array(
        //   'type' => 'article',
        //   'items' => $item->articles
        // );

        // $item->featuredRelated = array(
        //   'type' => 'article',
        //   'items' => array(
        //     new StaticObjectPresenter([
        //           "id" => 'abc',
        //           "slug" => "/statics/article",
        //           "title" => 'related',
        //           "author" => array(
        //             'img' => ['src' => "//placeimg.com/320/320/nature", 'srcset' => "//placeimg.com/320/320/nature", 'width' => 320, 'height' => 320],
        //             'name' => 'ABC DEF',
        //             'link' => '#',
        //           ),
        //           "intro" => 'Intro',
        //           "date" => \Carbon\Carbon::now(),
        //           "image" => ['src' => "//placeimg.com/320/320/nature", 'srcset' => "//placeimg.com/320/320/nature", 'width' => 320, 'height' => 320],
        //           "type" => 'article',
        //           "subtype" => "SUB",
        //         ])
        // ));

        return view('site.articleDetail', [
            'item' => $item
        ]);
    }

}
