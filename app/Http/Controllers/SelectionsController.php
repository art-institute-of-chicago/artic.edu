<?php

namespace App\Http\Controllers;

use App\Repositories\SelectionRepository;
use App\Models\Selection;

use App\Presenters\StaticObjectPresenter;

class SelectionsController extends FrontController
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
            $item = $this->repository->getById((Integer) $slug);
        }

        if ($item->imageFront('hero')) {
            $item->headerImage = $item->imageFront('hero');
        }

        if ($item->siteTags->first()) {
            $item->type = $item->siteTags->first()->name;
        }

        $exploreFurtherTags = $this->repository->exploreFurtherTags($item);
        if (request()->has('exFurther-all')) {
            $exploreFurtherAllTags = $this->repository->exploreFurtherAllTags($item);
        } else {
            $exploreFurtherCollection = $this->repository->exploreFurtherCollection($item, request()->only('exFurther-classification'));
        }

        return view('site.selectionDetail', [
            'contrastHeader' => $item->present()->contrastHeader,
            'item' => $item,
            'exploreFurtherTags' => $exploreFurtherTags ,
            'exploreFurther'     => $exploreFurtherCollection ?? null,
            'exploreFurtherAllTags' => $exploreFurtherAllTags ?? null,
        ]);
    }

}
