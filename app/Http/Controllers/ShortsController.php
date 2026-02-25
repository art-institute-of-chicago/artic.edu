<?php

namespace App\Http\Controllers;

use App\Facades\EmbedConverterFacade;
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
        if ($request->missing('player')) {
            if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
                return $canonicalRedirect;
            }
        }

        $previousShorts = $this->repository
            ->published()
            ->where('is_short', true)
            ->where('uploaded_at', '>', $video->uploaded_at)
            ->orderBy('uploaded_at', 'desc')
            ->limit(5)
            ->get();
        $nextShorts = $this->repository
            ->published()
            ->where('is_short', true)
            ->where('uploaded_at', '<', $video->uploaded_at)
            ->orderBy('uploaded_at', 'desc')
            ->limit(5)
            ->get();

        $dataAttributes = collect([$previousShorts, $video, $nextShorts])
            ->flatten()
            ->mapWithKeys(function ($short) {
                // Keyed by video id
                return [$short->id => $this->dataAttributes([
                    'embedId' => 'shorts-player-iframe',
                    'loadVideoById' => $short->youtube_id,
                ])];
            });

        $this->seo->nofollow = true;
        $this->seo->noindex = true;

        $embed = EmbedConverterFacade::createYouTubeEmbed(attributes: [
            'id' => 'shorts-player-iframe',
            'src' => $video->embed_url,
        ]);

        return view('site.shortsDetail', [
            'item' => $video,
            'embed' => $embed,
            'previousItems' => $previousShorts,
            'nextItems' => $nextShorts,
            'dataAttributes' => $dataAttributes,
            'canonicalUrl' => $canonicalPath,
            'darkMode' => true,
        ])->fragmentIf($request->has('player'), 'shorts-player');
    }

    /**
     * Convert an array into a data-attribute string.
     */
    private function dataAttributes(array $data): string
    {
        return collect($data)->map(function ($value, $key) {
            if (is_numeric($key)) {
                $attribute = str($value)->kebab()->prepend('data-');
            } else {
                $attribute = str($key)->kebab()->prepend('data-')->append("='$value'");
            }
            return $attribute;
        })->join(' ');
    }
}
