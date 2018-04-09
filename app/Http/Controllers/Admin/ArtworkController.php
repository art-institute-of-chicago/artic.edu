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
        'image' => [
            'thumb' => true,
            'present' => true,
            'presenter' => 'imageThumb',
            'variant' => [
                'role' => 'hero',
                'crop' => 'default',
            ],
        ],
        'fullTitle' => [
            'title' => 'Title',
            'field' => 'fullTitle'
        ],
        'main_reference_number' => [
            'title' => 'Reference number',
            'field' => 'main_reference_number'
        ],
        'artist_display' => [
            'title' => 'Artist',
            'field' => 'artist_display'
        ]
    ];

    protected $titleColumnKey = 'fullTitle';

    protected $browserColumns = [
        'fullTitle' =>  [
            'title' => 'Title',
            'field' => 'fullTitle',
        ]
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
