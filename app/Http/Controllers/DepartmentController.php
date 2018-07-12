<?php

namespace App\Http\Controllers;

use App\Repositories\Api\DepartmentRepository;
use App\Libraries\ExploreFurther\BaseService as ExploreDepartments;

class DepartmentController extends FrontController
{
    const ARTWORKS_PER_PAGE = 8;

    protected $repository;

    public function __construct(DepartmentRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function show($idSlug)
    {
        $item = $this->repository->getById($idSlug);

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: 'Department');

        $artworks = $item->artworks(self::ARTWORKS_PER_PAGE);
        $exploreFurther = new ExploreDepartments($item, $artworks->getMetadata('aggregations'));

        return view('site.tagDetail', [
            'item'     => $item,
            'artworks' => $artworks,
            'exploreFurtherTags'    => $exploreFurther->tags(),
            'exploreFurther'        => $exploreFurther->collection(request()->all()),
            'exploreFurtherCollectionUrl' => $exploreFurther->collectionUrl(request()->all()),
        ]);
    }

}
