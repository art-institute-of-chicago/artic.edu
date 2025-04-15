<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\Hour;

class HourController extends BaseController
{
    public function setUpController(): void
    {
        $this->setModuleName('hours');
    }

    public function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Text::make()
                ->field('type')
                ->sortable()
                ->customRender(function (Hour $hour): string {
                    return Hour::$types[$hour->type];
                })
        );
        $columns->add(
            Text::make()
                ->field('url')
                ->title('Link URL')
                ->sortable()
        );
        $columns->add(
            Text::make()
                ->field('valid_from')
                ->sortable()
                ->sortByDefault(direction: 'desc')
                ->customRender(function (Hour $hour) {
                    return $hour->valid_from->format('M j, Y');
                })
        );
        $columns->add(
            Text::make()
                ->field('valid_through')
                ->sortable()
                ->customRender(function (Hour $hour) {
                    return $hour->valid_through->format('M j, Y');
                })
        );

        return $columns;
    }

    protected function indexData($request)
    {
        return [
            'types' => collect(Hour::$types)->sort(),
        ];
    }

    protected function formData($request)
    {
        return [
            'types' => collect(Hour::$types)->sort(),
        ];
    }
}
