<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\Api\ExhibitionRepository;
use App\Libraries\Search\ExhibitionHistoryService;

use App\Models\Api\Exhibition;
use App\Models\Page;

class ExhibitionHistoryController extends FrontController
{
    protected $apiRepository;

    public function __construct(ExhibitionRepository $repository)
    {
        $this->apiRepository = $repository;

        parent::__construct();
    }

    public function index(Request $request, ExhibitionHistoryService $service)
    {
        $page = Page::forType('Exhibition History')->firstOrFail();

        $activeYear = $service->activeYear();
        $decades    = $service->decades();
        $years      = $service->years();

        $exhibitions = $this->apiRepository->history($activeYear, request()->get('q'));

        // If we have no results, try to find them across the entire archive
        if ($exhibitions->isEmpty()) {
            $extraResults = $this->apiRepository->forSearchQuery(request('q'));
        }

        $viewData = [
            'page'    => $page,
            'years'   => $years,
            'decades' => $decades,
            'activeYear'    => $activeYear,
            'decade_prompt' => $service->getDecadePrompt(),
            'exhibitions'   => $exhibitions,
            'extraResults'  => $extraResults ?? null
        ];

        return view('site.exhibitionHistory', $viewData);
    }

    public function show($idSlug)
    {
        $resource = Exhibition::with('artworks')->find((Integer) $idSlug);
    }

}
