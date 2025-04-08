<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\Filters\BasicFilter;
use A17\Twill\Services\Listings\Filters\TableFilters;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\BuildingClosure;
use Illuminate\Database\Eloquent\Builder;

class BuildingClosureController extends BaseController
{
    public function setUpController(): void
    {
        $this->setModuleName('buildingClosures');
        $this->setSearchColumns(['closure_copy']);
        $this->setTitleColumnKey('presentType');
        $this->setTitleColumnLabel('Type');
        $this->setTitleFormKey('cmsFormTitle');
    }

    public function filters(): TableFilters
    {
        $tableFilters = parent::filters();
        $tableFilters->add(
            BasicFilter::make()
                ->queryString('types')
                ->options(collect(BuildingClosure::$types))
                ->apply(function (Builder $builder, mixed $value) {
                    $builder->where('type', '=', $value);
                })
        );

        return $tableFilters;
    }

    public function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Text::make()
                ->field('date_start')
                ->title('Start Date')
                ->sortable()
                ->sortByDefault(direction: 'desc')
                ->customRender(function (BuildingClosure $closure): string {
                    return $closure->date_start->format('M j, Y');
                })
        );
        $columns->add(
            Text::make()
                ->field('date_end')
                ->title('End Date')
                ->sortable()
                ->customRender(function (BuildingClosure $closure): string {
                    return $closure->date_end->format('M j, Y');
                })
        );
        $columns->add(
            Text::make()
                ->field('closure_copy')
                ->customRender(function (BuildingClosure $closure): string {
                    $closure_copy = $closure->closure_copy;
                    $closure_copy = str_replace('<p>', ' ', $closure_copy);
                    $closure_copy = str_replace('</p>', ' ', $closure_copy);

                    return $closure_copy;
                })
        );

        return $columns;
    }

    protected function indexData($request)
    {
        return [
            'typesList' => collect(BuildingClosure::$types),
        ];
    }

    protected function formData($request)
    {
        return [
            'typesList' => collect(BuildingClosure::$types),
            'editableTitle' => false,
        ];
    }
}
