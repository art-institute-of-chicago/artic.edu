<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AuthorRepository;

class AuthorController extends FrontController
{
    protected $repository;

    public function __construct(AuthorRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function index(Request $request)
    {
        $items = $this->repository->published()->ordered()->paginate();

        $title = 'Authors';

        $subNav = [
            ['label' => $title, 'href' => route('authors.index'), 'active' => true]
        ];

        $nav = [
            ['label' => 'Writings', 'href' => route('articles_publications'), 'links' => $subNav]
        ];

        $this->seo->setTitle($title);

        $view_data = [
            'title' => $title,
            'subNav' => $subNav,
            'nav' => $nav,
            'wideBody' => true,
            'filters' => null,
            'listingCountText' => 'Showing ' . $items->total() . ' authors',
            'listingItems' => $items,
        ];


        return view('site.genericPage.index', $view_data);
    }

    public function show($id, $slug = null)
    {
        $item = $this->repository->published()->where('id', (int) $id)->first();

        if (!$item) {
            abort(404);
        }

        $canonicalPath = route('authors.show', ['id' => $item->id, 'slug' => $item->getSlug()]);

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->title);
        $this->seo->setDescription($item->list_description ?? $item->description); // Issues have no blocks
        $this->seo->setImage($item->imageFront('hero'));

        $breadcrumbs = [
            [
                'label' => 'The Collection',
                'href' => '/collection',
            ],
            [
                'label' => 'Writings',
                'href' => '/articles_publications',
            ],
            [
                'label' => 'Authors',
                'href' => '/authors',
            ],
        ];

        return view('site.authorDetail', [
            'item' => $item,
            'breadcrumbs' => $breadcrumbs,
            'canonicalUrl' => $canonicalPath,
        ]);
    }
}
