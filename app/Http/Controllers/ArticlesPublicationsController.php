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

        $articles = $page->getRelatedWithApiModels("featured_items", [
            'digitalLabels' => [
                'apiModel' => 'App\Models\Api\DigitalLabel',
                'moduleName' => 'digitalLabels',
            ],   
        ], [ 
            'articles' => false,
            'digitalLabels' => true
        ]) ?? null;

        $featureHero = $articles->shift();

        $this->seo->setTitle('Publications');
        $this->seo->setImage($featureHero->imageFront('hero'));

        return view('site.articles_publications.index', [
            'primaryNavCurrent' => 'collection',
            'title' => 'The Collection',
            'intro' => $artIdeasPage->present()->art_intro,
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
            'digitalPublications' => [
                'items' => $page->digitalPublications
            ],
            'digitalLabels' => [
                'items' =>  $page->apiModels('digitalLabels', 'DigitalLabel'),
            ],
            'digitalCatalogs' => [
                'items' => $page->digitalCatalogs
            ],
            'printedPublications' => [
                'intro' => $page->present()->printed_publications_intro,
                'items' => $page->printedPublications
            ]
        ]);

    }

}
