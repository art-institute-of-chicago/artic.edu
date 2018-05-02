<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Page;

class ArticlesPublicationsController extends Controller
{
    public function index()
    {
        $page = Page::where('type', 8)->first();

        $articles = $page->articles;
        $featureHero = $articles->shift();

        $journals = $page->scholarlyJournals;
        $journalHero = $journals->shift();

        return view('site.articles_publications.index', [
            'primaryNavCurrent' => 'collection',
            'title' => 'The Collection',
            'intro' => 'Explore <em>over 100,000 artworks</em> and information about works of art from all areas in our online encyclopedic collections.',
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
                'intro' => 'Intro text',
                'items' => $page->printedCatalogs
            ],
            'journalHero' => $journalHero,
            'journals' => $journals,
        ]);

    }

}
