<?php

namespace App\Http\Controllers;

use App\Repositories\Api\DepartmentRepository;

class DepartmentController extends FrontController
{
    protected $repository;

    public function __construct(DepartmentRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function show($idSlug)
    {
        $item     = $this->repository->getById($idSlug);
        $artworks = $this->repository->getArtworks($item);

        $exploreFurtherCollection = $this->repository->exploreFurtherCollection($item, request()->only('exFurther-classification'));
        $exploreFurtherTags       = $this->repository->exploreFurtherTags($item);

        return view('site.tagDetail', [
            'item'     => $item,
            'artworks' => $artworks,
            'exploreFurther'     => $exploreFurtherCollection,
            'exploreFurtherTags' => $exploreFurtherTags,
        ]);
    }

}
