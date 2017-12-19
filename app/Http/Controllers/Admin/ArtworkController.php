<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Repositories\SiteTagRepository;

class ArtworkController extends ModuleController
{
    protected $moduleName = 'artworks';

    protected $indexOptions = [
        'publish' => false,
    ];

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'edit_link' => true,
            'sort' => true,
            'field' => 'title',
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
    protected $formWith = ['siteTags'];

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
        return [
            'siteTagsList' => app(SiteTagRepository::class)->listAll('name'),
        ];
    }

}
