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
        $mag = $this->repository->getLatestIssue();
        return $this->show($mag->id, $mag->getSlug(), true);
    }

    public function show($id, $slug = null, $isRequestForLatest = false)
    {
        $issues = $this->repository->published()->get();
        $item = $issues->where('id', (Integer) $id)->first();

        if (!$item) {
            abort(404);
        }

        if (!$isRequestForLatest) {
            if ($cannonicalRedirect = $this->getCannonicalRedirect('magazine-issues.show', $item)) {
                return $cannonicalRedirect;
            }
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->list_description); // Issues have no blocks
        $this->seo->setImage($item->imageFront('hero'));

        return view('site.magazineIssueDetail', [
            'contrastHeader' => false,
            'borderlessHeader' => false,
            'item' => $item,
            'issues' => $issues,
            'welcomeNote' => $this->repository->getWelcomeNote($item),
            'canonicalUrl' => route('magazine-issues.show', ['id' => $item->id, 'slug' => $item->getSlug()]),
        ]);
    }
}
