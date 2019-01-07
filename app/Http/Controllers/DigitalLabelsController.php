<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Repositories\Api\DigitalLabelRepository;
use App\Repositories\EventRepository;
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

    // public function index()
    // {
    //     // NOTE: Naming conventions for the CMS browsers might be counterintuitive (for backwards compatibility).
    //     //
    //     // exhibitionsExhibitions: Featured exhibitions
    //     // exhibitionsCurrent: Current exhibitions listing
    //     // exhibitionsUpcoming: Featured upcoming exhibitions
    //     // exhibitionsUpcomingListing: Upcoming exhibitions listing.

    //     $this->seo->setTitle('Digital Labels');
    //     $this->seo->setDescription("Now on view—explore the Art Institute's current and upcoming exhibits to plan your visit.");

    //     // $page = Page::forType('Digital Labels')->with('apiElements')->first();

    //     $collection = $page->apiModels('digitalLabels', 'Digital Labels');
  
    //     // $featured = $upcoming ? $page->apiModels('digitalLabels', 'Digital Labels') : $page->apiModels('digitalLabels', 'Digital Labels');

    //     return view('site.digitalLabels', [
    //         // 'page' => $page,
    //         'collection' => $collection,
    //         // 'featured' => $featured,
    //     ]);
    // }

    // public function upcoming()
    // {
    //     return $this->index(true);
    // }

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
