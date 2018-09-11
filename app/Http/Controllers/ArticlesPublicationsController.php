<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Page;

class ArticlesPublicationsController extends FrontController
{
    public function index()
    {
        $page = Page::forType('Articles and Publications')->first();
        $artIdeasPage = Page::forType('Art and Ideas')->first();

        $articles = $page->articles;
        $featureHero = $articles->shift();

        $this->seo->setTitle('Publications');
        $this->seo->setImage($featureHero->imageFront('hero'));

        return view('site.articles_publications.index', [
            'primaryNavCurrent' => 'collection',
            'title' => 'The Collection',
            'intro' => $artIdeasPage->art_intro,
            'linksBar' => [
                [
                    'href' => route('collection'),
                    'label' => 'Artworks',
                ],
                [
                    'href' => route('articles_publications'),
                    'label' => 'Writings',
                    'active' => true,
                ],
                [
                    'href' => route('collection.research_resources'),
                    'label' => 'Resources',
                ],
            ],
            'featureHero' => $featureHero,
            'features' => $articles,
            'digitalCatalogs' => [
                'items' => $page->digitalCatalogs
            ],
            'printedCatalogs' => [
                'intro' => $page->printed_catalogs_intro,
                'items' => $page->printedCatalogs
            ]
        ]);

    }

}
