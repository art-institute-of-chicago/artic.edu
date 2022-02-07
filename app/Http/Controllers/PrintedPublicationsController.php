<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\PrintedPublicationRepository;
use App\Models\CatalogCategory;
use App\Helpers\NavHelpers;

class PrintedPublicationsController extends BaseScopedController
{
    protected $repository;

    protected $entity = \App\Models\PrintedPublication::class;

    protected $scopes = [
        'category' => 'byCategory',
    ];

    public function __construct(PrintedPublicationRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    protected function beginOfAssociationChain()
    {
        // Apply default scopes to the beginning of the chain
        return parent::beginOfAssociationChain()
            ->published();
    }

    public function index(Request $request)
    {
        $items = $this->collection()->ordered()->paginate();

        $title = 'Print Publications';

        $this->seo->setTitle($title);

        $navElements = NavHelpers::get_nav_for_publications($title);

        $view_data = [
            'wideBody' => true,
            'filters' => $this->getFilters(),
            'listingCountText' => 'Showing ' . $items->total() . ' print publications',
            'listingItems' => $items,
        ] + $navElements;


        return view('site.genericPage.index', $view_data);
    }

    public function show($id)
    {
        $item = $this->repository->published()->find((int) $id);

        if (empty($item)) {
            $item = $this->repository->forSlug($id);
        }

        if (!$item) {
            abort(404);
        }

        $canonicalPath = $item->present()->getCanonicalUrl();

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?? $item->short_description ?? $item->listing_description);
        $this->seo->setImage($item->imageFront('listing'));

        $crumbs = [
            ['label' => 'The Collection', 'href' => route('collection')],
            ['label' => 'Print Publications', 'href' => route('collection.publications.printed-publications')],
            ['label' => $item->title, 'href' => '']
        ];

        return view('site.genericPage.show', [
            'canonicalUrl' => $canonicalPath,
            'borderlessHeader' => !(empty($item->imageFront('banner'))),
            'nav' => null,
            'intro' => $item->short_description,
            'headerImage' => $item->imageFront('banner'),
            'title' => $item->title,
            'breadcrumb' => $crumbs,
            'page' => $item,
        ]);
    }

    protected function getFilters()
    {
        $categoryLinks[] = [
            'label' => 'All',
            'href' => route('collection.publications.printed-publications'),
            'active' => empty(request('category', null))
        ];

        foreach (CatalogCategory::all() as $category) {
            $categoryLinks[] = [
                'href' => route('collection.publications.printed-publications', request()->except('category') + ['category' => $category->id]),
                'label' => $category->name,
                'active' => request('category') == $category->id
            ];
        }

        return [
            [
                'prompt' => 'Subject',
                'links' => collect($categoryLinks)
            ]
        ];
    }
}
