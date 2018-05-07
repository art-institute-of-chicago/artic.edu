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

        $exploreFurtherTags = $this->repository->exploreFurtherTags($item);
        if (request()->has('exFurther-all')) {
            $exploreFurtherAllTags = $this->repository->exploreFurtherAllTags();
        } else {
            $exploreFurtherCollection = $this->repository->exploreFurtherCollection($item, request()->only('exFurther-classification'));
        }

        return view('site.tagDetail', [
            'item'     => $item,
            'artworks' => $artworks,
            'exploreFurtherTags' => $exploreFurtherTags ,
            'exploreFurther'     => $exploreFurtherCollection ?? null,
            'exploreFurtherAllTags' => $exploreFurtherAllTags ?? null,
        ]);
    }

}
