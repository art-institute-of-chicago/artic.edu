<?php

namespace App\Http\Controllers;

use App\Repositories\Api\ExhibitionRepository;
use A17\CmsToolkit\Http\Controllers\Front\Controller;

class ExhibitionController extends Controller
{
    protected $apiRepository;

    public function __construct(ExhibitionRepository $repository)
    {
        $this->apiRepository = $repository;

        parent::__construct();
    }

    public function show($id)
    {
        // The ID is a datahub_id not a local ID
        $item = $this->apiRepository->getById($id);

        // Load augmented model.
        // TODO: This could be improved to be performed automatically
        $item->getAugmentedModel();

        var_dump($item);
        die();

        return view('site.exhibitionDetail', [
            'article' => $item
        ]);
    }

}
