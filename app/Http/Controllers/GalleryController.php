<?php

namespace App\Http\Controllers;

use App\Repositories\Api\GalleryRepository;
use App\Models\Api\Gallery;
use App\Models\Api\Search;
use Carbon\Carbon;

class GalleryController extends FrontController
{
    protected $repository;

    const ARTWORKS_PER_PAGE = 8;

    public function __construct(GalleryRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function show($idSlug)
    {
        // The ID is a datahub_id not a local ID
        $item = $this->repository->getById((Integer) $idSlug);
        $artworks = Search::query()->resources(['artworks'])->byGallery($item->id)->getSearch(self::ARTWORKS_PER_PAGE);

        return view('site.tagDetail', [
            'item' => $item,
            'artworks' => $artworks,
        ]);
    }

}
