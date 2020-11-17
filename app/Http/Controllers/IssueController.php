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
        $issues = $this->repository->published()->get();
        $item = $issues->where('issue_number', (Integer) $issueNumber)->first();

        if (!$item) {
            abort(404);
        }

        $canonicalPath = route('issues.show', ['issueNumber' => $item->issue_number, 'slug' => $item->getSlug()]);

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->heading); // Issues have no blocks
        $this->seo->setImage($item->imageFront('hero'));

        return view('site.issueDetail', [
            'contrastHeader' => false,
            'borderlessHeader' => false,
            'item' => $item,
            'issues' => $issues,
            'canonicalUrl' => $canonicalPath,
        ]);
    }
}
