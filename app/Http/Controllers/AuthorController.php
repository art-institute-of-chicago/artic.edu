<?php

namespace App\Http\Controllers;

use App\Repositories\AuthorRepository;

class AuthorController extends FrontController
{
    protected $repository;

    public function __construct(AuthorRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function show($id, $slug = null)
    {
        $item = $this->repository->published()->where('id', (Integer) $id)->first();

        if (!$item) {
            abort(404);
        }

        // Redirect to the canonical page if it wasn't requested
        $canonicalPath = route('authors.show', ['id' => $item->id, 'slug' => $item->getSlug()], false);
        if ('/' .request()->path() != $canonicalPath) {
            return redirect($canonicalPath, 301);
        }

        $this->seo->setTitle($item->title);
        $this->seo->setDescription($item->description); // Issues have no blocks
        $this->seo->setImage($item->imageFront('author_image'));

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
            'canonicalUrl' => route('authors.show', ['id' => $item->id, 'slug' => $item->getSlug()]),
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}
