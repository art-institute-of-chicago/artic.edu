<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\DigitalCatalogRepository;
use App\Models\DigitalCatalog;

class DigitalCatalogsController extends CatalogsController
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

        $navElements = $this->getNavElements('Digital Catalogues');

        $view_data = [
            'wideBody' => true,
            'filters' => null,
            'listingCountText' => 'Showing '.$items->total().' digital catalogues',
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
        $this->seo->setImage($page->imageFront('listing'));

        $crumbs = [
            ['label' => 'The Collection', 'href' => route('collection')],
            ['label' => 'Digital catalogues', 'href' => route('collection.publications.digital-catalogs')],
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

}
