<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Repositories\PressReleaseRepository;

class PressReleasesController extends BaseScopedController
{
    protected $repository;

    protected $entity = \App\Models\PressRelease::class;

    protected $scopes = [
        'year' => 'byYear',
        'month' => 'byMonth'
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
        $items = $this->collection()->notUnlisted()->current()->paginate();

        $title = 'Press Releases';

        $this->seo->setTitle($title);

        $navElements = $this->getNavElements($title);

        $viewData = [
            'wideBody' => true,
            'filters' => $this->getFilters(range(date('Y'), 2012), range(1, 12)),
            'listingCountText' => 'Showing ' . $items->total() . ' press releases',
            'listingItems' => $items,
        ] + $navElements;

        return view('site.genericPage.index', $viewData);
    }


    public function archive()
    {
        $items = $this->collection()->notUnlisted()->archive()->paginate();

        $title = 'Press Releases Archive';

        $this->seo->setTitle($title);

        $navElements = $this->getNavElements($title);

        $viewData = [
            'wideBody' => true,
            'filters' => $this->getFilters(range(2011, 1939), null, 'about.press.archive'),
            'listingCountText' => 'Showing ' . $items->total() . ' press releases',
            'listingItems' => $items,
        ] + $navElements;

        return view('site.genericPage.index', $viewData);
    }


    protected function getFilters(array $yearRange = null, array $monthRange = null, $baseRoute = 'about.press')
    {
        $filters = [];

        if ($yearRange) {
            $yearLinks[] = [
                'label' => 'All',
                'href' => route($baseRoute, request()->except('year')),
                'active' => empty(request('year', null))
            ];

            foreach ($yearRange as $year) {
                $yearLinks[] = [
                    'href' => route($baseRoute, request()->except('year') + ['year' => $year]),
                    'label' => $year,
                    'active' => request('year') == $year
                ];
            }

            $filters[] = [
                'prompt' => 'Year',
                'links' => collect($yearLinks)
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
                    'href' => route($baseRoute, request()->except('month') + ['month' => $month]),
                    'label' => Carbon::create(date('Y'), $month)->format('F'),
                    'active' => request('month') == $month
                ];
            }

            $filters[] = [
                'prompt' => 'Month',
                'links' => collect($monthLinks)
            ];
        }

        return $filters;
    }


    protected function getNavElements($title)
    {
        $subNav = [
            [
                'label' => 'Press Releases',
                'href' => route('about.press'),
                'active' => request()->route()->getName() == 'about.press'
            ],
            [
                'label' => 'Press Releases Archive',
                'href' => route('about.press.archive'),
                'active' => request()->route()->getName() == 'about.press.archive'
            ]
        ];

        $nav = [
            ['label' => 'Press', 'href' => route('genericPages.show', 'press'), 'links' => $subNav]
        ];

        $crumbs = [
            ['label' => 'Press', 'href' => route('genericPages.show', 'press')],
            ['label' => $title,  'href' => '']
        ];

        return compact('title', 'subNav', 'nav', 'crumbs');
    }


    public function show($id)
    {
        $item = $this->repository->getById((int) $id);

        $canonicalPath = route('about.press.show', ['id' => $item->id, 'slug' => $item->getSlug()]);

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->meta_title ?? $item->title);
        $this->seo->setDescription($item->meta_description ?? $item->short_description ?? $item->listing_description);
        $this->seo->setImage($item->imageFront('listing'));
        if ($item->is_unlisted) {
            $this->seo->nofollow = true;
            $this->seo->noindex = true;
        }

        $crumbs = [
            ['label' => 'Press', 'href' => route('genericPages.show', 'press')],
            ['label' => 'Press Releases', 'href' => route('about.press')],
            ['label' => $item->title, 'href' => '']
        ];

        return view('site.genericPage.show', [
            'borderlessHeader' => !(empty($item->imageFront('banner'))),
            'subNav' => null,
            'intro' => $item->short_description,
            'headerImage' => $item->imageFront('banner'),
            'title' => $item->title,
            'title_display' => $item->title_display,
            'breadcrumb' => $crumbs,
            'blocks' => null,
            'nav' => [],
            'page' => $item,
            'canonicalUrl' => $canonicalPath,
        ]);
    }
}
