<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use Illuminate\Http\JsonResponse;

class ArtworkController extends BaseApiController
{
    public function setUpController(): void
    {
        parent::setUpController();
        $this->enableAugmentedModel();
        $this->enableShowImage();
        $this->setTitleColumnKey('fullTitle');
        $this->setModuleName('artworks');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Text::make()
                ->title('Reference number')
                ->field('main_reference_number')
                ->optional()
        );
        $columns->add(
            Text::make()
                ->title('Artist')
                ->field('artist_display')
                ->optional()
        );
        return $columns;
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('artwork') ?? request('id'));
        $baseUrl = config('app.url') . '/artworks/' . $item->datahub_id . '/';

        return [
            'autoRelated' => $this->getAutoRelated($item),
            'featuredRelated' => $this->getFeatureRelated($item),
            'editableTitle' => false,
            'baseUrl' => $baseUrl,
        ];
    }

    public function browser(): JsonResponse
    {
        // Allow to filter by IDS when listing artworks.
        return response()->json($this->getBrowserData(['id' => request('artwork_ids')]));
    }
}
