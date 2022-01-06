<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\HighlightRepository;
use App\Libraries\ExploreFurther\HighlightService as ExploreFurther;

class HighlightsController extends FrontController
{
    protected $repository;

    public function __construct(HighlightRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function index(Request $request)
    {
        $items = $this->repository->published()->notUnlisted()->ordered()->paginate();
        $title = 'Highlights';

        $subNav = [
            ['label' => $title, 'href' => route('highlights.index'), 'active' => true]
        ];

        $nav = [
            ['label' => 'The Collection', 'href' => route('collection'), 'links' => $subNav]
        ];

        $this->seo->setTitle($title);

        $view_data = [
            'title' => $title,
            'subNav' => $subNav,
            'nav' => $nav,
            'wideBody' => true,
            'filters' => null,
            'listingCountText' => 'Showing ' . $items->total() . ' highlights',
            'listingItems' => $items,
        ];


        return view('site.genericPage.index', $view_data);
    }

    public function show($id, $slug = null)
    {
        $item = $this->repository->getById((int) $id);

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

        $artworks = $item->artworks(0);
        $exploreFurther = new ExploreFurther($item, $artworks->getMetadata('aggregations'));

        return view('site.highlightDetail', [
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
