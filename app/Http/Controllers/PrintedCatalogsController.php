<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\PrintedCatalogRepository;
use App\Models\PrintedCatalog;
use App\Models\CatalogCategory;

class PrintedCatalogsController extends CatalogsController
{

    protected $repository;

    protected $entity = \App\Models\PrintedCatalog::class;

    protected $scopes = [
        'category' => 'byCategory',
    ];

    public function __construct(PrintedCatalogRepository $repository)
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
        $items = $this->collection()->paginate();

        $navElements = $this->getNavElements('Printed Catalogues');

        $view_data = [
            'wideBody' => true,
            'filters' => $this->getFilters(),
            'listingCountText' => 'Showing '.$items->total().' printed catalogues',
            'listingItems' => $items,
        ] + $navElements;


        return view('site.genericPage.index', $view_data);
    }

    public function show($id)
    {
        $page = $this->repository->forSlug($id);
        if (!$page) {
            $page = $this->repository->find((Integer) $id) ?? abort(404);
        }

        $this->seo->setTitle($page->meta_title ?: $page->title);
        $this->seo->setDescription($page->meta_description ?: $page->short_description);

        $crumbs = [
            ['label' => 'The Collection', 'href' => route('collection')],
            ['label' => 'Printed catalogues', 'href' => route('collection.publications.printed-catalogs')],
            ['label' => $page->title, 'href' => '']
        ];

        return view('site.genericPage.show', [
            'borderlessHeader' => !(empty($page->imageFront('banner'))),
            'nav'    => null,
            'intro'  => $page->short_description,
            'headerImage' => $page->imageFront('banner'),
            "title" => $page->title,
            "breadcrumb" => $crumbs,
            'page' => $page,
        ]);

    }

    protected function getFilters()
    {

        $categoryLinks[] = [
            'label'  => 'All',
            'href'   => route('collection.publications.printed-catalogs'),
            'active' => empty(request('category', null))
        ];

        foreach (CatalogCategory::all() as $category) {
            $categoryLinks[] = [
                'href'   => route('collection.publications.printed-catalogs', request()->except('category') + ['category' => $category->id]),
                'label'  => $category->name,
                'active' => request('category') == $category->id
            ];
        }

        return [
            [
                'prompt' => 'Type',
                'links'  => collect($categoryLinks)
            ]
        ];

    }

}
