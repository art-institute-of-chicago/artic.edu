<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Repositories\ExperienceRepository;
use App\Libraries\SchemaOrg\SchemaMapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class InteractiveFeatureExperiencesController extends FrontController
{
    protected $apiRepository;
    protected $moduleName = 'interactiveFeature.experiences';
    protected $hasAugmentedModel = true;
    protected $repository;

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
            ['label' => 'Publications', 'href' => '/publications', 'links' => [
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
            ['label' => 'Publications', 'href' => '/publications'],
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

        $this->addJsonLd($experience);

        $view = 'site.experienceDetail';

        $isKiosk = View::shared('isKiosk', false);

        if (isset($isKiosk) && $isKiosk) {
            return view('site.experienceDetail', [
              'contrastHeader' => true,
              'experience' => $experience
            ]);
        } else {
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
    }

    /**
     * The schema.org definition for the given model.
     *
     * Shared defaults (e.g. inLanguage) come from the parent; page-specific
     * properties defined here are merged over them.
     *
     * @param mixed $model The model to map.
     *
     * @return array<string, mixed>
     */
    protected function jsonLdDefinition(mixed $model): array
    {
        $literal = static fn (mixed $value) => static fn () => $value;

        $experienceUrl = static function ($m) {
            if (method_exists($m, 'getSlug') && $m->getSlug() !== '') {
                return route('interactiveFeatures.show', ['slug' => $m->getSlug()]);
            }

            $slug = $m->slug ?? null;

            if (!is_string($slug) || $slug === '') {
                return null;
            }

            return route('interactiveFeatures.show', ['slug' => $slug]);
        };

        return array_merge(
            parent::jsonLdDefinition($model),
            [
                '@type' => 'WebApplication',
                'description' => SchemaMapper::text('listing_description', 'subtitle', 'description'),
                'url' => $experienceUrl,
                'mainEntityOfPage' => $experienceUrl,
                'applicationCategory' => $literal('MultimediaApplication'),
            ]
        );
    }
}
