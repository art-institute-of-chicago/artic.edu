<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $navs = $this->buildNav($page);

        return view('site.genericpage.show', [
            'subNav' => $navs['subNav'],
            'nav' => $navs['nav'],
            'headerImage' => $page->imageFront('hero'),
            "title" => $page->title,
            "breadcrumb" => $this->buildBreadCrumb($page),
            "blocks" => null,
            'featuredRelated' => $this->getRelated($page),
            'nav' => $navs['nav'],
            'page' => $page,
        ]);
    }

    protected function buildNav($page)
    {
        $ancestors = clone $page->ancestors;

        $rootNav = [];
        $subNav = [];

        $root = $ancestors->shift();
        $sub = $ancestors->shift();
        if ($sub) {
            foreach($sub->children as $item) {
                $subNav[] = ['href' => $item->url, 'label' => $item->title];
            }
        }

        foreach($root->children as $item) {
            $navItem = ['href' => $item->url, 'label' => $item->title];

            if ($sub && $item->id == $sub->id) {
                $navItem['links'] = $subNav;
            }
            $rootNav[] = $navItem;

        }
        // // dd($rootNav);
        $nav = array('nav' => $rootNav, 'subNav' => $subNav);

        return $nav;
    }

    protected function getPage($slug)
    {
        $parts = collect(explode("/", $slug));
        $page = $this->genericPageRepository->forSlug($parts->last());
        if (empty($page)) {
            $page = $this->genericPageRepository->getById($parts->last());
        }

        if (!$page) {
            abort(404);
        }

        return $page;
    }

    protected function buildBreadCrumb($page)
    {
        $crumbs = [];

        $ancestors = clone $page->ancestors;

        foreach($page->ancestors as $ancestor) {
            // dd($ancestor);
            $crumb = [];
            $crumb['label'] = $ancestor->title;
            $crumb['href'] = $ancestor->url;

            $crumbs[] = $crumb;
        }

        $crumb = [];
        $crumb['label'] = $page->title;
        $crumb['href'] = $page->url;
        $crumbs[] = $crumb;

        return $crumbs;
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
                $featured = [
                    'type' => 'event'
                ,   'items' => [$item]
                ];
            }
            if ($type == 'articles') {
                $item = $page->articles->first();
                $featured = [
                    'type' => 'article'
                ,   'items' => [$item]
                ];
            }
            if ($type == 'exhibitions') {
                $item = $page->exhibitions->first();
                $exhibition = $this->exhibitionRepository->getById($item->datahub_id);
                $featured = [
                    'type' => 'exhibition'
                ,   'items' => [$exhibition]
                ];
            }
        } else {
            $featured = [];
        }

        return $featured;
    }
}
