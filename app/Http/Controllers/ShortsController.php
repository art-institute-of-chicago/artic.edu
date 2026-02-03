<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Repositories\VideoRepository;
use Illuminate\Http\Request;

class ShortsController extends FrontController
{
    protected $repository;

    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    // Redirect to most recently published short
    public function index()
    {
        if (
            $video = $this->repository
                ->published()
                ->where('is_short', true)
                ->orderBy('uploaded_at', 'desc')
                ->first()
        ) {
            return to_route('shorts.show', [
                'video' => $video,
                'slug' => $video->getSlug(),
            ]);
        }
        abort(404);
    }

    public function show(Request $request, Video $video, $slug = null)
    {
        if (!($video->published && $video->is_short)) {
            abort(404);
        }
        $canonicalPath = route('shorts.show', ['video' => $video, 'slug' => $video->getSlug()]);
        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $previousItem = $this->repository
            ->published()
            ->where('is_short', true)
            ->where('uploaded_at', '>', $video->uploaded_at)
            ->orderBy('uploaded_at', 'asc')
            ->first();
        $nextItem = $this->repository
            ->published()
            ->where('is_short', true)
            ->where('uploaded_at', '<', $video->uploaded_at)
            ->orderBy('uploaded_at', 'desc')
            ->first();


        return view('site.shortsDetail', [
            'item' => $video,
            'previousItem' => $previousItem,
            'nextItem' => $nextItem,
            'canonicalUrl' => $canonicalPath,
            'darkMode' => true,
        ])->fragmentIf($request->has('player'), 'shorts-player');
    }
}
