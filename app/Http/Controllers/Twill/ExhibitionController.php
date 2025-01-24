<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\Api\Exhibition;
use App\Repositories\Api\ExhibitionRepository;
use App\Repositories\SiteTagRepository;

class ExhibitionController extends BaseApiController
{
    public function setUpController(): void
    {
        $this->disableBulkDelete();
        $this->disableBulkEdit();
        $this->disableCreate();
        $this->disableDelete();
        $this->disableEdit();
        $this->disableRestore();
        $this->eagerLoadFormRelations(['revisions', 'siteTags']);
        // I believe this was meant to load local images (as opposed to from the
        // api), but this no longer seems to work.
        $this->eagerLoadListingRelations(['medias']);
        $this->enableAugmentedModel();
        // The images don't always render, but this was also an issue before
        // upgrading.
        $this->enableShowImage();
        $this->setModuleName('exhibitions');
        $this->setPreviewView('site.exhibitionDetail');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Text::make()
                ->title('Dates')
                ->field('date')
                ->sortable()
                ->sortKey('aic_start_at')
                ->sortByDefault(direction: 'desc')
                ->customRender(self::renderDate(...))
        );
        return $columns;
    }

    protected function renderDate(Exhibition $exhibition)
    {
        $date = '';

        // Strangely, we cannot use isset() or empty() here
        $hasStart = $exhibition->aic_start_at !== null;
        $hasEnd = $exhibition->aic_end_at !== null;

        // These default gracefully to `now` if the attrs are empty
        $start = $exhibition->asDateTime($exhibition->aic_start_at);
        $end = $exhibition->asDateTime($exhibition->aic_end_at);

        if ($hasStart) {
            $date .= $start->format('m d Y');
        }

        if ($hasStart && $hasEnd) {
            $date .= '–';
        }

        if ($hasEnd) {
            $date .= $end->format('m d Y');
        }

        return $date;
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('exhibition') ?? request('id'));
        $baseUrl = '//' . config('app.url') . '/exhibitions/' . $item->datahub_id . '/';

        return [
            'autoRelated' => $this->getAutoRelated($item),
            'siteTagsList' => app(SiteTagRepository::class)->listAll('name'),
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
