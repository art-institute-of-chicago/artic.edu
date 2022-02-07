<?php

namespace App\Http\Controllers;

use App\Repositories\MiradorRepository;
use App\Helpers\StringHelpers;

class MiradorController extends FrontController
{
    protected $repository;

    public function __construct(MiradorRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function show($id, $slug = null)
    {
        $item = $this->repository->published()->find((int) $id);

        if (!$item) {
            abort(404);
        }

        $canonicalPath = route('mirador.show', ['id' => $item->id, 'slug' => $item->getSlug()]);

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: ($item->list_description ?: ($item->heading ?: StringHelpers::truncateStr(strip_tags($item->present()->copy()), 297))));
        $this->seo->setImage($item->imageFront('hero'));

        return view('site.miradorDetail', [
            'item' => $item,
            'unstickyHeader' => true,
            'canonicalUrl' => $canonicalPath,
        ]);
    }
}
