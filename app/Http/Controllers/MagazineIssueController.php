<?php

namespace App\Http\Controllers;

use App\Repositories\MagazineIssueRepository;

class MagazineIssueController extends FrontController
{
    protected $repository;

    public function __construct(MagazineIssueRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function show($id, $slug = null)
    {
        $issues = $this->repository->published()->get();
        $item = $issues->where('id', (Integer) $id)->first();

        if (!$item) {
            abort(404);
        }

        // Redirect to the canonical page if it wasn't requested
        $canonicalPath = route('magazine-issues.show', ['id' => $item->id, 'slug' => $item->getSlug()], false);
        if ('/' .request()->path() != $canonicalPath) {
            return redirect($canonicalPath, 301);
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->list_description); // Issues have no blocks
        $this->seo->setImage($item->imageFront('hero'));

        return view('site.magazineIssueDetail', [
            'contrastHeader' => false,
            'borderlessHeader' => false,
            'item' => $item,
            'issues' => $issues,
            'canonicalUrl' => route('magazine-issues.show', ['id' => $item->id, 'slug' => $item->getSlug()]),
        ]);
    }
}
