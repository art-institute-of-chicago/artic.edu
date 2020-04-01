<?php

namespace App\Http\Controllers;

use App\Repositories\IssueArticleRepository;

class IssueArticleController extends FrontController
{
    protected $repository;

    public function __construct(IssueArticleRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function show($id, $slug = null)
    {
        $item = $this->repository->published()->findOrFail($id);

        // Redirect to the canonical page if it wasn't requested
        $canonicalPath = route('issue-articles.show', ['id' => $item->id, 'slug' => $item->getSlug()], false);
        if ('/' .request()->path() != $canonicalPath) {
            return redirect($canonicalPath, 301);
        }

        // $this->seo->setTitle($item->meta_title ?: $item->title);
        // $this->seo->setDescription($item->meta_description ?: $item->heading); // Issues have no blocks
        // $this->seo->setImage($item->imageFront('hero'));

        return view('site.issueArticleDetail', [
            'contrastHeader' => false,
            'borderlessHeader' => false,
            'item' => $item,
            'canonicalUrl' => route('issue-articles.show', ['id' => $item->id, 'slug' => $item->getSlug()]),
        ]);
    }
}
