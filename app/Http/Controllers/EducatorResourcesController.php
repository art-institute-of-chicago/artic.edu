<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\EducatorResourceRepository;
use App\Models\EducatorResource;
use App\Models\ResourceCategory;

class EducatorResourcesController extends BaseScopedController
{

    protected $repository;

    protected $entity = \App\Models\EducatorResource::class;

    protected $scopes = [
        'category' => 'byCategory',
    ];

    public function __construct(EducatorResourceRepository $repository)
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

        $view_data = [
            'title' => $title,
            'subNav' => $subNav,
            'nav' => $nav,
            "breadcrumb" => $crumbs,
            'wideBody' => true,
            'filters' => $this->getFilters(),
            'listingCountText' => 'Showing '.$items->total().' educator resources',
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

        $this->seo->setTitle($page->meta_title ?: $page->title);
        $this->seo->setDescription($page->meta_description ?: $page->short_description);

        $crumbs = [
            ['label' => 'The Collection', 'href' => route('collection')],
            ['label' => 'Educator resources', 'href' => route('collection.resources.educator-resources')],
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
            'page' => $page,
        ]);

    }

    protected function getFilters()
    {

        $categoryLinks[] = [
            'label'  => 'All',
            'href'   => route('collection.resources.educator-resources'),
            'active' => empty(request('category', null))
        ];

        foreach (ResourceCategory::all() as $category) {
            $categoryLinks[] = [
                'href'   => route('collection.resources.educator-resources', request()->except('category') + ['category' => $category->id]),
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
