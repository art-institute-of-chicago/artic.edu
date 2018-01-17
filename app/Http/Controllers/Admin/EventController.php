<?php

namespace App\Http\Controllers\Admin;
use App\Repositories\SiteTagRepository;

class EventController extends BaseApiController
{
    protected $moduleName = 'events';
    protected $modelName  = 'Event';
    protected $apiModelName  = 'Api\Event';

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
    ];

    protected $featureField = 'landing';

    protected $indexWith = ['medias'];

    protected $formWith = ['revisions', 'siteTags', 'events'];

    protected $filters = [];

    protected $defaultOrders = [];

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
