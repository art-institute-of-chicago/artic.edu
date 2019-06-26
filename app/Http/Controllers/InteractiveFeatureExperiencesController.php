<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Experience;
use App\Repositories\ExperienceRepository;
use Illuminate\Http\Request;

class InteractiveFeatureExperiencesController extends FrontController
{
    protected $apiRepository;
    protected $moduleName = 'interactiveFeature.experiences';
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
        $items = Experience::published()->unarchived()->where('kiosk_only', false)->paginate();
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
            'type' => 'experience',
        ];

        return view('site.genericPage.index', $view_data);
    }

    protected function show($slug)
    {
        $experience = $this->repository->forSlug($slug);
        if (in_array('kiosk', request()->segments())) {
            $view = 'site.experienceDetailKiosk';
        } else {
            if ($experience->kiosk_only === true) {
                abort(404);
            }
            $view = 'site.experienceDetail';
        }
        $articles = Article::published()
            ->orderBy('date', 'desc')
            ->paginate(4);
        return view($view, [
            'contrastHeader' => true,
            'experience' => $experience,
            'furtherReading' => $articles,
            'canonicalUrl' => route('interactiveFeatures.show', ['id' => $experience->id, 'slug' => $experience->titleSlug]),
        ]);
    }

    protected function test()
    {
        $articles = Article::published()
            ->orderBy('date', 'desc')
            ->paginate(4);
        return view('site.experienceDetailTest', [
            'contrastHeader' => true,
            'furtherReading' => $articles,
        ]);
    }
}
