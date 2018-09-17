<?php

namespace App\Http\Controllers;

use App\Repositories\SelectionRepository;
use App\Models\Selection;
use App\Libraries\ExploreFurther\SelectionService as ExploreFurther;

class SelectionsController extends FrontController
{
    protected $repository;

    public function __construct(SelectionRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function show($slug)
    {
        $item = $this->repository->forSlug($slug);
        if (empty($item)) {
            $item = $this->repository->getById((Integer) $slug);
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->short_copy);
        $this->seo->setImage($item->imageFront('hero'));

        $artworks = $item->artworks(0);
        $exploreFurther = new ExploreFurther($item, $artworks->getMetadata('aggregations'));

        return view('site.selectionDetail', [
            'contrastHeader' => $item->present()->contrastHeader,
            'item' => $item,
            'exploreFurtherTags'    => $exploreFurther->tags(),
            'exploreFurther'        => $exploreFurther->collection(request()->all()),
            'exploreFurtherAllTags' => $exploreFurther->allTags(request()->all()),
            'exploreFurtherCollectionUrl' => $exploreFurther->collectionUrl(request()->all()),
        ]);
    }

}
