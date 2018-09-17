<?php

namespace App\Http\Controllers;

use App\Repositories\Api\GalleryRepository;
use App\Libraries\ExploreFurther\BaseService as ExploreGalleries;

class GalleryController extends FrontController
{
    const ARTWORKS_PER_PAGE = 50;

    protected $repository;

    public function __construct(GalleryRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function show($id, $slug = null)
    {
        $item = $this->repository->getById((Integer) $id);

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: 'Gallery');
        $this->seo->setImage($item->imageFront('hero'));

        $artworks = $item->artworks(self::ARTWORKS_PER_PAGE);
        // $exploreFurther = new ExploreGalleries($item, $artworks->getMetadata('aggregations'));

        return view('site.tagDetail', [
            'item'     => $item,
            'artworks' => $artworks,
            // 'exploreFurtherTags'    => $exploreFurther->tags(),
            // 'exploreFurther'        => $exploreFurther->collection(request()->all()),
            // 'exploreFurtherCollectionUrl' => $exploreFurther->collectionUrl(request()->all()),
        ]);
    }

}
