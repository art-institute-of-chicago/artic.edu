<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;

class SponsorController extends ModuleController
{
    protected $moduleName = 'sponsors';

    protected $indexColumns = [
        'image' => [
            'title' => 'Logo',
            'thumb' => true,
            'variant' => [
                'role' => 'profile',
                'crop' => 'default',
            ],
        ],
        'title' => [
            'title' => 'Title',
            'edit_link' => true,
            'sort' => true,
            'field' => 'title',
        ],
        'copy' => [
            'title' => 'Sponsor copy',
            'copy' => 'Sponsor copy',
            'edit_link' => true,
            'field' => 'copy',
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

    protected $defaultOrders = ['title' => 'asc'];

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        return [];
    }

}
