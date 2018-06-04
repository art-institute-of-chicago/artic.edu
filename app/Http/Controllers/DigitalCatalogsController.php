<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\DigitalCatalogRepository;
use App\Models\DigitalCatalog;

class DigitalCatalogsController extends FrontController
{

    protected $repository;

    public function __construct(DigitalCatalogRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function index(Request $request)
    {
        $items = DigitalCatalog::published()->paginate();
        $title = 'Digital catalogues';
        $subNav = [
            ['label' => $title, 'href' => route('collection.publications.digital-catalogs'), 'active' => true]
        ];

        $nav = [
            ['label' => 'Collection', 'href' => route('collection'), 'links' => $subNav]
        ];

        $crumbs = [
            ['label' => 'The Collection', 'href' => route('collection')],
            ['label' => $title, 'href' => '']
        ];

        $view_data = [
            'title' => $title,
            'subNav' => $subNav,
            'nav' => $nav,
            "breadcrumb" => $crumbs,
            'wideBody' => true,
            'filters' => null,
            'listingCountText' => 'Showing '.$items->total().' digital catalogues',
            'listingItems' => $items,
        ];


        return view('site.genericPage.index', $view_data);
    }

    public function show($id)
    {
        $page = $this->repository->find((Integer) $id);
        if (!$page) {
            $page = $this->repository->forSlug($id);

            if (!$page) {
                abort(404);
            }
        }

        $navs = [
            'nav' => [],
            'subNav' => []
        ];
        $crumbs = [
            ['label' => 'The Collection', 'href' => route('collection')],
            ['label' => 'Digital catalogues', 'href' => route('collection.publications.digital-catalogs')],
            ['label' => $page->title, 'href' => '']
        ];

        return view('site.genericPage.show', [
            'borderlessHeader' => !(empty($page->imageFront('banner'))),
            'subNav' => null,
            'nav' => null,
            'intro' => $page->short_description,
            'headerImage' => $page->imageFront('banner'),
            "title" => $page->title,
            "breadcrumb" => $crumbs,
            "blocks" => null,
            'featuredRelated' => [],
            'nav' => $navs['nav'],
            'page' => $page,
        ]);

    }

}
