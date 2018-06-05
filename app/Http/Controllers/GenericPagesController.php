<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use A17\CmsToolkit\Http\Controllers\Front\ShowWithPreview;
use App\Repositories\Api\ExhibitionRepository;
use App\Repositories\GenericPageRepository;

use App\Models\Event;
use App\Models\Exhibition;
use App\Models\GenericPage;

class GenericPagesController extends FrontController
{
    protected $genericPageRepository;
    protected $exhibitionRepository;

    public function __construct(GenericPageRepository $genericPageRepository, ExhibitionRepository $exhibitionRepository)
    {
        $this->genericPageRepository = $genericPageRepository;
        $this->exhibitionRepository = $exhibitionRepository;
        parent::__construct();
    }

    public function show($slug)
    {
        $page       = $this->getPage($slug);
        $crumbs     = $page->present()->breadCrumb($page);
        $navigation = $page->present()->navigation();

        return view('site.genericPage.show', [
            'borderlessHeader' => !(empty($page->imageFront('banner'))),
            'nav' => $navigation,
            'intro' => $page->short_description,
            'headerImage' => $page->imageFront('banner'),
            "title" => $page->title,
            "breadcrumb" => $crumbs,
            "blocks" => null,
            'featuredRelated' => $page->featuredRelated,
            'page' => $page,
        ]);
    }

    // Show view has been moved to be used with the trait ShowWithPreview
    protected function showData($slug, $item)
    {
        return $this->genericPageRepository->getShowData($item, $slug);
    }

    protected function getPage($slug)
    {
        $parts = collect(explode("/", $slug));
        $page = $this->genericPageRepository->forSlug($parts->last(), ['parent', 'children']);
        if (empty($page)) {
            $page = $this->genericPageRepository->getById((integer) $parts->last(), ['parent', 'children']);
        }

        if (!$page) {
            abort(404);
        }

        return $page;
    }

}
