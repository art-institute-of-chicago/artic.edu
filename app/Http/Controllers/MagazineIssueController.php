<?php

namespace App\Http\Controllers;

use App\Repositories\MagazineIssueRepository;
use Illuminate\Support\Carbon;

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
        $item = $this->repository->findOrFail($id);
        $canonicalPath = route('magazine-issues.show', ['id' => $item->id, 'slug' => $item->getSlug()]);

        if (!$isRequestForLatest) {
            if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
                return $canonicalRedirect;
            }
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->list_description); // Issues have no blocks
        $this->seo->setImage($item->imageFront('hero'));

        $issuesByYear = $this->repository
            ->published()
            ->ordered()
            ->get()
            ->mapToGroups(function ($issue) {
                $year = (new Carbon($issue->publish_start_date))->year;
                return [$year => $issue];
            });
        $issueArchive = ['title' => 'Archive', 'items' => []];
        foreach ($issuesByYear as $year => $yearIssues) {
            $byYear = ['title' => (string)$year];
            foreach ($yearIssues as $issue) {
                $byYear['items'][] = ['title' => $issue->title, 'url' => route('magazine-issues.show', [$issue])];
            }
            $issueArchive['items'][] = $byYear;
        }

        return view('site.magazineIssueDetail', [
            'item' => $item,
            'contrastHeader' => false,
            'borderlessHeader' => false,
            'issues' => [$issueArchive],
            'welcomeNote' => $this->repository->getWelcomeNote($item),
            'canonicalUrl' => $canonicalPath,
        ]);
    }
}
