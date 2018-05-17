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
            'filters' => $this->getFilters(),
            'listingCountText' => 'Showing '.$items->total().' press releases',
            'listingItems' => $items,
        ] + $navElements;

        return view('site.pressreleases.index', $viewData);
    }

    
    public function archive()
    {
        $items = $this->collection()->archive()->paginate();

        $navElements = $this->getNavElements('Press Releases Archive');

        $filters = [
            [
                'prompt' => 'Year',
                'links' => collect([['href' => '#', 'label' => 'All', 'active' => true]]),
            ],
        ];

        $viewData = [
            'wideBody' => true,
            'filters'  => $filters,
            'listingCountText' => 'Showing '.$items->total().' press releases',
            'listingItems' => $items,
        ] + $navElements;

        return view('site.pressreleases.index', $viewData);
    }


    protected function getFilters()
    {
        $yearLinks[] = ['href' => '', 'label' => 'All', 'active' => empty(request('year', null))];

        foreach (range(date('Y'), 2012) as $year) {
            $yearLinks[] = [
                'href'   => route('about.press', request()->except('year') + ['year' => $year]),
                'label'  => $year,
                'active' => request('year') == $year
            ];
        }

        $monthLinks[] = ['href' => '', 'label' => 'All', 'active' => empty(request('month', null))];

        foreach (range(1,12) as $month) {
            $monthLinks[] = [
                'href'   => route('about.press', request()->except('month') + ['month' => $month]),
                'label'  => Carbon::create(date('Y'), $month)->format('F'),
                'active' => request('month') == $month
            ];
        }

        return [
            [
                'prompt' => 'Year',
                'links'  => collect($yearLinks)
            ],
            [
                'prompt' => 'Month',
                'links'  => collect($monthLinks)
            ],
        ];
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
            ['label' => 'About', 'href' => '/about'],
            ['label' => 'Press Releases', 'href' => '/about/press'],
            ['label' => $page->title, 'href' => '']
        ];

        return view('site.pressreleases.show', [
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
