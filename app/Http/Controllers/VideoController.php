<?php

namespace App\Http\Controllers;

use App\Helpers\StringHelpers;
use App\Models\Video;
use App\Repositories\VideoRepository;

class VideoController extends FrontController
{
    protected $repository;

    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function show(Video $video, $slug = null)
    {
        if (!$video->published) {
            abort(404);
        }
        $canonicalPath = route('videos.show', ['video' => $video, 'slug' => $video->getSlug()]);
        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        if ($video->categories->first()) {
            $video->topics = $video->categories;
        }

        $this->seo->setTitle($video->meta_title ?: $video->title);
        $this->seo->setDescription($video->meta_description ?: ($video->list_description ?: ($video->heading ?: StringHelpers::truncateStr(strip_tags($video->present()->copy()), 297))));
        $this->seo->setImage($video->imageFront('hero'));

        $relatedVideos = $this->repository->getRelatedVideos($video);

        $transcript = null;
        if ($video->is_captioned && $video->standardCaption->hasActiveTranslation()) {
            $transcript = $video->standardCaption->transcript;
        }

        return view('site.videoDetail', [
            'item' => $video,
            'transcript' => $transcript,
            'relatedVideos' => $relatedVideos,
            'contrastHeader' => true,
            'unstickyHeader' => true,
            'canonicalUrl' => $canonicalPath,
        ]);
    }
}
