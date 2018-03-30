<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\EducatorResourceRepository;
use App\Models\EducatorResource;

class EducatorResourcesController extends FrontController
{

    protected $repository;

    public function __construct(EducatorResourceRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function index(Request $request)
    {
        $items = EducatorResource::published()->paginate();
        $title = 'Educator resources';
        $subNav = [
            ['label' => $title, 'href' => route('collection.resources.educator-resources'), 'active' => true]
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
            'listingCountText' => 'Showing '.$items->total().' educator resources',
            'listingItems' => $items,
        ];


        return view('site.educatorresources.index', $view_data);
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
            ['label' => 'Educator resources', 'href' => route('collection.resources.educator-resources')],
            ['label' => $page->title, 'href' => '']
        ];

        return view('site.educatorresources.show', [
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
