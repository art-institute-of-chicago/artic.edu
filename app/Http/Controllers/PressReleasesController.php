<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\Repositories\PressReleaseRepository;
use App\Models\PressRelease;

class PressReleasesController extends FrontController
{

    protected $repository;

    public function __construct(PressReleaseRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function index(Request $request)
    {
        $year = $request->get('year') ? (int) $request->get('year') : null;
        $model = PressRelease::current()->published()->orderBy('publish_start_date', 'desc');

        if (!empty($year)) {
            $model = $model->where(DB::raw('YEAR(publish_start_date)'), $year);
        }

        $items = $model->paginate();
        $title = 'Press Releases';
        $subNav = [
            ['label' => $title, 'href' => route('about.press'), 'active' => true],
            ['label' => 'Press Releases Archive', 'href' => route('about.press.archive')]
        ];

        $nav = [
            ['label' => 'About', 'href' => '/about', 'links' => $subNav]
        ];

        $crumbs = [
            ['label' => 'About', 'href' => '/about'],
            ['label' => $title, 'href' => '']
        ];

        $startYear = date('Y');
        $endYear = 2012;
        $yearLinks = [];

        $active = false;
        if ($year == null) {
            $active = true;
        }
        $yearLinks[] = array('href' => '?', 'label' => 'All', 'active' => $active);
        for($i = $startYear; $i >= $endYear; $i--) {
            $active = false;
            if ($year == $i) {
                $active = true;
            }
            $yearLinks[] = array('href' => '?year='.$i, 'label' => $i, 'active' => $active);
        }

        $filters = array(
            array(
                'prompt' => 'Year',
                'links' => $yearLinks
            ),
        );

        $view_data = [
            'title' => $title,
            'subNav' => $subNav,
            'nav' => $nav,
            "breadcrumb" => $crumbs,
            'wideBody' => true,
            'year' => $year,
            'filters' => $filters,
            'listingCountText' => 'Showing '.$items->total().' press releases',
            'listingItems' => $items,
        ];


        return view('site.pressreleases.index', $view_data);
    }

    public function archive(Request $request)
    {
        $title = 'Press Releases Archive';
        $items = PressRelease::archive()->published()->paginate();
        $subNav = [
            ['label' => 'Press Releases', 'href' => route('about.press')],
            ['label' => $title, 'href' => route('about.press.archive'), 'active' => true]
        ];

        $nav = [
            ['label' => 'About', 'href' => '/about', 'links' => $subNav]
        ];

        $crumbs = [
            ['label' => 'About', 'href' => '/about'],
            ['label' => $title, 'href' => '']
        ];

        $filters = array(
            array(
                'prompt' => 'Year',
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
            'listingCountText' => 'Showing '.$items->total().' press releases',
            'listingItems' => $items,
        ];


        return view('site.pressreleases.index', $view_data);
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
            ['label' => 'Press Releases', 'href' => route('about.press')],
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
