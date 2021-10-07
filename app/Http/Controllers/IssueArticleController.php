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

        $canonicalPath = $item->url;

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: ($item->list_description ?: $item->description));
        $this->seo->setImage($item->imageFront('hero'));

        $this->seo->citationTitle = $item->meta_title ?: $item->title;
        $this->seo->citationJournalTitle = 'Art Institute Review';
        $this->seo->citationJournalAbbrev = 'AIR';
        $this->seo->citationPublisher = 'The Art Institute of Chicago';
        foreach ($item->authors as $author) {
            $this->seo->citationAuthor[] = $author->title;
        }
        if (empty($this->seo->citationAuthor)) {
            $this->seo->citationAuthor[] = $item->author_display;
        }
        $this->seo->citationPublicationDate = $item->date->toDateString();
        $this->seo->citationOnlineDate = $item->date->toDateString();
        $this->seo->citationIssue = $item->present()->issueNumber();

        return view('site.issueArticleDetail', [
            'item' => $item,
            'contrastHeader' => false,
            'borderlessHeader' => false,
            'unstickyHeader' => true,
            'canonicalUrl' => $canonicalPath,
        ]);
    }
}
