<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\DigitalPublicationRepository;
use App\Models\DigitalPublication;

class DigitalPublicationsController extends BaseScopedController
{

    protected $repository;

    public function __construct(DigitalPublicationRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function index(Request $request)
    {
        $items = DigitalPublication::published()->ordered()->paginate();

        $title = 'Digital Publications';

        $this->seo->setTitle($title);

        $navElements = get_nav_for_publications($title);

        $view_data = [
            'wideBody' => true,
            'filters' => null,
            'listingCountText' => 'Showing '.$items->total().' digital publications',
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
        $this->seo->setDescription($page->meta_description ?? $page->short_description ?? $page->listing_description);
        $this->seo->setImage($page->imageFront('listing'));

        $crumbs = [
            ['label' => 'The Collection', 'href' => route('collection')],
            ['label' => 'Digital Publications', 'href' => route('collection.publications.digital-publications')],
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
