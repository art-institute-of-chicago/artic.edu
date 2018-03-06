<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\SiteTagRepository;

class ArtworkController extends BaseApiController
{
    protected $moduleName = 'artworks';
    protected $hasAugmentedModel = false;

    protected $indexOptions = [
        'publish' => false,
        'bulkEdit' => false,
        'feature' => false,
        'restore' => false,
        'permalink' => false,
        'create' => false,
        'edit' => false,
    ];

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'field' => 'title',
        ],
        'id' => [
            'title' => 'Datahub ID',
            'field' => 'id',
        ],
    ];

    /*
     * Relations to eager load for the form view
     */
    protected $formWith = ['siteTags'];

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

    public function browser()
    {
        // Allow to filter by IDS when listing artworks.
        return response()->json($this->getBrowserData(['id' => request('artwork_ids')]));
    }

}
