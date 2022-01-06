<?php

namespace App\Http\Controllers;

use App\Models\Page;

class ArticlesPublicationsController extends FrontController
{
    public function index()
    {
        $page = Page::forType('Articles and Publications')->first();
        $artIdeasPage = Page::forType('Art and Ideas')->first();

        $articles = $page->getRelatedWithApiModels('featured_items', [], [
            'articles' => false,
            'experiences' => false
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
            'journalFeatureHero' => $page->present()->getFeaturedJournalIssue(),
            'journalFeatures' => $page->present()->getFeaturedJournalArticles(),
            'digitalPublications' => [
                'items' => $page->digitalPublications
            ],
            'experiences' => [
                'items' => $page->experiences()->notUnlisted()->webPublished()->get(),
            ],
            'printedPublications' => [
                'intro' => $page->present()->printed_publications_intro,
                'items' => $page->printedPublications
            ],
        ]);
    }
}
