<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Repositories\DigitalPublicationRepository;

class DigitalPublicationSectionController extends ModuleController
{
    protected $moduleName = 'digitalPublications.sections';
    protected $modelName = 'DigitalPublicationSection';

    protected $permalinkBase = 'digital-publications/';

    protected $indexOptions = [
        'permalink' => true,
        'reorder' => true,
    ];

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'edit_link' => true,
            'sort' => true,
            'field' => 'title',
        ],
        'type' => [
            'title' => 'Type',
            'field' => 'type',
            'present' => true,
            'sort' => true,
        ],
    ];
    protected function getParentModuleForeignKey()
    {
        return 'digital_publication_id';
    }

    protected $defaultOrders = ['position' => 'asc'];

    protected function indexData($request)
    {
        $digPub = app(DigitalPublicationRepository::class)->getById(request('digitalPublication'));
        return [
            'breadcrumb' => [
                [
                    'label' => 'Digital Publication',
                    'url' => moduleRoute('digitalPublications', 'collection.articles_publications', 'index'),
                ],
                [
                    'label' => $digPub->title,
                    'url' => moduleRoute('digitalPublications', 'collection.articles_publications', 'edit', $digPub->id),
                ],
                [
                    'label' => 'Sections',
                ],
            ],
        ];
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('section') ?? request('id'));
        $digPub = app(DigitalPublicationRepository::class)->getById(request('digitalPublication'));
        $baseUrl = '//' . config('app.url') . '/' .$this->permalinkBase . $digPub->getSlug() . '/' . $item->type  . '/';

        return [
            'typesList' => $this->repository->getTypesList(),
            'baseUrl' => $baseUrl,
            'breadcrumb' => [
                [
                    'label' => 'Digital Publications',
                    'url' => moduleRoute('digitalPublications', 'collection.articles_publications', 'index'),
                ],
                [
                    'label' => $digPub->title,
                    'url' => moduleRoute('digitalPublications', 'collection.articles_publications', 'edit', $digPub->id),
                ],
                [
                    'label' => 'Sections',
                    'url' => moduleRoute('digitalPublications.sections', 'collection.articles_publications', 'index', $request->route('digitalPublication')),
                ],
                [
                    'label' => $digPub->title,
                ],
            ],
        ];
    }
}
