<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;

class SearchTermController extends BaseController
{
    protected function setUpController(): void
    {
        $this->disablePermalink();
        $this->disablePublish();
        $this->enableReorder();
        $this->setModuleName('searchTerms');
        $this->setTitleColumnKey('name');
        $this->setTitleColumnLabel('Name');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Text::make()
                ->field('direct_url')
                ->title('Direct URL')
        );

        return $columns;
    }
}
