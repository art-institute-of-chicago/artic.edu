<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;

class SelectionController extends ModuleController
{
    protected $moduleName = 'selections';

    protected $indexColumns = [
        'image' => [
            'title' => 'Hero',
            'thumb' => true,
            'variant' => [
                'role' => 'hero',
                'crop' => 'square',
            ],
        ],
        'title' => [
            'title' => 'Title',
            'edit_link' => true,
            'sort' => true,
            'field' => 'title',
        ],
        'artworksCount' => [
            'title' => 'Artworks count',
            'edit_link' => true,
            'field' => 'artworksCount',
            'present' => true,
        ],
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
        return [];
    }

    protected function formData($request)
    {
        return [];
    }

}
