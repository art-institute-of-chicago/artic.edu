<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Page;
use App\Repositories\Api\DigitalLabelRepository;
use App\Repositories\EventRepository;
use App\Models\DigitalLabel;
use Carbon\Carbon;
use App\Models\Article;

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
        $title = 'Closer Looks';

        $nav = [
            ['label' => 'Writings', 'href' => route('articles_publications')]
        ];

        $crumbs = [
            ['label' => 'The Collection', 'href' => route('collection')],
            ['label' => $title, 'href' => '']
        ];

        $view_data = [
            'title' => $title,
            'nav' => $nav,
            "breadcrumb" => $crumbs,
            'wideBody' => true,
            'filters' => null,
            'listingCountText' => 'Showing '.$items->total().' items',
            'listingItems' => $items,
            'type' => 'label'
        ];

        return view('site.genericPage.index', $view_data);
    }

    protected function show($id, $slug = null)
    {
        $item = $this->apiRepository->getById((Integer) $id, ['apiElements']);

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->list_description);
        $this->seo->setImage($item->imageFront('hero'));

        $articles = Article::published()
                ->orderBy('date', 'desc')
                ->paginate(4);

        return view('site.digitalLabelDetail', [
            'contrastHeader' => true,
            'item' => $item,
            'furtherReading' => $articles,
            'canonicalUrl' => route('digitalLabels.show', ['id' => $item->id, 'slug' => $item->titleSlug ]),
        ]);
    }
}
