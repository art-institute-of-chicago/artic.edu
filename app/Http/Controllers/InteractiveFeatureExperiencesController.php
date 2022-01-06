<?php

namespace App\Http\Controllers;

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
        $items = Experience::webPublished()->notUnlisted()->ordered()->paginate();
        $title = 'Interactive Features';

        $this->seo->setTitle($title);

        $nav = [
            ['label' => 'Writings', 'href' => route('articles_publications'), 'links' => [
                [
                    'label' => 'Articles',
                    'href' => route('articles'),
                    'active' => false,
                ],
                [
                    'label' => 'Interactive Features',
                    'href' => route('interactiveFeatures'),
                    'active' => true,
                ],
                [
                    'label' => 'Digital Publications',
                    'href' => route('collection.publications.digital-publications'),
                    'active' => false,
                ],
                [
                    'label' => 'Print Publications',
                    'href' => route('collection.publications.printed-publications'),
                    'active' => false,
                ]
            ]],
        ];

        $crumbs = [
            ['label' => 'The Collection', 'href' => route('collection')],
            ['label' => 'Writings', 'href' => route('articles_publications')],
            ['label' => $title, 'href' => ''],
        ];

        $view_data = [
            'title' => $title,
            'nav' => $nav,
            'breadcrumb' => $crumbs,
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
        $this->seo->setDescription($experience->listing_description ?? $experience->subtitle);
        $this->seo->setImage($experience->imageFront('thumbnail', 'default'));
        if ($experience->is_unlisted) {
            $this->seo->nofollow = true;
            $this->seo->noindex = true;
        }

        $view = 'site.experienceDetail';

        return view($view, [
            'contrastHeader' => true,
            'experience' => $experience,
            'furtherReadingTitle' => $this->repository->getFurtherReadingTitle($experience) ?? null,
            'furtherReadingItems' => $this->repository->getFurtherReadingItems($experience) ?? null,
            'canonicalUrl' => route(
                'interactiveFeatures.show',
                [
                    'slug' => $experience->getSlug()
                ]
            ),
            'unstickyHeader' => true,
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
}
