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
        $item = $this->repository->safeForSlug($id);

        if (!$item) {
            $item = $this->repository->find((Integer) $id) ?? abort(404);
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?? $item->listing_description);
        $this->seo->setImage($item->imageFront('listing'));

        $crumbs = [
            ['label' => 'The Collection', 'href' => route('collection')],
            ['label' => 'Digital Publications', 'href' => route('collection.publications.digital-publications')],
            ['label' => $item->title, 'href' => '']
        ];

        return view('site.genericPage.show', [
            'borderlessHeader' => !(empty($item->imageFront('banner'))),
            'headerImage' => $item->imageFront('banner'),
            'title' => $item->title,
            'breadcrumb' => $crumbs,
            'page' => $item,
        ]);
    }

}
