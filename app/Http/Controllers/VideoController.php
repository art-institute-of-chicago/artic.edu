<?php

namespace App\Http\Controllers;

use App\Repositories\VideoRepository;
use App\Models\Page;
use App\Models\Video;
use Carbon\Carbon;

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
        $item = $this->repository->published()->find((integer) $id);

        // Temporary. Remove after redirects are in place!
        if (empty($item)) {
            $item = $this->repository->forSlug($id);
        }

        if (!$item) {
            abort(404);
        }

        // Redirect to the canonical page if it wasn't requested
        $canonicalPath = route('videos.show', ['id' => $item->id, 'slug' => $item->getSlug()], false);
        if ('/' .request()->path() != $canonicalPath) {
            return redirect($canonicalPath, 301);
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->list_description ?: $item->heading ?: truncateStr(strip_tags($item->present()->copy()), 297));
        $this->seo->setImage($item->imageFront('hero'));

        $relatedVideos = $this->repository->getRelatedVideos($item);

        return view('site.videoDetail', [
            'item' => $item,
            'relatedVideos' => $relatedVideos,
            'unstickyHeader' => true,
            'canonicalUrl' => route('videos.show', ['id' => $item->id, 'slug' => $item->getSlug()]),
        ]);
    }
}
