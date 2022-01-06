<?php

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
            ['label' => 'Press', 'href' => route('genericPages.show', 'press'), 'links' => $subNav]
        ];

        $crumbs = [
            ['label' => 'Press', 'href' => route('genericPages.show', 'press')],
            ['label' => $title, 'href' => '']
        ];

        $view_data = [
            'title' => $title,
            'subNav' => $subNav,
            'nav' => $nav,
            'breadcrumb' => $crumbs,
            'wideBody' => true,
            'filters' => null,
            'listingCountText' => 'Showing ' . $items->total() . ' exhibition press rooms',
            'listingItems' => $items,
        ];


        return view('site.genericPage.index', $view_data);
    }

    public function show($id)
    {
        $item = $this->repository->getById((int) $id);

        $canonicalPath = route('about.exhibitionPressRooms.show', ['id' => $item->id, 'slug' => $item->getSlug()]);

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $crumbs = [
            ['label' => 'Press', 'href' => route('genericPages.show', 'press')],
            ['label' => 'Exhibition Press Rooms', 'href' => route('about.exhibitionPressRooms')],
            ['label' => $item->title, 'href' => '']
        ];

        return view('site.genericPage.show', [
            'borderlessHeader' => !(empty($item->imageFront('banner'))),
            'subNav' => null,
            'nav' => [],
            'intro' => $item->short_description,
            'headerImage' => $item->imageFront('banner'),
            'title' => $item->title,
            'title_display' => $item->title_display,
            'breadcrumb' => $crumbs,
            'blocks' => null,
            'page' => $item,
            'canonicalUrl' => $canonicalPath,
        ]);
    }
}
