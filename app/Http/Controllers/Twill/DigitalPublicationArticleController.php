<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\NestedModuleController;
use A17\Twill\Services\Listings\Columns\Presenter;
use A17\Twill\Services\Listings\TableColumns;
use App\Http\Controllers\Twill\Behaviors\IsNestedModule;
use App\Repositories\DigitalPublicationRepository;

class DigitalPublicationArticleController extends NestedModuleController
{
    use IsNestedModule;

    protected $permalinkBase = 'digital-publications/';

    protected function setUpController(): void
    {
        parent::setUpController();
        $this->enableReorder();
        $this->setModelName('DigitalPublicationArticle');
        $this->setModuleName('digitalPublications.articles');
        $this->setPreviewView('site.digitalPublicationArticleDetail');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Presenter::make()
                ->field('articleType')
                ->title('Type')
        );

        return $columns;
    }

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
                    'url' => moduleRoute('digitalPublications', 'collection.articlesPublications', 'index'),
                ],
                [
                    'label' => $digPub->title,
                    'url' => moduleRoute('digitalPublications', 'collection.articlesPublications', 'edit', [$digPub->id]),
                ],
                [
                    'label' => 'Articles',
                ],
            ]
            ]
        );
    }

    protected function getBrowserData($prependScope = []): array
    {
        $query = $this->repository->withDepth()->defaultOrder()->where('article_type', '!=', 'grouping');

        $search = $this->request->get('search', $prependScope['search'] ?? null);
        if ($search) {
            $query->whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($search) . '%']);
        }

        $digitalPublicationId = $this->request->get('digitalPublication', $prependScope['digitalPublication'] ?? null);
        if ($digitalPublicationId) {
            $query->where('digital_publication_id', $digitalPublicationId);
        }

        $articles = $query->get();

        $formattedArticles = $articles->map(function ($article) {
            $name = $article->title;
            if ($article->digitalPublication) {
                $name = $article->digitalPublication->title . ' - ' . $name;
            }
            return [
                'id' => $article->id,
                'name' => $name,
                'edit' => route('twill.collection.articlesPublications.digitalPublications.articles.edit', [
                    'digitalPublication' => $article->digital_publication_id,
                    'article' => $article->id
                ]),
                'endpointType' => 'digitalPublicationArticles',
                'thumbnail' => $article->defaultCmsImage(['w' => 100, 'h' => 100]),
            ];
        });

        return ['data' => $formattedArticles->values()->toArray()];
    }
    protected function transformIndexItems(\Illuminate\Support\Collection|\Illuminate\Pagination\LengthAwarePaginator $items): \Illuminate\Support\Collection|\Illuminate\Pagination\LengthAwarePaginator
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
        $baseUrl = config('app.url') . '/' . $this->permalinkBase . $digPub->id . '/' . $digPub->getSlug() . '/' . $item->id . '/';

        return [
            'types' => $this->repository->getTypes(),
            'baseUrl' => $baseUrl,
            'breadcrumb' => [
                [
                    'label' => 'Digital Publications',
                    'url' => moduleRoute('digitalPublications', 'collection.articlesPublications', 'index'),
                ],
                [
                    'label' => $digPub->title,
                    'url' => moduleRoute('digitalPublications', 'collection.articlesPublications', 'edit', [$digPub->id]),
                ],
                [
                    'label' => 'Articles',
                    'url' => moduleRoute('digitalPublications.articles', 'collection.articlesPublications', 'index', [$request->route('digitalPublication')]),
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
