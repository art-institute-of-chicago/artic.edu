<?php

namespace App\Http\Controllers;

use App\Repositories\Api\DepartmentRepository;

class DepartmentController extends FrontController
{
    const ARTWORKS_PER_PAGE = 24;

    protected $repository;

    public function __construct(DepartmentRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function show($id, $slug = null)
    {
        $item = $this->repository->getById($id);

        $canonicalPath = route('departments.show', ['id' => $item->id, 'slug' => $item->titleSlug]);

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: 'Department');
        $this->seo->setImage($item->imageFront('hero'));

        $artworks = $this->repository->getRelatedArtworks($item);
        $relatedItems = $this->repository->getRelatedItems($item);

        return view('site.tagDetail', [
            'item' => $item,
            'artworks' => $artworks,
            'relatedItems' => $relatedItems->count() > 0 ? $relatedItems : null,
            'canonicalUrl' => $canonicalPath,
        ]);
    }
}
