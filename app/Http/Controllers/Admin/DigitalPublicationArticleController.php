<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\NestedModuleController;
use App\Repositories\DigitalPublicationRepository;
use App\Http\Controllers\Admin\Behaviors\IsNestedModule;

class DigitalPublicationArticleController extends NestedModuleController
{
    use IsNestedModule;

    protected $moduleName = 'digitalPublications.articles';
    protected $modelName = 'DigitalPublicationArticle';
    protected $previewView = 'site.digitalPublicationArticleDetail';

    protected $permalinkBase = 'digital-publications/';

    protected $indexOptions = [
        'permalink' => true,
        'reorder' => true,
    ];

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'edit_link' => true,
            'field' => 'title',
        ],
        'type' => [
            'title' => 'Type',
            'field' => 'type',
            'present' => true,
        ],
    ];

    protected function getParentModuleForeignKey()
    {
        return 'digital_publication_id';
    }

    protected $defaultOrders = ['position' => 'asc'];

    protected function indexData($request)
    {
        $digPub = app(DigitalPublicationRepository::class)->getById(request('digitalPublication'));

        $articlesList = $this->repository->withDepth()->defaultOrder()->get()->filter(function ($article) {
            return $article->depth < 3;
        })->pluck('title', 'id');

        $articlesList = $articlesList->prepend('None', '');

        return array_merge(
            parent::indexData($request),
            [
            'types' => $this->repository->getTypes(),
            'articles' => $articlesList,
            'breadcrumb' => [
                [
                    'label' => 'Digital Publication',
                    'url' => moduleRoute('digitalPublications', 'collection.articles_publications', 'index'),
                ],
                [
                    'label' => $digPub->title,
                    'url' => moduleRoute('digitalPublications', 'collection.articles_publications', 'edit', [$digPub->id]),
                ],
                [
                    'label' => 'Articles',
                ],
            ]
            ]
        );
    }

    protected function transformIndexItems($items)
    {
        // If we're in the browser, don't transform the items
        if (property_exists($items, 'path')) {
            return $items;
        }
        return parent::transformIndexItems($items);
    }

    private function getParents($exceptPage = null)
    {
        return array_filter($this->repository->whereNotIn('id', is_null($exceptPage) ? [] : [$exceptPage])->withDepth()->defaultOrder()->orderBy('position')->get()->toArray(), function ($page) {
            return $page->depth < 3;
        })->values();
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('article') ?? request('id'));
        $digPub = app(DigitalPublicationRepository::class)->getById(request('digitalPublication'));
        $baseUrl = '//' . config('app.url') . '/' . $this->permalinkBase . $digPub->id . '/' . $digPub->getSlug() . '/' . $item->id . '/';

        $ancestors = $item->ancestors()->defaultOrder()->get();

        $baseUrl = '//' . config('app.url') . '/';

        foreach ($ancestors as $ancestor) {
            $baseUrl = $baseUrl . url($ancestor->slug);
        }

        return [
            'types' => $this->repository->getTypes(),
            'baseUrl' => $baseUrl,
            'breadcrumb' => [
                [
                    'label' => 'Digital Publications',
                    'url' => moduleRoute('digitalPublications', 'collection.articles_publications', 'index'),
                ],
                [
                    'label' => $digPub->title,
                    'url' => moduleRoute('digitalPublications', 'collection.articles_publications', 'edit', [$digPub->id]),
                ],
                [
                    'label' => 'Articles',
                    'url' => moduleRoute('digitalPublications.articles', 'collection.articles_publications', 'index', [$request->route('digitalPublication')]),
                ],
                [
                    'label' => $item->title,
                ],
            ],
            'parents' => $this->getParents($item->id)->map(function ($parent) {
                return [
                    'id' => $parent->id,
                    'name' => $parent->title,
                    'edit' => $this->getModuleRoute($parent->id, 'edit'),
                ];
            }),
        ];
    }

    protected function form($id, $item = null)
    {
        $item = $this->repository->getById($id, $this->formWith, $this->formWithCount);

        $this->permalinkBase = $item->ancestorsSlug;

        return parent::form($id, $item);
    }
}
