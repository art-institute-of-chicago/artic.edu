<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\Filters\QuickFilter;
use A17\Twill\Services\Listings\Filters\QuickFilters;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\InteractiveFeature;
use Illuminate\Contracts\Database\Eloquent\Builder;

class InteractiveFeatureController extends BaseController
{
    protected function setUpController(): void
    {
        $this->disablePermalink();
        $this->eagerLoadFormRelations(['revisions']);
        $this->setModuleName('interactiveFeatures');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Text::make()
                ->field('updated_at')
                ->customRender(function (InteractiveFeature $interactiveFeature) {
                    return $interactiveFeature->updated_at->format('M j, Y \a\t g:ia');
                })
        );

        return $columns;
    }

    public function quickFilters(): QuickFilters
    {
        $filters = parent::quickFilters();
        $filters->add(
            QuickFilter::make()
            ->queryString('archived')
            ->label('Archived')
            ->amount(fn () => $this->repository->archived()->count())
            ->apply(fn (Builder $query) => $query->archived())
        );

        return $filters;
    }
}
