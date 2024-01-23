<?php

namespace App\Http\Controllers;

use App\Repositories\HighlightRepository;
use App\Libraries\ExploreFurther\HighlightService as ExploreFurther;

class HighlightsController extends FrontController
{
    public const HIGHLIGHTS_PER_PAGE = 12;
    protected $repository;

    public function __construct(HighlightRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function index()
    {
        $this->seo->setTitle('Highlights');

        $items = $this->repository
            ->published()
            ->notUnlisted()
            ->orderBy('publish_start_date', 'desc')
            ->paginate(self::HIGHLIGHTS_PER_PAGE);


        return view('site.articles', [
            'articles' => $items,
            'exploreTitle' => 'Highlights',
        ]);
    }

    public function show($id, $slug = null)
    {
        $item = $this->repository->published()->find((int) $id);

        if (!$item) {
            abort(404);
        }

        $canonicalPath = route('highlights.show', ['id' => $item->id, 'slug' => $item->getSlug()]);

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->short_copy);
        $this->seo->setImage($item->imageFront('hero'));

        if ($item->is_unlisted) {
            $this->seo->nofollow = true;
            $this->seo->noindex = true;
        }

        $featuredRelated = collect($item->getFeaturedRelated())->pluck('item');

        $featuredRelatedIds = $featuredRelated->pluck('id');

        // Get auto related items & evaluate if they are featured

        $autoRelated = collect($item->related($item->id))->unique('id')->filter();

        // Remove featured related items from auto related items
        if ($featuredRelatedIds->isNotEmpty()) {
            $autoRelated = $autoRelated->reject(function ($relatedItem) use ($featuredRelatedIds) {
                return ($relatedItem !== null && ($featuredRelatedIds->contains($relatedItem->id) || $featuredRelatedIds->contains($relatedItem->datahub_id)));
            });
        }

        $artworks = $item->artworks(0);
        $exploreFurther = new ExploreFurther($item, $artworks->getMetadata('aggregations'));

        return view('site.highlightDetail', [
            'autoRelated' => $this->getAutoRelated($item),
            'featuredRelated' => $this->getFeatureRelated($item),
            'item' => $item,
            'contrastHeader' => $item->present()->contrastHeader,
            'exploreFurtherTags' => $exploreFurther->tags(),
            'exploreFurther' => $exploreFurther->collection(request()->all()),
            'exploreFurtherAllTags' => $exploreFurther->allTags(request()->all()),
            'exploreFurtherCollectionUrl' => $exploreFurther->collectionUrl(request()->all()),
            'furtherReadingTitle' => $this->repository->getFurtherReadingTitle($item) ?? null,
            'furtherReadingItems' => $this->repository->getFurtherReadingItems($item) ?? null,
            'canonicalUrl' => $canonicalPath,
        ]);
    }
}
