<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\DigitalLabel;
use App\Repositories\ExperienceRepository;
use Illuminate\Http\Request;

class DigitalLabelExperiencesController extends FrontController
{
    protected $apiRepository;
    protected $moduleName = 'digitalLabels';
    protected $hasAugmentedModel = true;

    protected $indexColumns = [
        'image' => [
            'title' => 'Hero',
            'thumb' => true,
            'variant' => [
                'role' => 'hero',
                'crop' => 'default',
            ],
        ],
    ];

    public function __construct(ExperienceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $items = DigitalLabel::paginate();
        $title = 'Interactive Features';

        $nav = [
            ['label' => 'Writings', 'href' => route('articles_publications')],
        ];

        $crumbs = [
            ['label' => 'The Collection', 'href' => route('collection')],
            ['label' => $title, 'href' => ''],
        ];

        $view_data = [
            'title' => $title,
            'nav' => $nav,
            "breadcrumb" => $crumbs,
            'wideBody' => true,
            'filters' => null,
            'listingCountText' => 'Showing ' . $items->total() . ' items',
            'listingItems' => $items,
            'type' => 'label',
        ];

        return view('site.genericPage.index', $view_data);
    }

    protected function show($slug)
    {
        $item = $this->repository->forSlug($slug);
        $articles = Article::published()
            ->orderBy('date', 'desc')
            ->paginate(4);
        return view('site.digitalLabelDetail', [
            'contrastHeader' => true,
            'item' => $item,
            'furtherReading' => $articles,
            'canonicalUrl' => route('digitalLabels.show', ['id' => $item->id, 'slug' => $item->titleSlug]),
        ]);
    }

    protected function test()
    {
        $articles = Article::published()
            ->orderBy('date', 'desc')
            ->paginate(4);

        return view('site.digitalLabelDetailTest', [
            'contrastHeader' => true,
            'furtherReading' => $articles,
        ]);
    }

    protected function kiosk()
    {
        $articles = Article::published()
            ->orderBy('date', 'desc')
            ->paginate(4);

        return view('site.digitalLabelKiosk', [
            'contrastHeader' => true,
            'furtherReading' => $articles,
        ]);
    }
}
