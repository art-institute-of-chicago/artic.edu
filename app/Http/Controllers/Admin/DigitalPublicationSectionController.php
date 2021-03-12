<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Collection;
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
            'field' => 'title',
        ],
        'type' => [
            'title' => 'Type',
            'field' => 'type',
            'present' => true,
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
        $baseUrl = '//' . config('app.url') . '/' .$this->permalinkBase . $digPub->id . '/' . $digPub->getSlug() . '/' . $item->id . '/';

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

    /**
     * WEB-1963: Adds check for `$parentModuleId`
     */
    public function browser($parentModuleId = null)
    {
        $this->submodule = isset($parentModuleId);
        $this->submoduleParentId = $parentModuleId;

        return parent::browser();
    }

    /**
     * WEB-1963: Override inherited function to fix `edit` link
     */
    protected function getBrowserTableData($items)
    {
        $withImage = $this->moduleHas('medias');

        return $items->map(function ($item) use ($withImage) {
            $columnsData = Collection::make($this->browserColumns)->mapWithKeys(function ($column) use ($item, $withImage) {
                return $this->getItemColumnData($item, $column);
            })->toArray();

            $name = $columnsData[$this->titleColumnKey];
            unset($columnsData[$this->titleColumnKey]);

            return [
                'id' => $item->id,
                'name' => $name,
                // Calling `$this->getModuleRoute` checks if it's a submodule
                'edit' => $this->getModuleRoute($item->id, 'edit'),
                'endpointType' => $this->repository->getMorphClass(),
            ] + $columnsData + ($withImage && !array_key_exists('thumbnail', $columnsData) ? [
                'thumbnail' => $item->defaultCmsImage(['w' => 100, 'h' => 100]),
            ] : []);
        })->toArray();
    }
}
