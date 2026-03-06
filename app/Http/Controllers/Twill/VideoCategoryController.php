<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use A17\Twill\Services\Listings\Columns\Relation;
use A17\Twill\Services\Listings\TableColumns;

class VideoCategoryController extends BaseModuleController
{
    protected function setUpController(): void
    {
        $this->disableBulkPublish();
        $this->disablePermalink();
        $this->disablePublish();

        $this->setTitleColumnKey('name');
        $this->setTitleColumnLabel('Name');
        $this->setModuleName('videoCategories');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Relation::make()
                ->title('Videos')
                ->field('title')
                ->relation('videos')
                ->optional()
                ->hide()
        );

        return $columns;
    }
}
