<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\BuildingClosure;

class BuildingClosureController extends BaseController
{
    public function setUpController(): void
    {
        $this->setModuleName('buildingClosures');
        $this->setSearchColumns(['closure_copy']);
        $this->setTitleColumnLabel('Closure');
        $this->setTitleFormKey('title');
    }

    public function getIndexTableColumns(): TableColumns
    {
        $columns = parent::getIndexTableColumns();
        $titleColumn = $columns->slice(1, 1)->first();
        $titleColumn->sortKey('date_start');
        return $columns;
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
}
