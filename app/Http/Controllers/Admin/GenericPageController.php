<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;

use App\Repositories\GenericPageRepository;
use App\Repositories\PageCategoryRepository;

class GenericPageController extends ModuleController
{
    protected $moduleName = 'genericPages';
    protected $previewView = 'site.genericpage.show';

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'field' => 'title',
            'sort' => true,
        ],
    ];

    protected $indexOptions = [
        'reorder' => true,
        'permalink' => true,
    ];

    /*
     * Relations to eager load for the index view
     */
    protected $indexWith = [];

    /*
     * Relations to eager load for the form view
     */
    protected $formWith = [];

    /*
     * Filters mapping ('fFilterName' => 'filterColumn')
     * In the indexData function, name your lists with the filter name + List (fFilterNameList)
     */
    protected $filters = [];

    protected function indexData($request)
    {
        $pagesList = $this->repository->withDepth()->defaultOrder()->get()->filter(function ($page) {
            return $page->depth < 3;
        })->pluck('title');

        $pagesList = $pagesList->prepend('None', '');

        return [
            'nested' => true,
            'nestedDepth' => 3,
            'pages' => $pagesList,
        ];
    }

    private function getParents($exceptPage = null)
    {
        return $this->repository->whereNotIn('id', is_null($exceptPage) ? [] : [$exceptPage])->withDepth()->defaultOrder()->orderBy('position')->get()->filter(function ($page) {
            return $page->depth < 3;
        })->values();
    }

    protected function formData($request)
    {
        $page = $this->repository->getById(request('genericPage'));

        $baseUrl = '//'.config('app.url')."/";
        foreach($page->ancestors as $item) {
            $baseUrl = $baseUrl.$item->slug."/";
        }

        $breadcrumb = $page->ancestors->map(function ($parentPage) {
            return [
                'label' => $parentPage->title,
                'url' => $this->getModuleRoute($parentPage->id, 'edit'),
            ];
        })->toArray();

        return [
            'parents' => $this->getParents($page->id)->map(function ($page) {
                return [
                    'id' => $page->id,
                    'name' => $page->title,
                    'edit' => $this->getModuleRoute($page->id, 'edit'),
                ];
            }),
            'breadcrumb' => empty($breadcrumb) ? null : array_merge($breadcrumb, [
                [
                    'label' => $page->title,
                ],
            ]),

           'baseUrl' => $baseUrl,

            'categoriesList' => app(PageCategoryRepository::class)->listAll('name'),
        ];
    }

    protected function transformIndexItems($items)
    {
        return $items->toTree();
    }

    protected function indexItemData($item)
    {
        return ($item->children ? [
            'children' => $this->getIndexTableData($item->children),
        ] : []);
    }

    protected function previewData($item)
    {
        // The ID is a datahub_id not a local ID
        $apiRepo = app(GenericPageRepository::class);
        $apiItem = $apiRepo->getById($item->id);

        return $apiRepo->getShowData($item);
    }

}
