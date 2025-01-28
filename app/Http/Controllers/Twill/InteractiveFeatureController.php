<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Presenter;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\InteractiveFeature;

class InteractiveFeatureController extends BaseController
{
    protected function setUpController(): void
    {
        parent::setUpController();
        $this->eagerLoadFormRelationCounts(['revisions']);
        $this->setModuleName('interactiveFeatures');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Presenter::make()
                ->field('updatedDate')
                ->title('Updated At')
        );

        return $columns;
    }

    protected function getIndexTableMainFilters($items, $scopes = [])
    {
        $statusFilters = parent::getIndexTableMainFilters($items, $scopes);
        array_push($statusFilters, [
            'name' => 'Archived',
            'slug' => 'archived',
            'number' => InteractiveFeature::archived()->count(),
        ]);

        return $statusFilters;
    }

    protected function getIndexItems(array $scopes = [], bool $forcePagination = false)
    {
        $requestFilters = $this->getRequestFilters();

        if (array_key_exists('status', $requestFilters) && $requestFilters['status'] == 'archived') {
            $scopes = $scopes + ['archived' => true];
        } else {
            $scopes = $scopes + ['unarchived' => true];
        }

        return parent::getIndexItems($scopes, $forcePagination);
    }
}
