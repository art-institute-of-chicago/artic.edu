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

    public function show($slug)
    {
        $item = $this->repository->forSlug($slug);
        if (empty($item)) {
            $item = $this->repository->getById((integer) $slug);
        }


        $item->articleType = 'video';
        $item->type = 'video';

        $video = [
            'type' => 'embed',
            'size' => 'l',
            'media' => $item,
            "poster" => $item->imageFront('hero'),
            'hideCaption' => true
        ];

        $blocks = array([
                        'type' => 'text',
                        'content' => '<p>'.$item->heading.'</p>'
                    ]);
        // dd($blocks);

        $relatedVideos = Video::published()->limit(4)->whereNotIn('id', array($item['id']))->get();

        return view('site.videoDetail', [
            'item' => $item,
            'video' => $video,
            'blocks' => $blocks,
            'relatedVideos' => $relatedVideos
        ]);
    }
}
