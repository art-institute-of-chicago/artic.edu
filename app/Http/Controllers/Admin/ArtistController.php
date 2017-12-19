<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;

class ArtistController extends ModuleController
{
    protected $moduleName = 'artists';

    protected $indexOptions = [
        'publish' => false,
    ];

    protected $titleColumnKey = 'name';

    protected $indexColumns = [
        'name' => [
            'title' => 'Name',
            'edit_link' => true,
            'sort' => true,
            'field' => 'name',
        ],
        'datahub_id' => [
            'title' => 'Datahub ID',
            'edit_link' => true,
            'sort' => true,
            'field' => 'datahub_id',
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
