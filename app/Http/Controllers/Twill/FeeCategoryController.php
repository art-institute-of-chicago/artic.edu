<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;

class FeeCategoryController extends BaseController
{
    public function setUpController(): void
    {
        parent::setUpController();
        $this->disableBulkPublish();
        $this->disablePublish();
        $this->enableReorder();
        $this->setModuleName('feeCategories');
        $this->setSearchColumns(['title', 'tooltip']);
    }

    public function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Text::make()
                ->title('Tooltip')
                ->field('tooltip')
                ->sortable()
        );

        return $columns;
    }
}
