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

        $relatedItems = $this->getRelatedItems($item);

        return view('site.tagDetail', [
            'item'     => $item,
            'artworks' => $artworks,
            'exploreFurtherTags'    => $exploreFurther->tags(),
            'exploreFurther'        => $exploreFurther->collection(request()->all()),
            'exploreFurtherCollectionUrl' => $exploreFurther->collectionUrl(request()->all()),
            'canonicalUrl' => route('artists.show', ['id' => $item->id, 'slug' => $item->titleSlug]),
            'relatedItems' => $relatedItems,
        ]);
    }

    private function getRelatedItems($item)
    {
        $relatedItems = $item->getRelatedWithApiModels("related_items", [
            'exhibitions' => [
                'apiModel' => 'App\Models\Api\Exhibition',
                'routePrefix' => 'exhibitions_events',
                'moduleName' => 'exhibitions',
            ],
        ], [
            // See $typeUsesApi in HasApiRelations class
            'exhibitions' => true,
            'articles' => false,
            'digitalLabels' => false,
            'digitalPublications' => false,
            'printedPublications' => false,
            'educatorResources' => false,
        ]) ?? null;

        foreach ($relatedItems as $relatedItem) {
            switch (get_class($relatedItem)) {
                case \App\Models\DigitalPublication::class:
                    $relatedItem->subtype = 'Digital Publication';
                    break;
                case \App\Models\PrintedPublication::class:
                    $relatedItem->subtype = 'Print Publication';
                    break;
                case \App\Models\EducatorResource::class:
                    $relatedItem->subtype = 'Educator Resource';
                    break;
                case \App\Models\DigitalLabel::class:
                    $relatedItem->subtype = 'Interactive Feature';
                    break;
            }

            // Default to 'article' i/o 'generic' for default image
            $relatedItem->type = $relatedItem->type ?? 'article';
        }

        return $relatedItems;
    }

}
