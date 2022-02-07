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

    public function latest()
    {
        if (request()->url() !== route('issues.latest')) {
            return redirect()->route('issues.latest');
        }

        $issue = $this->repository->getLatestIssue();

        if (!$issue) {
            return redirect('/artinstitutereview/about');
        }

        return $this->show($issue->id, $issue->getSlug(), true);
    }

    public function show($issueNumber, $slug = null, $isRequestForLatest = false)
    {
        $issues = $this->repository->published()->get();
        $item = $issues->where('issue_number', (int) $issueNumber)->first();

        if (!$item) {
            abort(404);
        }

        $canonicalPath = route('issues.show', ['issueNumber' => $item->issue_number, 'slug' => $item->getSlug()]);

        if (!$isRequestForLatest) {
            if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
                return $canonicalRedirect;
            }
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->heading); // Issues have no blocks
        $this->seo->setImage($item->imageFront('hero'));

        return view('site.issueDetail', [
            'item' => $item,
            'contrastHeader' => false,
            'borderlessHeader' => false,
            'issues' => $issues,
            'welcomeNote' => $this->repository->getWelcomeNote($item),
            'canonicalUrl' => $canonicalPath,
        ]);
    }
}
