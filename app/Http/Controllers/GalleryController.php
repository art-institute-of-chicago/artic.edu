<?php

namespace App\Http\Controllers;

use App\Repositories\Api\GalleryRepository;
use App\Models\Api\Gallery;
use App\Models\Api\Search;
use Carbon\Carbon;

class GalleryController extends FrontController
{
    protected $repository;

    public function __construct(GalleryRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function show($idSlug)
    {
        $item     = $this->repository->getById((Integer) $idSlug);
        $artworks = $this->repository->getArtworks($item->id);

        $exploreFurtherCollection = $this->repository->exploreFurtherCollection($item->id, request()->only('exFurther-classification'));
        $exploreFurtherTags       = $this->repository->exploreFurtherTags($item->id);

        return view('site.tagDetail', [
            'item'     => $item,
            'artworks' => $artworks,
            'exploreFurther'     => $exploreFurtherCollection,
            'exploreFurtherTags' => $exploreFurtherTags,
        ]);
    }

}
