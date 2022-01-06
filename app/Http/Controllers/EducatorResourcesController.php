<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\EducatorResourceRepository;
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

        $title = 'Educator Resources';

        $this->seo->setTitle($title);

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
            'breadcrumb' => $crumbs,
            'wideBody' => true,
            'filters' => $this->getFilters(),
            'listingCountText' => 'Showing ' . $items->total() . ' educator resources',
            'listingItems' => $items,
        ];


        return view('site.genericPage.index', $view_data);
    }

    public function show($id)
    {
        $item = $this->repository->find((int) $id);

        if (!$item) {
            $item = $this->repository->forSlug($id);

            if (!$item) {
                abort(404);
            }
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?? $item->short_description ?? $item->listing_description);
        $this->seo->setImage($item->imageFront('listing'));

        $crumbs = [
            ['label' => 'The Collection', 'href' => route('collection')],
            ['label' => 'Educator Resources', 'href' => route('collection.resources.educator-resources')],
            ['label' => $item->title, 'href' => '']
        ];

        return view('site.genericPage.show', [
            'borderlessHeader' => !(empty($item->imageFront('banner'))),
            'subNav' => null,
            'nav' => null,
            'intro' => $item->short_description,
            'headerImage' => $item->imageFront('banner'),
            'title' => $item->title,
            'title_display' => $item->title_display,
            'breadcrumb' => $crumbs,
            'blocks' => null,
            'page' => $item,
        ]);
    }

    protected function getFilters()
    {
        $categoryLinks[] = [
            'label' => 'All',
            'href' => route('collection.resources.educator-resources'),
            'active' => empty(request('category', null))
        ];

        foreach (ResourceCategory::all() as $category) {
            $categoryLinks[] = [
                'href' => route('collection.resources.educator-resources', request()->except('category') + ['category' => $category->id]),
                'label' => $category->name,
                'active' => request('category') == $category->id
            ];
        }

        return [
            [
                'prompt' => 'Type',
                'links' => collect($categoryLinks)
            ]
        ];
    }
}
