<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Page;
use App\Repositories\Api\DigitalLabelRepository;
use App\Repositories\EventRepository;
use App\Models\DigitalLabel;
use Carbon\Carbon;

class DigitalLabelsController extends FrontController
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

    public function __construct(DigitalLabelRepository $repository)
    {
        $this->repository = $repository;
        $this->apiRepository = $repository;

        parent::__construct();
    }

public function index(Request $request)
    {
        $items = DigitalLabel::published()->paginate();
        $title = 'Digital labels';
        $subNav = [
            ['label' => $title, 'href' => route('digitalLabels.show'), 'active' => true]
        ];

        $nav = [
            ['label' => 'Collection', 'href' => route('collection'), 'links' => $subNav]
        ];

        $crumbs = [
            ['label' => 'The Collection', 'href' => route('collection')],
            ['label' => $title, 'href' => '']
        ];

        $view_data = [
            'title' => $title,
            'subNav' => $subNav,
            'nav' => $nav,
            "breadcrumb" => $crumbs,
            'wideBody' => true,
            'filters' => null,
            'listingCountText' => 'Showing '.$items->total().' digital labels',
            'listingItems' => $items,
        ];

        return view('site.genericPage.index', $view_data);
    }

    protected function show($id, $slug = null)
    {
        $item = $this->apiRepository->getById((Integer) $id, ['apiElements']);

        // Redirect to the canonical page if it wasn't requested
        $canonicalPath = route('digitalLabels.show', ['id' => $item->id, 'slug' => $item->titleSlug ], false);
        if ('/' .request()->path() != $canonicalPath) {
            return redirect($canonicalPath, 301);
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->list_description);
        $this->seo->setImage($item->imageFront('hero'));

        return view('site.digitalLabelDetail', [
            'item' => $item,
            'canonicalUrl' => route('digitalLabels.show', ['id' => $item->id, 'slug' => $item->titleSlug ]),
        ]);
    }
}
