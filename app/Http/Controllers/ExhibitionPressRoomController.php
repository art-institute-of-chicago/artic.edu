<?php
// Copy/paste from other generic listings...

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\ExhibitionPressRoomRepository;
use App\Models\ExhibitionPressRoom;

class ExhibitionPressRoomController extends FrontController
{

    protected $repository;


    public function __construct(ExhibitionPressRoomRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }


    public function index(Request $request)
    {
        $items = ExhibitionPressRoom::published()->paginate();
        $title = 'Exhibition Press Room';

        $subNav = [
            ['label' => $title, 'href' => route('about.exhibitionPressRooms'), 'active' => true]
        ];

        $nav = [
            [ 'label' => 'About', 'href' => route('about-us'), 'links' => $subNav ]
        ];

        $crumbs = [
            ['label' => 'About', 'href' => route('about-us')],
            ['label' => $title, 'href' => '']
        ];

        $view_data = [
            'title'  => $title,
            'subNav' => $subNav,
            'nav'    => $nav,
            "breadcrumb" => $crumbs,
            'wideBody'   => true,
            'filters'    => null,
            'listingCountText' => 'Showing '.$items->total().' exhibition press rooms',
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

        $navs = [
            'nav' => [],
            'subNav' => []
        ];

        $crumbs = [
            ['label' => 'About', 'href' => route('about-us')],
            ['label' => 'Exhibition press rooms', 'href' => route('about.exhibitionPressRooms')],
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
