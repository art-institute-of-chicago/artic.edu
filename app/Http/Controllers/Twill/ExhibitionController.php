<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Presenter;
use A17\Twill\Services\Listings\TableColumns;
use App\Repositories\Api\ExhibitionRepository;

class ExhibitionController extends BaseApiController
{
    public function setUpController(): void
    {
        $this->disableBulkDelete();
        $this->disableBulkEdit();
        $this->disableCreate();
        $this->disableDelete();
        $this->disableRestore();
        $this->disablePublish();
        $this->eagerLoadFormRelations(['revisions']);
        $this->enableAugmentedModel();
        $this->setModuleName('exhibitions');
        $this->setPreviewView('site.exhibitionDetail');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Presenter::make()
                ->title('Dates')
                ->field('date')
                ->sortable()
                ->sortKey('aic_start_at')
                ->sortByDefault(direction: 'desc')
        );
        return $columns;
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('exhibition') ?? request('id'));
        $baseUrl = config('app.url') . '/exhibitions/' . $item->datahub_id . '/';

        return [
            'autoRelated' => $this->getAutoRelated($item),
            'exhibitionTypesList' => $this->repository->getExhibitionTypesList(),
            'exhibitionStatusesList' => $this->repository->getExhibitionStatusesList(),
            'editableTitle' => false,
            'baseUrl' => $baseUrl,
        ];
    }

    protected function previewData($item)
    {
        // The ID is a datahub_id not a local ID
        $apiRepo = app(ExhibitionRepository::class);
        $apiItem = $apiRepo->getById($item->datahub_id);

        // Force the augmented model
        $apiItem->setAugmentedModel($item);

        return $apiRepo->getShowData($apiItem);
    }
}
