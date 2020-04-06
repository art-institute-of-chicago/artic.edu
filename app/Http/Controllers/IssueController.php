<?php

namespace App\Http\Controllers;

use App\Repositories\IssueRepository;

class IssueController extends FrontController
{
    protected $repository;

    public function __construct(IssueRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function show($issueNumber, $slug = null)
    {
        $item = $this->repository->published()->where('issue_number', (Integer) $issueNumber)->first();

        if (!$item) {
            abort(404);
        }

        // Redirect to the canonical page if it wasn't requested
        $canonicalPath = route('issues.show', ['issueNumber' => $item->issue_number, 'slug' => $item->getSlug()], false);
        if ('/' .request()->path() != $canonicalPath) {
            return redirect($canonicalPath, 301);
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->heading); // Issues have no blocks
        $this->seo->setImage($item->imageFront('hero'));

        return view('site.issueDetail', [
            'contrastHeader' => false,
            'borderlessHeader' => false,
            'item' => $item,
            'canonicalUrl' => route('issues.show', ['id' => $item->id, 'slug' => $item->getSlug()]),
        ]);
    }
}
