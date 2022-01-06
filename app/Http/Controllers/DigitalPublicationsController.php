<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DigitalPublication;
use App\Repositories\DigitalPublicationRepository;
use App\Helpers\NavHelpers;

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

        $navElements = NavHelpers::get_nav_for_publications($title);

        $view_data = [
            'wideBody' => true,
            'filters' => null,
            'listingCountText' => 'Showing ' . $items->total() . ' digital publications',
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
        $this->seo->setDescription($item->meta_description ?? $item->listing_description);
        $this->seo->setImage($item->imageFront('listing'));

        if ($item->is_dsc_stub) {
            return $this->showDscStub($item);
        }

        return view('site.digitalPublicationDetail', [
            'item' => $item,
            'contrastHeader' => false,
            'borderlessHeader' => false,
            'unstickyHeader' => true,
            'canonicalUrl' => $canonicalPath,
            'welcomeNote' => $this->repository->getWelcomeNote($item),
        ]);
    }

    private function showDscStub($item)
    {
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
