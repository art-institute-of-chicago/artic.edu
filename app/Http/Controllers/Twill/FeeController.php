<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\Columns\Relation;

class FeeController extends \App\Http\Controllers\Twill\ModuleController
{
    protected function setUpController(): void
    {
        $this->disablePermalink();
        $this->disablePublish();
        $this->enableEditInModal();
        $this->setModuleName('fees');
        $this->setTitleColumnKey('fee_category.title');
        $this->setTitleColumnLabel('Category');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = new TableColumns();
        $columns->add(
            Relation::make()
                ->field('title')
                ->title('Age')
                ->relation('fee_age')
        );

        $columns->add(
            Text::make()
                ->title('Price')
                ->field('price')
                ->optional()
        );

        return $columns;
    }
}
