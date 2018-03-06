<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\SiteTagRepository;

class ExhibitionController extends BaseApiController
{
    protected $moduleName = 'exhibitions';
    protected $hasAugmentedModel = true;

    protected $indexOptions = [
        'publish' => false,
        'bulkEdit' => false,
        'create' => false,
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
            'present' => true,
        ],
        'date' => [
            'title' => 'Dates',
            'field' => 'date',
            'present' => true,
            'optional' => false,
        ],
    ];

    protected $indexWith = ['medias'];

    protected $formWith = ['revisions', 'siteTags'];

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
            'exhibitionTypesList' => $this->repository->getExhibitionTypesList(),
        ];
    }

}
