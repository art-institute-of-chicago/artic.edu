<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;

class ResourceCategoryController extends BaseController
{
    protected function setUpController(): void
    {
        $this->disablePermalink();
        $this->disablePublish();
        $this->enableEditInModal();
        $this->enableReorder();
        $this->setModuleName('resourceCategories');
        $this->setTitleColumnKey('name');
        $this->setTitleColumnLabel('Name');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();

        $columns->add(
            Text::make()
                ->field('position')
                ->title('Position')
                ->sortable()
        );

        $columns->add(
            Text::make()
                ->field('type')
                ->sortable()
        );

        return $columns;
    }

    protected function indexQuery($query)
    {
        return $query->orderBy('position', 'asc');
    }
}