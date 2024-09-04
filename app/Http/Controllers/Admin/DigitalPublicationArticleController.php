<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\NestedModuleController;
use App\Repositories\DigitalPublicationRepository;
use App\Http\Controllers\Admin\Behaviors\IsNestedModule;
use Illuminate\Support\Collection;

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
        'article_type' => [
            'title' => 'Type',
            'field' => 'articleType',
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
            'nested' => true,
            'nestedDepth' => 2,
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

    protected function getBrowserData($prependScope = [])
    {
        $query = $this->repository->withDepth()->defaultOrder();

        $search = $this->request->get('search', $prependScope['search'] ?? null);
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        $digitalPublicationId = $this->request->get('digitalPublication', $prependScope['digitalPublication'] ?? null);
        if ($digitalPublicationId) {
            $query->where('digital_publication_id', $digitalPublicationId);
        }

        $articles = $query->get();

        $formattedArticles = $articles->map(function ($article) use ($digitalPublicationId) {
            return [
                'id' => $article->id,
                'name' => $digitalPublicationId ? $article->title : ($article->digitalPublication ? $article->digitalPublication->title . ' - ' . $article->title : $article->title),                'edit' => route('admin.collection.articles_publications.digitalPublications.articles.edit', [
                    'digitalPublication' => $article->digital_publication_id,
                    'article' => $article->id
                ]),
                'endpointType' => 'digitalPublicationArticles',
                'thumbnail' => $article->defaultCmsImage(['w' => 100, 'h' => 100]),
            ];
        });

        return ['data' => $formattedArticles->values()->toArray()];
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
        return $this->repository->whereNotIn('id', is_null($exceptPage) ? [] : [$exceptPage])->withDepth()->defaultOrder()->orderBy('position')->get()->filter(function ($page) {
            return $page->depth < 3;
        })->values();
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('article') ?? request('id'));
        $digPub = app(DigitalPublicationRepository::class)->getById(request('digitalPublication'));
        $baseUrl = '//' . config('app.url') . '/' . $this->permalinkBase . $digPub->id . '/' . $digPub->getSlug() . '/' . $item->id . '/';

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
}
