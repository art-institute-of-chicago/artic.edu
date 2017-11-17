<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Repositories\SiteTagRepository;

class EventController extends ModuleController
{
    protected $moduleName = 'events';

    /*
     * Relations to eager load for the index view
     */
    protected $indexWith = [];

    /*
     * Relations to eager load for the form view
     */
    protected $formWith = ['revisions', 'siteTags'];

    /*
     * Filters mapping ('fFilterName' => 'filterColumn')
     * In the indexData function, name your lists with the filter name + List (fFilterNameList)
     */
    protected $filters = [];

    protected $formWithCount = ['revisions'];
    protected $defaultOrders = ['start_date' => 'desc'];

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        return [
            'siteTagsList'   => app(SiteTagRepository::class)->listAll('name'),
            'with_revisions' => true
        ];
    }

}
