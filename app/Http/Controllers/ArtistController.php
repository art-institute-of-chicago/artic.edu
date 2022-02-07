<?php

namespace App\Http\Controllers;

use App\Repositories\Api\ArtistRepository;
use App\Libraries\ExploreFurther\BaseService as ExploreArtists;

class ArtistController extends FrontController
{
    const ARTWORKS_PER_PAGE = 12;

    protected $repository;

    public function __construct(ArtistRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function show($id, $slug = null)
    {
        $item = $this->repository->getById((int) $id);

        $canonicalPath = route('artists.show', ['id' => $item->id, 'slug' => $item->titleSlug]);

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: 'Artist');

        $artworks = $item->artworks(self::ARTWORKS_PER_PAGE);
        $exploreFurther = new ExploreArtists($item, $artworks->getMetadata('aggregations'));
        $this->seo->setImage($item->imageFront('hero') ?? ($artworks && $artworks->isNotEmpty() ? $artworks->first()->imageFront('hero') : null));

        $relatedItems = $this->repository->getRelatedItems($item);

        return view('site.tagDetail', [
            'item' => $item,
            'artworks' => $artworks,
            'exploreFurtherTags' => $exploreFurther->tags(),
            'exploreFurther' => $exploreFurther->collection(request()->all()),
            'exploreFurtherCollectionUrl' => $exploreFurther->collectionUrl(request()->all()),
            'relatedItems' => $relatedItems->count() > 0 ? $relatedItems : null,
            'canonicalUrl' => $canonicalPath,
        ]);
    }
}
