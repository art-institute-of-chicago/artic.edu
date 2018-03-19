<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;

class GenericPageController extends ModuleController
{
    protected $moduleName = 'genericPages';

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'field' => 'title',
            'sort' => true
        ],
    ];

    protected $indexOptions = [
        'reorder' => true,
        'permalink' => false,
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
        $pagesList = $this->repository->listAll('title');
        $pagesList = $pagesList->prepend('None', '');
        // dd($pagesList);
        // app(CategoryRepository::class)->listAll('name'),

        return [
            'nested' => true,
            'nestedDepth' => 4,
            'pages' => $pagesList
        ];
    }

    private function getParents($exceptPage = null)
    {
        return $this->repository->get([], [
            'parent_id' => null,
            'exceptIds' => is_null($exceptPage) ? [] : [$exceptPage],
        ], [
            'position' => 'asc',
        ]);
    }


    protected function formData($request)
    {
        $page = $this->repository->getById(request('genericPage'));

        return [
            'parents' => $this->getParents(request('page'))->map(function ($page) {
                return [
                    'id' => $page->id,
                    'name' => $page->title,
                    'edit' => $this->getModuleRoute($page->id, 'edit'),
                ];
            }),
            'breadcrumb' => []
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


}
