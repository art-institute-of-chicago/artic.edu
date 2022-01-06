<?php

namespace App\Http\Controllers;

use App\Repositories\Api\GalleryRepository;

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
        $item = $this->repository->getById((int) $id);

        $canonicalPath = route('galleries.show', ['id' => $item->id, 'slug' => $item->titleSlug]);

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: 'Gallery');
        $this->seo->setImage($item->imageFront('hero'));

        $artworks = $item->artworks(self::ARTWORKS_PER_PAGE);

        return view('site.tagDetail', [
            'item' => $item,
            'artworks' => $artworks,
            'canonicalUrl' => $canonicalPath,
        ]);
    }
}
