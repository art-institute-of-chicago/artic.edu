<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ResearchGuideRepository;
use App\Models\ResearchGuide;

class ResearchGuidesController extends FrontController
{
    protected $repository;

    public function __construct(ResearchGuideRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function index(Request $request)
    {
        $items = ResearchGuide::published()->paginate();
        $title = 'Research guides';
        $subNav = [
            ['label' => $title, 'href' => route('collection.resources.research-guides'), 'active' => true]
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
            'breadcrumb' => $crumbs,
            'wideBody' => true,
            'filters' => null,
            'listingCountText' => 'Showing ' . $items->total() . ' research guides',
            'listingItems' => $items,
        ];

        return view('site.genericPage.index', $view_data);
    }

    public function show($id)
    {
        $page = $this->repository->find((int) $id);

        if (!$page) {
            $page = $this->repository->forSlug($id);

            if (!$page) {
                abort(404);
            }
        }

        $this->seo->setTitle($page->meta_title ?? $page->title);
        $this->seo->setDescription($page->meta_description ?? $page->short_description ?? $page->listing_description);
        $this->seo->setImage($page->imageFront('listing'));

        $crumbs = [
            ['label' => 'The Collection', 'href' => route('collection')],
            ['label' => 'Research guides', 'href' => route('collection.resources.research-guides')],
            ['label' => $page->title, 'href' => '']
        ];

        return view('site.genericPage.show', [
            'borderlessHeader' => !(empty($page->imageFront('banner'))),
            'subNav' => null,
            'intro' => $page->short_description,
            'headerImage' => $page->imageFront('banner'),
            'title' => $page->title,
            'breadcrumb' => $crumbs,
            'blocks' => null,
            'nav' => [],
            'page' => $page,
        ]);
    }
}
