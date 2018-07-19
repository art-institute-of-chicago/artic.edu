<?php

namespace App\Http\Controllers;

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

        // Add basic http protection if selected.
        if ($page->http_protected) {
            \Httpauth::secure();
        }

        $crumbs     = $page->present()->breadCrumb($page);
        $navigation = $page->present()->navigation();

        $this->seo->setTitle($page->meta_title ?: $page->title);
        $this->seo->setDescription($page->meta_description ?: $page->short_description);

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

    protected function getPage($slug)
    {
        $idSlug = collect(explode("/", $slug))->last();
        $page = $this->genericPageRepository->forSlug($idSlug);
        if (empty($page)) {
            $page = $this->genericPageRepository->getById((integer) $idSlug);
            if (!$page) {
                abort(404);
            }
        }

        return $page;
    }

}
