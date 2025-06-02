<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EducatorResource;
use App\Models\ResourceCategory;
use App\Models\LandingPage;
use App\Repositories\EducatorResourceRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

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


        $items = EducatorResource::published()->get();

        $contentOptions = ResourceCategory::where('type', 'content')
        ->get()
        ->map(function ($category) {
            return [
                'label' => $category->name,
                'value' => Str::kebab(Str::lower($category->name))
            ];
        });

        $audienceOptions = ResourceCategory::where('type', 'audience')
            ->get()
            ->map(function ($category) {
                return [
                    'label' => $category->name,
                    'value' => Str::kebab(Str::lower($category->name))
                ];
            });

        $topicOptions = ResourceCategory::where('type', 'topic')
            ->get()
            ->map(function ($category) {
                return [
                    'label' => $category->name,
                    'value' => Str::kebab(Str::lower($category->name))
                ];
            });

        $landingPage = LandingPage::where('type_id', collect(LandingPage::TYPES)->search('Educator Resources'))->first() ?? null;

        $crumbs = [
            [
                'label' => $landingPage ? $landingPage->title : 'Educator Resources',
                'href' => $landingPage ? $landingPage->getUrl() : '/educator-resources'
            ],
            [
                'label' => 'Educator Resources',
                'href' => ''
            ]
        ];

        $view_data = [
            'title' => 'Educator Resources',
            'breadcrumb' => $crumbs,
            'wideBody' => true,
            'filters' => $this->getFilters(),
            'items' => $items,
            'contentOptions' => $contentOptions,
            'audienceOptions' => $audienceOptions,
            'topicOptions' => $topicOptions
        ];

        View::share('isIndex', true);
        return view('site.educatorResources.index', $view_data);
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

        return view('site.educatorResources.show', [
            'borderlessHeader' => !(empty($item->imageFront('banner'))),
            'subNav' => null,
            'nav' => null,
            'intro' => $item->short_description,
            'headerImage' => $item->imageFront('banner'),
            'title' => $item->title,
            'title_display' => $item->title_display,
            'breadcrumb' => $crumbs,
            'blocks' => null,
            'item' => $item,
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
