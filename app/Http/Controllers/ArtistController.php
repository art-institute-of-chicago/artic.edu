<?php

namespace App\Http\Controllers;

use App\Repositories\Api\ArtistRepository;

class ArtistController extends FrontController
{
    protected $repository;

    public function __construct(ArtistRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function show($idSlug)
    {
        $item     = $this->repository->getById((Integer) $idSlug);
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
