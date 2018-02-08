<?php

namespace App\Http\Controllers;

use App\Repositories\Api\ArtworkRepository;
use A17\CmsToolkit\Http\Controllers\Front\Controller;
use App\Models\Page;

class ArtworkController extends Controller
{
    protected $apiRepository;

    public function __construct(ArtworkRepository $repository)
    {
        $this->apiRepository = $repository;

        parent::__construct();
    }

    public function show($id)
    {
        // The ID is a datahub_id not a local ID
        $item = $this->apiRepository->getById($id);

        var_dump($item);
        die();

        return view('site.artworkDetail', [
            'contrastHeader' => ($article->headerType === 'hero'),
            'article' => $item
        ]);
    }

}
