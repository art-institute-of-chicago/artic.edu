<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;

class ShopItemController extends BaseApiController
{
    protected function setUpController(): void
    {
        $this->enableAugmentedModel();
        $this->disablePublish();
        $this->setModuleName('shopItems');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Text::make()
                ->field('description')
                ->title('Description')
        );

        return $columns;
    }
}
