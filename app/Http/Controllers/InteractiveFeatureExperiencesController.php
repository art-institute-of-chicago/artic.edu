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
        parent::__construct();
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $items = Experience::webPublished()->paginate();
        $title = 'Interactive Features';

        $this->seo->setTitle($title);

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
        if (in_array('kiosk', request()->segments())) {
            return redirect()->action(
                'InteractiveFeatureExperiencesController@showKiosk',
                ['slug' => $slug]
            );
        }

        $experience = $this->repository->forSlug($slug);

        if (!$experience || $experience->kiosk_only === true) {
            abort(404);
        }

        $this->seo->setTitle($experience->title);
        $this->seo->setDescription($experience->description ?? $experience->subtitle);
        $this->seo->setImage($experience->imageFront('thumbnail', 'social') ?? $experience->imageFront('thumbnail', 'default'));

        $view = 'site.experienceDetail';

        $articles = Article::published()
            ->orderBy('date', 'desc')
            ->paginate(4);

        return view($view, [
            'contrastHeader' => true,
            'experience' => $experience,
            'furtherReading' => $articles,
            'canonicalUrl' => route('interactiveFeatures.show',
                [
                    'id' => $experience->id,
                    'slug' => $experience->titleSlug
                ]
            ),
        ]);
    }

    protected function showKiosk($slug)
    {
        $experience = $this->repository->forSlug($slug);
        if (!$experience) {
            abort(404);
        }

        $this->seo->setTitle($experience->title);

        $view = 'site.experienceDetailKiosk';

        return view($view, [
            'contrastHeader' => true,
            'experience' => $experience
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
