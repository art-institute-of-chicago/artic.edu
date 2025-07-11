<?php

namespace App\Http\Controllers;

use App\Repositories\DigitalPublicationArticleRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class DigitalPublicationArticleController extends FrontController
{
    protected $repository;

    public function __construct(DigitalPublicationArticleRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function show($pubId, $pubSlug, $id, $slug = null)
    {
        $item = $this->repository->published()->findOrFail($id);

        $canonicalPath = $item->present()->getCanonicalUrl();

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->list_description);
        $this->seo->setImage($item->imageFront('hero'));

        $this->seo->citationTitle = $item->meta_title ?: $item->title;
        $this->seo->citationPublisher = 'The Art Institute of Chicago';

        if ($item->authors) {
            foreach ($item->authors as $author) {
                $this->seo->citationAuthor[] = $author->title;
            }
        } else {
            $this->seo->citationAuthor[] = $item->author_display;
        }

        if ($item->date) {
            $this->seo->citationPublicationDate = $item->date->toDateString();
            $this->seo->citationOnlineDate = $item->date->toDateString();
        }

        if ($item->digitalPublication->is_unlisted) {
            $this->seo->nofollow = true;
            $this->seo->noindex = true;
        }

        View::share('itemType', Str::slug(title: $item->type));
        return view('site.digitalPublicationArticleDetail', [
            'item' => $item,
            'contrastHeader' => false,
            'borderlessHeader' => false,
            'unstickyHeader' => true,
            'canonicalUrl' => $canonicalPath,
            'bgcolor' => $item->digitalPublication->bgcolor,
        ]);
    }
}
