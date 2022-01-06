<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Repositories\PageCategoryRepository;

class GenericPageController extends ModuleController
{
    protected $moduleName = 'genericPages';
    protected $previewView = 'site.genericPage.show';

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

    /**
     * Relations to eager load for the index view
     */
    protected $indexWith = [];

    /**
     * Relations to eager load for the form view
     */
    protected $formWith = [];

    /**
     * Filters mapping ('filterName' => 'filterColumn')
     * In the indexData function, name your lists with the filter name + List (filterNameList)
     */
    protected $filters = [];

    /**
     * Exposed as public for sitemap:generate command.
     */
    public function indexData($request)
    {
        $pagesList = $this->repository->withDepth()->defaultOrder()->get()->filter(function ($page) {
            return $page->depth < 3;
        })->pluck('title', 'id');

        $pagesList = $pagesList->prepend('None', '');

        return [
            'nested' => true,
            'nestedDepth' => 10,
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
        $item = $this->repository->getById(request('genericPage') ?? request('id'));
        $ancestors = $item->ancestors()->defaultOrder()->get();

        $baseUrl = '//' . config('app.url') . '/';

        foreach ($ancestors as $ancestor) {
            $baseUrl = $baseUrl . $ancestor->slug . '/';
        }

        $breadcrumb = $ancestors->map(function ($parentPage) {
            return [
                'label' => $parentPage->title,
                'url' => $this->getModuleRoute($parentPage->id, 'edit'),
            ];
        })->toArray();

        return [
            'parents' => $this->getParents($item->id)->map(function ($parent) {
                return [
                    'id' => $parent->id,
                    'name' => $parent->title,
                    'edit' => $this->getModuleRoute($parent->id, 'edit'),
                ];
            }),
            'breadcrumb' => (empty($breadcrumb) ? null : $breadcrumb),
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
        return $this->repository->getShowData($item);
    }
}
