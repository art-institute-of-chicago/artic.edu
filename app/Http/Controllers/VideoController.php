<?php

namespace App\Http\Controllers;

use App\Repositories\VideoRepository;
use App\Helpers\StringHelpers;

class VideoController extends FrontController
{
    protected $repository;

    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function show($id, $slug = null)
    {
        $item = $this->repository->published()->find((int) $id);

        if (!$item) {
            abort(404);
        }

        $canonicalPath = route('videos.show', ['id' => $item->id, 'slug' => $item->getSlug()]);

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: ($item->list_description ?: ($item->heading ?: StringHelpers::truncateStr(strip_tags($item->present()->copy()), 297))));
        $this->seo->setImage($item->imageFront('hero'));

        $relatedVideos = $this->repository->getRelatedVideos($item);

        return view('site.videoDetail', [
            'item' => $item,
            'relatedVideos' => $relatedVideos,
            'unstickyHeader' => true,
            'canonicalUrl' => $canonicalPath,
        ]);
    }
}
