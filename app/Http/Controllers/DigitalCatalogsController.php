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
        $title = 'Digital catalogs';
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

        $filters = array(
            array(
                'prompt' => 'Type',
                'links' => array(
                    array('href' => '#', 'label' => 'All', 'active' => true),
                ),
            ),
        );

        $view_data = [
            'title' => $title,
            'subNav' => $subNav,
            'nav' => $nav,
            "breadcrumb" => $crumbs,
            'wideBody' => true,
            'filters' => $filters,
            'listingCountText' => 'Showing '.$items->total().' digital catalogs',
            'listingItems' => $items,
        ];


        return view('site.digitalcatalogs.index', $view_data);
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
            ['label' => 'Digital catalogs', 'href' => route('collection.publications.digital-catalogs')],
            ['label' => $page->title, 'href' => '']
        ];

        return view('site.digitalcatalogs.show', [
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
