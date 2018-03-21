<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\GenericPageRepository;

use App\Models\GenericPage;

class GenericPagesController extends FrontController
{
    protected $genericPageRepository;

    public function __construct(GenericPageRepository $genericPageRepository)
    {
        $this->genericPageRepository = $genericPageRepository;
        parent::__construct();
    }

    public function show($slug)
    {
        $page = $this->getPage($slug);

        $state = '';
        $subNav = array(
            array('href' => '#', 'label' => 'Tours'),
            array('href' => '#', 'label' => 'Scheduling a tour', 'active' => true),
            array('href' => '#', 'label' => 'Preparing for a museum visit'),
            array('href' => '#', 'label' => 'Bus scholarship'),
            array('href' => '#', 'label' => 'For tour companies'),
        );
        $nav = array(
            array('label' => 'Adults and university', 'href' => '#'),
            array('label' => 'Students', 'href' => '#', 'links' => $subNav, 'active' => true),
            array('label' => 'Group FAQs', 'href' => '#',),
        );

        $navs = $this->buildNav($page);

        return view('site.genericpage.show', [
            'subNav' => $navs['subNav'],
            'nav' => $navs['nav'],
            'headerImage' => $page->imageFront('hero'),
            "title" => $page->title,
            "breadcrumb" => $this->buildBreadCrumb($page),
            "blocks" => null,
            'featuredRelated' => [],
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
}
