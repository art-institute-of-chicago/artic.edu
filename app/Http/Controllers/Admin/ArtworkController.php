<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\SiteTagRepository;

class ArtworkController extends BaseApiController
{
    protected $moduleName = 'artworks';
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
        'permalink' => true,
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
        'augmented' => [
            'title' => 'Augmented?',
            'field' => 'augmented',
            'present' => true
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
    protected $formWith = [];

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('artwork'));
        $baseUrl = '//'.config('app.url').'//artworks//'.$item->id.'-';

        return [
            'editableTitle' => false,
            'baseUrl' => $baseUrl
        ];
    }

    public function browser()
    {
        // Allow to filter by IDS when listing artworks.
        return response()->json($this->getBrowserData(['id' => request('artwork_ids')]));
    }

}
