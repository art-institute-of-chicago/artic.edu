<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\GenericPageRepository;

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
            array('href' => '#', 'label' => 'Scheduling a tour', 'active' => ($state === 'detail')),
            array('href' => '#', 'label' => 'Preparing for a museum visit'),
            array('href' => '#', 'label' => 'Bus scholarship'),
            array('href' => '#', 'label' => 'For tour companies'),
        );
        $nav = array(
            array('label' => 'Adults and university', 'href' => '#'),
            array('label' => 'Students', 'href' => '#', 'links' => $subNav, 'active' => ($state === 'landing')),
            array('label' => 'Group FAQs', 'href' => '#',),
        );

        $navs = array('nav' => $nav, 'subNav' => $subNav);

        return view('site.genericpage.show', [
            'subNav' => $navs['subNav'],
            'nav' => $navs['nav'],
            'headerImage' => $page->imageFront('hero'),
            "title" => $page->title,
            "breadcrumb" => [],
            "blocks" => null,
            'featuredRelated' => [],
            'nav' => $navs['nav'],
            'page' => $page,
        ]);
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
}
