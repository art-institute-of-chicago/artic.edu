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
        $items = ExhibitionPressRoom::published()->ordered()->paginate();
        $title = 'Exhibition Press Room';

        $subNav = [
            ['label' => $title, 'href' => route('about.exhibitionPressRooms'), 'active' => true]
        ];

        $nav = [
            [ 'label' => 'Press', 'href' => route('genericPages.show', 'press'), 'links' => $subNav ]
        ];

        $crumbs = [
            ['label' => 'Press', 'href' => route('genericPages.show', 'press')],
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
        $page = $this->repository->getById((Integer) $id);

        // Redirect to the canonical page if it wasn't requested
        $canonicalPath = route('about.exhibitionPressRooms.show', ['id' => $page->id, 'slug' => $page->getSlug()]);

        if (!ends_with($canonicalPath, request()->path())) {
            return redirect($canonicalPath, 301);
        }

        $crumbs = [
            ['label' => 'Press', 'href' => route('genericPages.show', 'press')],
            ['label' => 'Exhibition Press Rooms', 'href' => route('about.exhibitionPressRooms')],
            ['label' => $page->title, 'href' => '']
        ];

        return view('site.genericPage.show', [
            'borderlessHeader' => !(empty($page->imageFront('banner'))),
            'subNav' => null,
            'nav' => [],
            'intro' => $page->short_description,
            'headerImage' => $page->imageFront('banner'),
            'title' => $page->title,
            'breadcrumb' => $crumbs,
            'blocks' => null,
            'page' => $page,
            'canonicalUrl' => $canonicalPath,
        ]);

    }

}
