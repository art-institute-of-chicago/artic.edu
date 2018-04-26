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
        $page = $this->getPage($slug);
        $crumbs = $page->buildBreadCrumb($page);
        $navs = $page->buildNav();

        return view('site.genericpage.show', [
            'borderlessHeader' => !(empty($page->imageFront('banner'))),
            'subNav' => $navs['subNav'],
            'nav' => $navs['nav'],
            'intro' => $page->short_description,
            'headerImage' => $page->imageFront('banner'),
            "title" => $page->title,
            "breadcrumb" => $crumbs,
            "blocks" => null,
            'featuredRelated' => $this->getRelated($page),
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
        $page = $this->genericPageRepository->forSlug($parts->last());
        if (empty($page)) {
            $page = $this->genericPageRepository->getById((integer) $parts->last());
        }

        if (!$page) {
            abort(404);
        }

        return $page;
    }

    public function getRelated($page)
    {
        $items = collect([]);

        $types = collect([]);
        if ($page->events) {
            $types[] = 'events';
        }
        if ($page->articles) {
            $types[] = 'articles';
        }
        if ($page->exhibitions) {
            $types[] = 'exhibitions';
        }

        $types = $types->shuffle();

        $featured = null;
        $type = $types->first();
        // $type = 'exhibitions';
        if ($type) {
            if ($type == 'events') {
                $item = $page->events->first();
                if ($item) {
                    $featured = [
                        'type' => 'event'
                    ,   'items' => [$item]
                    ];
                }
            }
            if ($type == 'articles') {
                $item = $page->articles->first();
                if ($item) {
                    $featured = [
                        'type' => 'article'
                    ,   'items' => [$item]
                    ];
                }
            }
            if ($type == 'exhibitions') {
                $item = $page->exhibitions->first();
                if ($item) {
                    $exhibition = $this->exhibitionRepository->getById($item->datahub_id);
                    $featured = [
                        'type' => 'exhibition'
                    ,   'items' => [$exhibition]
                    ];
                }
            }
        } else {
            $featured = [];
        }

        return $featured;
    }
}
