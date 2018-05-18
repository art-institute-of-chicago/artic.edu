<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\PressReleaseRepository;
use App\Models\PressRelease;

class PressReleasesController extends BaseScopedController
{

    protected $repository;

    protected $entity = \App\Models\PressRelease::class;

    protected $scopes = [
        'year'    => 'byYear',
        'month'   => 'byMonth'
    ];


    public function __construct(PressReleaseRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }


    protected function beginOfAssociationChain()
    {
        // Apply default scopes to the beginning of the chain
        return parent::beginOfAssociationChain()
            ->published()
            ->orderBy('publish_start_date', 'desc');
    }


    public function index()
    {
        $items = $this->collection()->current()->paginate();

        $navElements = $this->getNavElements('Press Releases');

        $viewData = [
            'wideBody' => true,
            'filters' => $this->getFilters(range(date('Y'), 2012), range(1,12)),
            'listingCountText' => 'Showing '.$items->total().' press releases',
            'listingItems' => $items,
        ] + $navElements;

        return view('site.genericPage.index', $viewData);
    }


    public function archive()
    {
        $items = $this->collection()->archive()->paginate();

        $navElements = $this->getNavElements('Press Releases Archive');

        $viewData = [
            'wideBody' => true,
            'filters'  => $this->getFilters(range(2011, 1939), null, 'about.press.archive'),
            'listingCountText' => 'Showing '.$items->total().' press releases',
            'listingItems' => $items,
        ] + $navElements;

        return view('site.genericPage.index', $viewData);
    }


    protected function getFilters(Array $yearRange = null, Array $monthRange = null, $baseRoute = 'about.press')
    {
        $filters = [];

        if ($yearRange) {
            $yearLinks[] = [
                'href' => route($baseRoute, request()->except('year')),
                'label' => 'All',
                'active' => empty(request('year', null))
            ];

            foreach ($yearRange as $year) {
                $yearLinks[] = [
                    'href'   => route($baseRoute, request()->except('year') + ['year' => $year]),
                    'label'  => $year,
                    'active' => request('year') == $year
                ];
            }

            $filters[] = [
                'prompt' => 'Year',
                'links'  => collect($yearLinks)
            ];
        }

        if ($monthRange) {
            $monthLinks[] = [
                'href' => route($baseRoute, request()->except('month')),
                'label' => 'All',
                'active' => empty(request('month', null))
            ];

            foreach ($monthRange as $month) {
                $monthLinks[] = [
                    'href'   => route($baseRoute, request()->except('month') + ['month' => $month]),
                    'label'  => Carbon::create(date('Y'), $month)->format('F'),
                    'active' => request('month') == $month
                ];
            }

            $filters[] = [
                'prompt' => 'Month',
                'links'  => collect($monthLinks)
            ];
        }

        return $filters;
    }


    protected function getNavElements($title)
    {
        $subNav = [
            [
                'label'  => 'Press Releases',
                'href'   => route('about.press'),
                'active' => request()->route()->getName() == 'about.press'
            ],
            [
                'label'  => 'Press Releases Archive',
                'href'   => route('about.press.archive'),
                'active' => request()->route()->getName() == 'about.press.archive'
            ]
        ];

        $nav = [
            [ 'label' => 'About', 'href' => route('about-us'), 'links' => $subNav ]
        ];

        $crumbs = [
            [ 'label' => 'About', 'href' => route('about-us') ],
            [ 'label' => $title,  'href' => '' ]
        ];

        return compact('title', 'subNav', 'nav', 'crumbs');
    }


    public function show($id)
    {
        $page = $this->repository->forSlug($id);
        if (!$page) {
            $page = $this->repository->find((Integer) $id);

            if (!$page) {
                abort(404);
            }
        }

        $navs = [
            'nav' => [],
            'subNav' => []
        ];
        $crumbs = [
            ['label' => 'About', 'href' => route('about-us')],
            ['label' => 'Press Releases', 'href' => route('about.press')],
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
            'featuredRelated' => [],
            'nav' => $navs['nav'],
            'page' => $page,
        ]);

    }

}
