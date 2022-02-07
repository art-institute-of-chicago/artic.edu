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

    public function latest()
    {
        $issue = $this->repository->getLatestIssue();

        return $this->show($issue->id, $issue->getSlug(), true);
    }

    public function show($id, $slug = null, $isRequestForLatest = false)
    {
        $issues = $this->repository->published()->ordered()->get();
        $item = $issues->where('id', (int) $id)->first();

        if (!$item) {
            abort(404);
        }

        $canonicalPath = route('magazine-issues.show', ['id' => $item->id, 'slug' => $item->getSlug()]);

        if (!$isRequestForLatest) {
            if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
                return $canonicalRedirect;
            }
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->list_description); // Issues have no blocks
        $this->seo->setImage($item->imageFront('hero'));

        return view('site.magazineIssueDetail', [
            'item' => $item,
            'contrastHeader' => false,
            'borderlessHeader' => false,
            'issues' => $issues,
            'welcomeNote' => $this->repository->getWelcomeNote($item),
            'canonicalUrl' => $canonicalPath,
        ]);
    }
}
