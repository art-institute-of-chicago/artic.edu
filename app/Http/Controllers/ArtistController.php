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
        $item = $this->repository->getById((Integer) $id);

        // Redirect to the canonical page if it wasn't requested
        $canonicalPath = route('artists.show', ['id' => $item->id, 'slug' => $item->titleSlug ], false);
        if ('/' .request()->path() != $canonicalPath) {
            return redirect($canonicalPath, 301);
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: 'Artist');

        $artworks = $item->artworks(self::ARTWORKS_PER_PAGE);
        $exploreFurther = new ExploreArtists($item, $artworks->getMetadata('aggregations'));

        $this->seo->setImage($item->imageFront('hero') ?? $artworks->first()->imageFront('hero') ?? null);

        // TODO: Do these methods belong in the API ArtistRepository, or in the CMS one?
        $relatedItems = $this->repository->getRelatedItems($item);

        return view('site.tagDetail', [
            'item'     => $item,
            'artworks' => $artworks,
            'exploreFurtherTags'    => $exploreFurther->tags(),
            'exploreFurther'        => $exploreFurther->collection(request()->all()),
            'exploreFurtherCollectionUrl' => $exploreFurther->collectionUrl(request()->all()),
            'canonicalUrl' => route('artists.show', ['id' => $item->id, 'slug' => $item->titleSlug]),
            'relatedItems' => $relatedItems->count() > 0 ? $relatedItems : null,
        ]);
    }

}
