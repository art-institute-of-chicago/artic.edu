<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\SiteTagRepository;

class ExhibitionController extends BaseApiController
{
    protected $moduleName = 'exhibitions';
    protected $modelName  = 'Exhibition';
    protected $modelNameApi  = 'Api\Exhibition';
    protected $hasAugmentedModel = true;

    protected $indexOptions = [
        'publish' => false,
        'bulkPublish' => false,
        'feature' => false,
        'bulkFeature' => false,
        'restore' => false,
        'bulkRestore' => false,
        'bulkDelete' => false,
        'reorder' => false,
        'permalink' => false,
    ];

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'field' => 'title',
        ],
        'augmented' => [
            'title' => 'Augmented?',
            'field' => 'augmented',
        ],
        'dates' => [
            'title' => 'Dates field',
            'field' => 'dates'
        ],
        'header_copy' => [
            'title' => 'Header copy',
            'field' => 'header_copy',
        ],
    ];

    protected $featureField = 'landing';

    protected $indexWith = ['medias'];

    protected $formWith = ['revisions', 'siteTags', 'shopItems'];

    protected $defaultFilters = ['search' => '%title'];

    protected $defaultOrders = ['title' => 'desc'];

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
